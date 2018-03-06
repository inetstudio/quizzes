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
            'id' => (int) $item->getAttribute('id'),
            'title' => $item->getAttribute('title'),
            'type' => $item->getAttribute('quiz_type'),
            'created_at' => (string) $item->getAttribute('created_at'),
            'updated_at' => (string) $item->getAttribute('updated_at'),
            'actions' => view('admin.module.quizzes::back.partials.datatables.actions', [
                'id' => $item->getAttribute('id'),
            ])->render(),
        ];
    }
}
