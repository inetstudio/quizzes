<?php

namespace InetStudio\Quizzes\Transformers\Back;

use League\Fractal\TransformerAbstract;
use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\Quizzes\Contracts\Transformers\Back\QuizTransformerContract;

/**
 * Class QuizTransformer.
 */
class QuizTransformer extends TransformerAbstract implements QuizTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param QuizModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(QuizModelContract $item)
    {
        return [
            'id' => (int) $item->id,
            'title' => $item->title,
            'type' => $item->quiz_type,
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
            'actions' => view('admin.module.quizzes::back.partials.datatables.actions', [
                'id' => $item->id,
            ])->render(),
        ];
    }
}
