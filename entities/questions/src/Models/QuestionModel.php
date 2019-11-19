<?php

namespace InetStudio\QuizzesPackage\Questions\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\QuizzesPackage\Answers\Contracts\Models\AnswerModelContract;
use InetStudio\QuizzesPackage\Questions\Contracts\Models\QuestionModelContract;

/**
 * Class QuestionModel.
 */
class QuestionModel extends Model implements QuestionModelContract
{
    use Auditable;
    use HasImages;
    use SoftDeletes;
    use BuildQueryScopeTrait;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'quizzes_question';

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
        'model' => 'question',
    ];

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'quizzes_questions';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'quiz_id', 'title',
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

        self::deleting(function (QuestionModelContract $question) {
            $question->answers()->get()->each(function (AnswerModelContract $answer) {
                $answer->delete();
            });
        });

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'quiz_id',
            'title',
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
     * Сеттер атрибута title.
     *
     * @param $value
     */
    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = trim(strip_tags($value));
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
     * Отношение "один ко многим" с моделью ответов.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function answers(): HasMany
    {
        $answerModel = app()->make('InetStudio\QuizzesPackage\Answers\Contracts\Models\AnswerModelContract');

        return $this->hasMany(
            $answerModel,
            'quiz_question_id',
            'id'
        );
    }
}
