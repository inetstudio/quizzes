<?php

namespace InetStudio\QuizzesPackage\Quizzes\Transformers\Back\Resource;

use Throwable;
use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Transformers\Back\Resource\IndexTransformerContract;

/**
 * Class IndexTransformer.
 */
class IndexTransformer extends BaseTransformer implements IndexTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param QuizModelContract $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(QuizModelContract $item): array
    {
        return [
            'id' => (int) $item['id'],
            'title' => $item['title'],
            'type' => $item['quiz_type'],
            'created_at' => (string) $item['created_at'],
            'updated_at' => (string) $item['updated_at'],
            'actions' => view(
                'admin.module.quizzes-package.quizzes::back.partials.datatables.actions',
                [
                    'id' => $item['id']
                ]
            )->render(),
        ];
    }
}
