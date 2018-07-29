<?php

namespace InetStudio\Quizzes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use Venturecraft\Revisionable\RevisionableTrait;
use InetStudio\Quizzes\Contracts\Models\AnswerModelContract;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

/**
 * Class AnswerModel.
 */
class AnswerModel extends Model implements AnswerModelContract, HasMediaConversions
{
    use HasImages;
    use SoftDeletes;
    use RevisionableTrait;

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

    protected $revisionCreationsEnabled = true;

    /**
     * Загрузка модели.
     */
    public static function boot()
    {
        parent::boot();

        self::deleting(function ($answer) {
            $answer->results()->sync([]);
        });
    }

    /**
     * Обратное отношение "один ко многим" с моделью вопроса.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(
            app()->make('InetStudio\Quizzes\Contracts\Models\QuestionModelContract'),
            'quiz_question_id'
        );
    }

    /**
     * Отношение "многие ко многим" с моделью результата.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function results()
    {
        return $this->belongsToMany(
            app()->make('InetStudio\Quizzes\Contracts\Models\ResultModelContract'),
            'quizzes_results_answers',
            'answer_id',
            'result_id'
        )->withPivot('association')->withTimestamps();
    }
}
