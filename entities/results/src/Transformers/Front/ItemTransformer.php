<?php

namespace InetStudio\QuizzesPackage\Results\Transformers\Front;

use Exception;
use League\Fractal\Resource\Item;
use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\QuizzesPackage\Results\Contracts\Models\ResultModelContract;
use InetStudio\QuizzesPackage\Results\Contracts\Transformers\Front\ItemTransformerContract;

/**
 * Class ItemTransformer.
 */
class ItemTransformer extends BaseTransformer implements ItemTransformerContract
{
    /**
     * @var array
     */
    protected array $defaultIncludes = [
        'preview', 'quiz',
    ];

    /**
     * Подготовка данных.
     *
     * @param ResultModelContract $item
     *
     * @return array
     *
     * @throws Exception
     */
    public function transform(ResultModelContract $item)
    {
        $quiz = $item['quiz'];

        $result = '';
        switch ($quiz->result_type) {
            case 'full':
                $result = $item['full_description'];
                break;

            case 'short_email':
                $result = $item['short_description'];
                break;
        }

        return [
            'id' => (int) $item['id'],
            'type' => $quiz['result_type'],
            'title' => $item['title'],
            'quizTitle' => $quiz['title'],
            'result' => blade_string($result),
        ];
    }

    /**
     * Включаем превью в трансформацию.
     *
     * @param  ResultModelContract  $item
     *
     * @return Item
     *
     * @throws BindingResolutionException
     */
    public function includePreview(ResultModelContract $item): Item
    {
        $transformer = $this->getTransformer('InetStudio\QuizzesPackage\Results\Transformers\Front\PreviewTransformer');

        return $this->item($item, $transformer);
    }

    /**
     * Включаем тест в трансформацию.
     *
     * @param  ResultModelContract  $item
     *
     * @return Item
     *
     * @throws BindingResolutionException
     */
    public function includeQuiz(ResultModelContract $item): Item
    {
        $transformer = $this->getTransformer('InetStudio\QuizzesPackage\Quizzes\Transformers\Front\ItemTransformer');

        return $this->item($item['quiz'], $transformer);
    }
}
