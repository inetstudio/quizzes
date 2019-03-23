<?php

namespace InetStudio\Quizzes\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use InetStudio\Quizzes\Contracts\Models\ResultModelContract;

/**
 * Class ResultModel.
 */
class ResultModel extends Model implements ResultModelContract, HasMedia, Auditable
{
    use HasImages;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

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
        'quiz_id', 'min_points', 'max_points',
        'title', 'short_description', 'full_description',
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

        self::deleting(function ($result) {
            $result->answers()->sync([]);
        });
    }

    /**
     * Обратное отношение "один ко многим" с моделью теста.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quiz()
    {
        return $this->belongsTo(
            app()->make('InetStudio\Quizzes\Contracts\Models\QuizModelContract'),
            'quiz_id'
        );
    }

    /**
     * Отношение "многие ко многим" с моделью ответа.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function answers()
    {
        return $this->belongsToMany(
            AnswerModel::class,
            'quizzes_results_answers',
            'result_id',
            'answer_id'
        )->withPivot('association')->withTimestamps();
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
            'result_id', 'id'
        );
    }
}
