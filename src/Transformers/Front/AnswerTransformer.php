<?php

namespace InetStudio\Quizzes\Transformers\Front;

use League\Fractal\TransformerAbstract;
use InetStudio\Quizzes\Contracts\Models\AnswerModelContract;
use InetStudio\Quizzes\Contracts\Transformers\Front\AnswerTransformerContract;

/**
 * Class AnswerTransformer.
 */
class AnswerTransformer extends TransformerAbstract implements AnswerTransformerContract
{
    private $services = [];

    /**
     * AnswerTransformer constructor.
     */
    public function __construct()
    {
        $this->services['images'] = app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract');
    }

    /**
     * Подготовка данных.
     *
     * @param AnswerModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(AnswerModelContract $item)
    {
        return [
            'id' => (int) $item->getAttribute('id'),
            'answer' => $item->getAttribute('title'),
            'description' => blade_string($item->getAttribute('description')),
            'points' => (int) $item->getAttribute('points'),
            'img' => [
                'src' => $this->services['images']->getFirstCropImageUrl($item, 'preview'),
                'properties' => $this->services['images']->getImageProperties($item, 'preview'),
            ],
        ];
    }
}
