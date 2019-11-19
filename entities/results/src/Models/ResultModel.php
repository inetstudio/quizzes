<?php

namespace InetStudio\QuizzesPackage\Results\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\QuizzesPackage\Results\Contracts\Models\ResultModelContract;

/**
 * Class ResultModel.
 */
class ResultModel extends Model implements ResultModelContract
{
    use Auditable;
    use HasImages;
    use SoftDeletes;
    use BuildQueryScopeTrait;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'quizzes_result';

    /**
     * Should the timestamps be audited?
     *
     * @var bool
     */
    protected $auditTimestamps = true;

    /**
     * Настройки для генерации изображений.
     *
     * @var array
     */
    protected $images = [
        'config' => 'quizzes',
        'model' => 'result',
    ];

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'quizzes_results';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'quiz_id',
        'min_points',
        'max_points',
        'title',
        'short_description',
        'full_description',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Загрузка модели.
     */
    public static function boot()
    {
        parent::boot();

        self::deleting(function ($result) {
            $result->answers()->sync([]);
        });

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'quiz_id',
            'min_points',
            'max_points',
            'title',
            'short_description',
            'full_description',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'media' => function ($query) {
                $query->select(['id', 'model_id', 'model_type', 'collection_name', 'file_name', 'disk']);
            },
            'quiz' => function ($query) {
                $query->select(['id', 'title', 'description', 'quiz_type', 'result_type']);
            },
            'answers' => function ($query) {
                $query->select(['id', 'quiz_question_id', 'title', 'description', 'points']);
            },
        ];
    }

    /**
     * Сеттер атрибута quiz_id.
     *
     * @param $value
     */
    public function setQuizIdAttribute($value): void
    {
        $this->attributes['quiz_id'] = (int) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута min_points.
     *
     * @param $value
     */
    public function setMinPointsAttribute($value): void
    {
        $this->attributes['min_points'] = (int) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута max_points.
     *
     * @param $value
     */
    public function setMaxPointsAttribute($value): void
    {
        $this->attributes['max_points'] = (int) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута title.
     *
     * @param $value
     */
    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута short_description.
     *
     * @param $value
     */
    public function setShortDescriptionAttribute($value): void
    {
        $value = (isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : '');

        $this->attributes['short_description'] = trim(str_replace('&nbsp;', ' ', $value));
    }

    /**
     * Сеттер атрибута full_description.
     *
     * @param $value
     */
    public function setFullDescriptionAttribute($value): void
    {
        $value = (isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : '');

        $this->attributes['full_description'] = trim(str_replace('&nbsp;', ' ', $value));
    }

    /**
     * Геттер атрибута type.
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return self::ENTITY_TYPE;
    }

    /**
     * Обратное отношение "один ко многим" с моделью теста.
     *
     * @return BelongsTo
     *
     * @throws BindingResolutionException
     */
    public function quiz(): BelongsTo
    {
        $quizModel = app()->make('InetStudio\QuizzesPackage\Quizzes\Contracts\Models\QuizModelContract');

        return $this->belongsTo(
            get_class($quizModel),
            'quiz_id'
        );
    }

    /**
     * Отношение "многие ко многим" с моделью ответа.
     *
     * @return BelongsToMany
     *
     * @throws BindingResolutionException
     */
    public function answers(): BelongsToMany
    {
        $answerModel = app()->make('InetStudio\QuizzesPackage\Answers\Contracts\Models\AnswerModelContract');

        return $this->belongsToMany(
            get_class($answerModel),
            'quizzes_results_answers',
            'result_id',
            'answer_id'
        )
            ->withPivot('association')
            ->withTimestamps();
    }

    /**
     * Отношение "один ко многим" с моделью результатов пользователей.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users_results()
    {
        return $this->hasMany(
            app()->make('InetStudio\QuizzesPackage\Results\Contracts\Models\UserResultModelContract'),
            'result_id', 'id'
        );
    }
}
