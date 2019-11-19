<?php

namespace InetStudio\QuizzesPackage\Quizzes\Transformers\Front;

use Exception;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Transformers\Front\ItemTransformerContract;

/**
 * Class ItemTransformer.
 */
class ItemTransformer extends BaseTransformer implements ItemTransformerContract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'preview', 'questions',
    ];

    /**
     * Подготовка данных.
     * 
     * @param  QuizModelContract  $item
     *
     * @return array
     * 
     * @throws Exception
     */
    public function transform(QuizModelContract $item)
    {
        return [
            'id' => (int) $item['id'],
            'type' => $item['quiz_type'],
            'title' => $item['title'],
            'description' => blade_string($item['description']),
        ];
    }

    /**
     * Включаем превью в трансформацию.
     *
     * @param  QuizModelContract  $item
     *
     * @return Item
     *
     * @throws BindingResolutionException
     */
    public function includePreview(QuizModelContract $item): Item
    {
        $transformer = $this->getTransformer('InetStudio\QuizzesPackage\Quizzes\Transformers\Front\PreviewTransformer');

        return $this->item($item, $transformer);
    }

    /**
     * Включаем вопросы в трансформацию.
     * 
     * @param  QuizModelContract  $item
     *
     * @return FractalCollection
     * 
     * @throws BindingResolutionException
     */
    public function includeQuestions(QuizModelContract $item): FractalCollection
    {
        $transformer = $this->getTransformer('InetStudio\QuizzesPackage\Quizzes\Transformers\Front\QuestionTransformer');
        
        return new FractalCollection($item['questions'], $transformer);
    }
}
