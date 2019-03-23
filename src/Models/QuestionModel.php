<?php

namespace InetStudio\Quizzes\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use InetStudio\Quizzes\Contracts\Models\AnswerModelContract;
use InetStudio\Quizzes\Contracts\Models\QuestionModelContract;

/**
 * Class QuestionModel.
 */
class QuestionModel extends Model implements QuestionModelContract, HasMedia, Auditable
{
    use HasImages;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

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

        self::deleting(function (QuestionModelContract $question) {
            $question->answers()->get()->each(function (AnswerModelContract $answer) {
                $answer->delete();
            });
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
     * Отношение "один ко многим" с моделью ответов.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(
            app()->make('InetStudio\Quizzes\Contracts\Models\AnswerModelContract'),
            'quiz_question_id',
            'id'
        );
    }
}
