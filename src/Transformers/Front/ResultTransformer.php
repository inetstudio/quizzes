<?php

namespace InetStudio\Quizzes\Transformers\Front;

use League\Fractal\TransformerAbstract;
use InetStudio\Quizzes\Contracts\Models\ResultModelContract;
use InetStudio\Quizzes\Contracts\Transformers\Front\ResultTransformerContract;

/**
 * Class ResultTransformer.
 */
class ResultTransformer extends TransformerAbstract implements ResultTransformerContract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'quiz',
    ];

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
        $quiz = $item->getAttribute('quiz');

        $result = '';
        switch ($quiz->result_type) {
            case 'full':
                $result = $item->getAttribute('full_description');
                break;

            case 'short_email':
                $result = $item->getAttribute('short_description');
                break;
        }

        return [
            'id' => (int) $item->getAttribute('id'),
            'title' => $item->getAttribute('quiz_type'),
            'result' => $result,
            'img' => $this->services['images']->getFirstCropImageUrl($item, 'preview'),
        ];
    }

    /**
     * Включаем тест в трасформацию.
     *
     * @param ResultModelContract $item
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeAnswers(ResultModelContract $item)
    {
        return $this->item($item->getAttribute('quiz'), app()->make('InetStudio\Quizzes\Transformers\Front\QuizTransformer'));
    }
}
