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
            'id' => (int) $item->id,
            'answer' => $item->title,
            'description' => $item->description,
            'points' => (int) $item->points,
            'img' => $this->services['images']->getFirstCropImageUrl($item, 'preview'),
        ];
    }
}
