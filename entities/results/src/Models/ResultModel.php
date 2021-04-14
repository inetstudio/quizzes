<?php

namespace InetStudio\QuizzesPackage\Results\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use InetStudio\WidgetsPackage\Widgets\Models\Traits\HasWidgets;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\QuizzesPackage\Results\Contracts\Models\ResultModelContract;

class ResultModel extends Model implements ResultModelContract
{
    use Auditable;
    use HasImages;
    use HasWidgets;
    use SoftDeletes;
    use BuildQueryScopeTrait;

    const ENTITY_TYPE = 'quizzes_result';

    protected bool $auditTimestamps = true;

    protected $images = [
        'config' => 'quizzes',
        'model' => 'result',
    ];

    protected $table = 'quizzes_results';

    protected $fillable = [
        'quiz_id',
        'min_points',
        'max_points',
        'title',
        'short_description',
        'full_description',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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
                $query->select(['id', 'model_id', 'model_type', 'collection_name', 'file_name', 'disk', 'conversions_disk', 'uuid']);
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

    public function getTypeAttribute(): string
    {
        return self::ENTITY_TYPE;
    }

    public function quiz(): BelongsTo
    {
        $quizModel = resolve('InetStudio\QuizzesPackage\Quizzes\Contracts\Models\QuizModelContract');

        return $this->belongsTo(
            get_class($quizModel),
            'quiz_id'
        );
    }

    public function answers(): BelongsToMany
    {
        $answerModel = resolve('InetStudio\QuizzesPackage\Answers\Contracts\Models\AnswerModelContract');

        return $this->belongsToMany(
                get_class($answerModel),
                'quizzes_results_answers',
                'result_id',
                'answer_id'
            )
            ->withPivot('association')
            ->withTimestamps();
    }

    public function users_results(): HasMany
    {
        $userResultModel = resolve('InetStudio\QuizzesPackage\Results\Contracts\Models\UserResultModelContract');

        return $this->hasMany(
            get_class($userResultModel),
            'result_id',
            'id'
        );
    }

    public function tags(): BelongsToMany
    {
        $tagModel = resolve('InetStudio\QuizzesPackage\Tags\Contracts\Models\TagModelContract');

        return $this->belongsToMany(
            get_class($tagModel),
            'quizzes_results_tags',
            'result_id',
            'tag_id'
        )->withTimestamps();
    }
}
