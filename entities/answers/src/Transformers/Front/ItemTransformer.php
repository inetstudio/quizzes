<?php

namespace InetStudio\QuizzesPackage\Answers\Transformers\Front;

use Exception;
use League\Fractal\Resource\Item;
use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\QuizzesPackage\Answers\Contracts\Models\AnswerModelContract;
use InetStudio\QuizzesPackage\Answers\Contracts\Transformers\Front\ItemTransformerContract;

/**
 * Class ItemTransformer.
 */
class ItemTransformer extends BaseTransformer implements ItemTransformerContract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'preview',
    ];

    /**
     * Подготовка данных.
     *
     * @param AnswerModelContract $item
     *
     * @return array
     *
     * @throws Exception
     */
    public function transform(AnswerModelContract $item)
    {
        return [
            'id' => (int) $item['id'],
            'answer' => $item['title'],
            'description' => blade_string($item['description']),
            'points' => (int) $item['points'],
        ];
    }

    /**
     * Включаем превью в трансформацию.
     *
     * @param  AnswerModelContract  $item
     *
     * @return Item
     *
     * @throws BindingResolutionException
     */
    public function includePreview(AnswerModelContract $item): Item
    {
        $transformer = $this->getTransformer('InetStudio\QuizzesPackage\Answers\Transformers\Front\PreviewTransformer');

        return $this->item($item, $transformer);
    }
}
