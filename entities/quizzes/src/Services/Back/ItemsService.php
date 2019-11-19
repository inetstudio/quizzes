<?php

namespace InetStudio\QuizzesPackage\Quizzes\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  QuizModelContract  $model
     */
    public function __construct(QuizModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return QuizModelContract
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, int $id): QuizModelContract
    {
        $action = ($id) ? 'отредактирован' : 'создан';

        $itemData = Arr::only($data, $this->model->getFillable());
        $item = $this->saveModel($itemData, $id);

        $images = collect(config('quizzes.images.conversions.quiz'))->map(function ($item, $key) {
            return $key;
        })->toArray();

        app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract')
            ->attachToObject(request(), $item, $images, 'quizzes', 'quiz');

        $resultsData = $data['result'] ?? [];
        $results = app()->make('InetStudio\QuizzesPackage\Results\Contracts\Services\Back\ItemsServiceContract')
            ->save($resultsData, $item['id']);

        $questionsData = $data['question'] ?? [];
        $questions = app()->make('InetStudio\QuizzesPackage\Questions\Contracts\Services\Back\ItemsServiceContract')
            ->save($questionsData, $item['id']);

        $answerData = $data['answer'] ?? [];
        app()->make('InetStudio\QuizzesPackage\Answers\Contracts\Services\Back\ItemsServiceContract')
            ->save($answerData, $questions, $results);

        event(
            app()->make(
                'InetStudio\QuizzesPackage\Quizzes\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        Session::flash('success', 'Тест «'.$item->title.'» успешно '.$action);

        return $item;
    }
}
