<?php

namespace InetStudio\Quizzes\Transformers\Front;

use League\Fractal\TransformerAbstract;
use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Quizzes\Contracts\Transformers\Front\QuizTransformerContract;

/**
 * Class QuizTransformer.
 */
class QuizTransformer extends TransformerAbstract implements QuizTransformerContract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'questions',
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
            'id' => (int) $item->id,
            'type' => $item->quiz_type,
            'title' => $item->title,
            'description' => $item->description,
            'img' => $this->services['images']->getFirstCropImageUrl($item, 'preview'),
        ];
    }

    /**
     * Включаем вопросы в трасформацию.
     *
     * @param QuizModelContract $item
     *
     * @return FractalCollection
     */
    public function includeQuestions(QuizModelContract $item)
    {
        return new FractalCollection($item->questions, app()->make('InetStudio\Quizzes\Transformers\Front\QuestionTransformer'));
    }
}
