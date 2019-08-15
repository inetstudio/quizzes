<?php

namespace InetStudio\Quizzes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\Quizzes\Contracts\Models\ResultModelContract;
use InetStudio\Quizzes\Contracts\Models\QuestionModelContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;

/**
 * Class QuizModel.
 */
class QuizModel extends Model implements QuizModelContract, HasMedia, Auditable
{
    use HasImages;
    use Notifiable;
    use SoftDeletes;
    use BuildQueryScopeTrait;
    use \OwenIt\Auditing\Auditable;

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
        'title', 'description', 'quiz_type', 'result_type',
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
     * Should the timestamps be audited?
     *
     * @var bool
     */
    protected $auditTimestamps = true;

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
            'id', 'title', 'quiz_type', 'description',
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
                        'mime_type',
                        'custom_properties',
                        'responsive_images',
                    ]
                );
            },
        ];
    }

    /**
     * Отношение "один ко многим" с моделью вопросов.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(
            app()->make('InetStudio\Quizzes\Contracts\Models\QuestionModelContract'),
            'quiz_id', 'id'
        );
    }

    /**
     * Отношение "один ко многим" с моделью результатов.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany(
            app()->make('InetStudio\Quizzes\Contracts\Models\ResultModelContract'),
            'quiz_id',
            'id'
        );
    }

    /**
     * Отношение "один ко многим" с моделью результатов пользователей.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users_results()
    {
        return $this->hasMany(
            app()->make('InetStudio\Quizzes\Contracts\Models\UserResultModelContract'),
            'quiz_id', 'id'
        );
    }
}
