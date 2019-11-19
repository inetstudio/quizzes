<?php

namespace InetStudio\QuizzesPackage\Questions\Transformers\Front;

use League\Fractal\Resource\Item;
use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use League\Fractal\Resource\Collection as FractalCollection;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\QuizzesPackage\Questions\Contracts\Models\QuestionModelContract;
use InetStudio\QuizzesPackage\Questions\Contracts\Transformers\Front\ItemTransformerContract;

/**
 * Class ItemTransformer.
 */
class ItemTransformer extends BaseTransformer implements ItemTransformerContract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'preview', 'answers',
    ];

    /**
     * Подготовка данных.
     *
     * @param QuestionModelContract $item
     *
     * @return array
     */
    public function transform(QuestionModelContract $item): array
    {
        return [
            'id' => (int) $item['id'],
            'question' => $item['title'],
        ];
    }

    /**
     * Включаем превью в трансформацию.
     *
     * @param  QuestionModelContract  $item
     *
     * @return Item
     *
     * @throws BindingResolutionException
     */
    public function includePreview(QuestionModelContract $item): Item
    {
        $transformer = $this->getTransformer('InetStudio\QuizzesPackage\Questions\Transformers\Front\PreviewTransformer');

        return $this->item($item, $transformer);
    }

    /**
     * Включаем ответы в трансформацию.
     *
     * @param  QuestionModelContract  $item
     *
     * @return FractalCollection
     *
     * @throws BindingResolutionException
     */
    public function includeAnswers(QuestionModelContract $item)
    {
        $transformer = $this->getTransformer('InetStudio\QuizzesPackage\Answers\Transformers\Front\ItemTransformer');

        return new FractalCollection($item['answers'], $transformer);
    }
}
