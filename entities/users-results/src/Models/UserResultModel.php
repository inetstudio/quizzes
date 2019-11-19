<?php

namespace InetStudio\QuizzesPackage\UsersResults\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\QuizzesPackage\UsersResults\Contracts\Models\UserResultModelContract;

/**
 * Class UserResultModel.
 */
class UserResultModel extends Model implements UserResultModelContract
{
    use BuildQueryScopeTrait;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'quizzes_user_result';

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'quizzes_users_results';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'hash',
        'quiz_id',
        'result_id',
        'points',
        'email',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Загрузка модели.
     */
    public static function boot()
    {
        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'hash',
            'quiz_id',
            'result_id',
            'points',
            'email',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'quiz' => function ($query) {
                $query->select(['id', 'title', 'description', 'quiz_type', 'result_type']);
            },
            'result' => function ($query) {
                $query->select([
                    'id',
                    'quiz_id',
                    'min_points',
                    'max_points',
                    'title',
                    'short_description',
                    'full_description',
                ]);
            },
        ];
    }

    /**
     * Сеттер атрибута hash.
     *
     * @param $value
     */
    public function setHashAttribute($value): void
    {
        $this->attributes['hash'] = trim(strip_tags($value));
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
     * Сеттер атрибута result_id.
     *
     * @param $value
     */
    public function setResultIdAttribute($value): void
    {
        $this->attributes['result_id'] = (int) trim(strip_tags($value));
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
     * Сеттер атрибута email.
     *
     * @param $value
     */
    public function setEmailAttribute($value): void
    {
        $this->attributes['email'] = trim(strip_tags($value));
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
     * Обратное отношение "один ко многим" с моделью результата.
     *
     * @return BelongsTo
     *
     * @throws BindingResolutionException
     */
    public function result(): BelongsTo
    {
        $resultModel = app()->make('InetStudio\QuizzesPackage\Results\Contracts\Models\ResultModelContract');

        return $this->belongsTo(
            get_class($resultModel),
            'result_id'
        );
    }
}
