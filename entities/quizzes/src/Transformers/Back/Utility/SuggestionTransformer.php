<?php

namespace InetStudio\QuizzesPackage\Quizzes\Transformers\Back\Utility;

use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Transformers\Back\Utility\SuggestionTransformerContract;

/**
 * Class SuggestionTransformer.
 */
class SuggestionTransformer extends BaseTransformer implements SuggestionTransformerContract
{
    /**
     * @var string
     */
    protected $type;

    /**
     * Устанавливаем тип.
     *
     * @param  string  $type
     */
    public function setType(string $type = ''): void
    {
        $this->type = $type;
    }

    /**
     * Подготовка данных для отображения в выпадающих списках.
     *
     * @param QuizModelContract $item
     *
     * @return array
     */
    public function transform(QuizModelContract $item): array
    {
        return ($this->type == 'autocomplete')
            ? [
                'value' => $item['title'],
                'data' => [
                    'id' => $item['id'],
                    'type' => get_class($item),
                    'title' => $item['title'],
                ],
            ]
            : [
                'id' => $item['id'],
                'name' => $item['title'],
            ];
    }
}
