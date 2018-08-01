<?php

namespace InetStudio\Quizzes\Transformers\Front\Feeds\Mindbox;

use League\Fractal\TransformerAbstract;
use InetStudio\Quizzes\Contracts\Models\ResultModelContract;
use InetStudio\Quizzes\Contracts\Transformers\Front\Feeds\Mindbox\ResultTransformerContract;

/**
 * Class ResultTransformer.
 */
class ResultTransformer extends TransformerAbstract implements ResultTransformerContract
{
    private $services = [];

    /**
     * ResultTransformer constructor.
     */
    public function __construct()
    {
        $this->services['images'] = app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract');
    }

    /**
     * Подготовка данных.
     *
     * @param ResultModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(ResultModelContract $item)
    {
        return [
            'id' => (int) $item->getAttribute('id'),
            'title' => $item->getAttribute('title'),
            'result' => blade_string($item->getAttribute('full_description')),
            'img' => [
                'src' => $this->services['images']->getFirstCropImageUrl($item, 'preview'),
                'properties' => $this->services['images']->getImageProperties($item, 'preview'),
            ],
        ];
    }
}
