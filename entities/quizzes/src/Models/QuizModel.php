<?php

namespace InetStudio\QuizzesPackage\Quizzes\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\QuizzesPackage\Results\Contracts\Models\ResultModelContract;
use InetStudio\QuizzesPackage\Questions\Contracts\Models\QuestionModelContract;

/**
 * Class QuizModel.
 */
class QuizModel extends Model implements QuizModelContract
{
    use Auditable;
    use HasImages;
    use SoftDeletes;
    use BuildQueryScopeTrait;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'quiz';

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
        'model' => 'quiz',
    ];

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'quizzes';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'quiz_type',
        'result_type',
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

        self::deleting(function (QuizModelContract $quiz) {
            $quiz->questions()->get()->each(function (QuestionModelContract $question) {
                $question->delete();
            });

            $quiz->results()->get()->each(function (ResultModelContract $result) {
                $result->delete();
            });
        });

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'title',
            'quiz_type',
            'description',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'media' => function (MorphMany $mediaQuery) {
                $mediaQuery->select(
                    [
                        'id',
                        'model_id',
                        'model_type',
                        'collection_name',
                        'file_name',
                        'disk',
                        'conversions_disk',
                        'uuid',
                        'mime_type',
                        'custom_properties',
                        'responsive_images',
                    ]
                );
            },

            'results' => function ($query) {
                $query->select([
                    'id',
                    'quiz_id',
                    'min_points',
                    'max_points',
                    'title',
                    'short_description',
                    'full_description'
                ]);
            },

            'questions' => function ($query) {
                $query->select(['id', 'quiz_id', 'title']);
            },

            'users_results' => function ($query) {
                $query->select([
                    'id',
                    'hash',
                    'quiz_id',
                    'result_id',
                    'points',
                    'email',
                ]);
            },
        ];
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
     * Сеттер атрибута quiz_type.
     *
     * @param $value
     */
    public function setQuizTypeAttribute($value): void
    {
        $this->attributes['quiz_type'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута result_type.
     *
     * @param $value
     */
    public function setResultTypeAttribute($value): void
    {
        $this->attributes['result_type'] = trim(strip_tags($value));
    }

    /**
     * Отношение "один ко многим" с моделью вопросов.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function questions(): HasMany
    {
        $questionModel = app()->make('InetStudio\QuizzesPackage\Questions\Contracts\Models\QuestionModelContract');

        return $this->hasMany(
            get_class($questionModel),
            'quiz_id',
            'id'
        );
    }

    /**
     * Отношение "один ко многим" с моделью результатов.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function results(): HasMany
    {
        $resultModel = app()->make('InetStudio\QuizzesPackage\Results\Contracts\Models\ResultModelContract');

        return $this->hasMany(
            get_class($resultModel),
            'quiz_id',
            'id'
        );
    }

    /**
     * Отношение "один ко многим" с моделью результатов пользователей.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function users_results(): HasMany
    {
        $userResultModel = app()->make('InetStudio\QuizzesPackage\UsersResults\Contracts\Models\UserResultModelContract');

        return $this->hasMany(
            get_class($userResultModel),
            'quiz_id',
            'id'
        );
    }
}
