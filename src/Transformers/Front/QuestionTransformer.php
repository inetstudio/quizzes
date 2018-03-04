<?php

namespace InetStudio\Quizzes\Transformers\Front;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Quizzes\Contracts\Models\QuestionModelContract;
use InetStudio\Quizzes\Contracts\Transformers\Front\QuestionTransformerContract;

/**
 * Class QuestionTransformer.
 */
class QuestionTransformer extends TransformerAbstract implements QuestionTransformerContract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'answers',
    ];

    private $services = [];

    /**
     * QuestionTransformer constructor.
     */
    public function __construct()
    {
        $this->services['images'] = app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract');
    }

    /**
     * Подготовка данных.
     *
     * @param QuestionModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(QuestionModelContract $item)
    {
        return [
            'id' => (int) $item->id,
            'question' => $item->title,
            'img' => $this->services['images']->getFirstCropImageUrl($item, 'preview'),
        ];
    }

    /**
     * Включаем ответы в трасформацию.
     *
     * @param QuestionModelContract $item
     *
     * @return FractalCollection
     */
    public function includeAnswers(QuestionModelContract $item)
    {
        return new FractalCollection($item->answers, app()->make('InetStudio\Quizzes\Transformers\Front\AnswerTransformer'));
    }
}
