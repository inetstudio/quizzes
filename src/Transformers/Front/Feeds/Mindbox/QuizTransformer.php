<?php

namespace InetStudio\Quizzes\Transformers\Front\Feeds\Mindbox;

use League\Fractal\TransformerAbstract;
use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Quizzes\Contracts\Transformers\Front\Feeds\Mindbox\QuizTransformerContract;

/**
 * Class QuizTransformer.
 */
class QuizTransformer extends TransformerAbstract implements QuizTransformerContract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'results',
    ];

    private $services = [];

    /**
     * QuizTransformer constructor.
     */
    public function __construct()
    {
        $this->services['images'] = app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract');
    }

    /**
     * Подготовка данных.
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
            'type' => $item->getAttribute('quiz_type'),
            'title' => $item->getAttribute('title'),
            'description' => $item->getAttribute('description'),
            'img' => [
                'src' => $this->services['images']->getFirstCropImageUrl($item, 'preview'),
                'properties' => $this->services['images']->getImageProperties($item, 'preview'),
            ],
        ];
    }

    /**
     * Включаем вопросы в трансформацию.
     *
     * @param QuizModelContract $item
     *
     * @return FractalCollection
     */
    public function includeResults(QuizModelContract $item)
    {
        return new FractalCollection(
            $item->getAttribute('results'),
            app()->make('InetStudio\Quizzes\Contracts\Transformers\Front\Feeds\Mindbox\ResultTransformerContract')
        );
    }

    /**
     * Обработка коллекции статей.
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
