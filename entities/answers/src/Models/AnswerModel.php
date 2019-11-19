<?php

namespace InetStudio\QuizzesPackage\Answers\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\QuizzesPackage\Answers\Contracts\Models\AnswerModelContract;

/**
 * Class AnswerModel.
 */
class AnswerModel extends Model implements AnswerModelContract
{
    use HasImages;
    use Auditable;
    use SoftDeletes;
    use BuildQueryScopeTrait;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'quizzes_answer';

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
        'model' => 'answer',
    ];

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'quizzes_answers';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'quiz_question_id', 'title', 'description', 'points',
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

        self::deleting(function ($answer) {
            $answer->results()->sync([]);
        });

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'quiz_question_id',
            'title',
            'description',
            'points',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'media' => function ($query) {
                $query->select(['id', 'model_id', 'model_type', 'collection_name', 'file_name', 'disk']);
            },
            'question' => function ($query) {
                $query->select(['id', 'quiz_id', 'title']);
            },
            'results' => function ($query) {
                $query->select(['id', 'quiz_id', 'min_points', 'max_points', 'title', 'short_description', 'full_description']);
            },
        ];
    }

    /**
     * Сеттер атрибута quiz_question_id.
     *
     * @param $value
     */
    public function setQuizQuestionIdAttribute($value): void
    {
        $this->attributes['quiz_question_id'] = (int) trim(strip_tags($value));
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
     * Сеттер атрибута description.
     *
     * @param $value
     */
    public function setDescriptionAttribute($value): void
    {
        $value = (isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : '');

        $this->attributes['description'] = trim(str_replace('&nbsp;', ' ', $value));
    }

    /**
     * Сеттер атрибута points.
     *
     * @param $value
     */
    public function setPointsAttribute($value): void
    {
        $this->attributes['points'] = (int) trim(strip_tags($value));
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
     * Обратное отношение "один ко многим" с моделью вопроса.
     *
     * @return BelongsTo
     *
     * @throws BindingResolutionException
     */
    public function question(): BelongsTo
    {
        $questionModel = app()->make('InetStudio\QuizzesPackage\Questions\Contracts\Models\QuestionModelContract');

        return $this->belongsTo(
            get_class($questionModel),
            'quiz_question_id'
        );
    }

    /**
     * Отношение "многие ко многим" с моделью результата.
     *
     * @return BelongsToMany
     *
     * @throws BindingResolutionException
     */
    public function results(): BelongsToMany
    {
        $resultModel = app()->make('InetStudio\QuizzesPackage\Results\Contracts\Models\ResultModelContract');

        return $this->belongsToMany(
                get_class($resultModel),
                'quizzes_results_answers',
                'answer_id',
                'result_id'
            )
            ->withPivot('association')
            ->withTimestamps();
    }
}
