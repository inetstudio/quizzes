<?php

namespace InetStudio\Quizzes\Models;

use Illuminate\Database\Eloquent\Model;
use InetStudio\Quizzes\Contracts\Models\UserResultModelContract;

/**
 * Class UserResultModel.
 */
class UserResultModel extends Model implements UserResultModelContract
{
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
        'quiz_id', 'result_id', 'email',
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
     * Обратное отношение "один ко многим" с моделью результата.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function result()
    {
        return $this->belongsTo(
            app()->make('InetStudio\Quizzes\Contracts\Models\ResultModelContract'),
            'result_id'
        );
    }
}
