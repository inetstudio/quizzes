<?php

namespace InetStudio\Quizzes\Transformers\Back;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\Quizzes\Contracts\Transformers\Back\SuggestionTransformerContract;

/**
 * Class SuggestionTransformer.
 */
class SuggestionTransformer extends TransformerAbstract implements SuggestionTransformerContract
{
    /**
     * @var string
     */
    private $type;

    /**
     * SuggestionTransformer constructor.
     *
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Подготовка данных для отображения в выпадающих списках.
     *
     * @param QuizModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(QuizModelContract $item): array
    {
        if ($this->type && $this->type == 'autocomplete') {
            $modelClass = get_class($item);

            return [
                'value' => $item->title,
                'data' => [
                    'id' => $item->id,
                    'type' => $modelClass,
                    'title' => $item->title,
                ],
            ];
        } else {
            return [
                'id' => $item->id,
                'name' => $item->title,
            ];
        }
    }

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection
    {
        return new FractalCollection($items, $this);
    }
}
