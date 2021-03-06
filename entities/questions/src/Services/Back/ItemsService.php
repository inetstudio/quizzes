<?php

namespace InetStudio\QuizzesPackage\Questions\Services\Back;

use Illuminate\Support\Arr;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\QuizzesPackage\Questions\Contracts\Models\QuestionModelContract;
use InetStudio\QuizzesPackage\Questions\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  QuestionModelContract  $model
     */
    public function __construct(QuestionModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем объекты.
     *
     * @param  array  $data
     * @param  int  $quizId
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, int $quizId): array
    {
        $data = $this->prepareData($data, $quizId);

        $ids = Arr::wrap(array_keys($data));

        $this->model->where('quiz_id', $quizId)->whereNotIn('id', $ids)->get()->each(function (
            QuestionModelContract $question
        ) {
            $this->destroy($question['id']);
        });

        $questions = [];

        foreach ($ids as $id) {
            $itemData = Arr::only($data[$id], $this->model->getFillable());
            $item = $this->saveModel($itemData, $id);

            $images = collect(config('quizzes.images.conversions.question'))->mapWithKeys(function ($item, $key) use (
                $id
            ) {
                return ['question.'.$key.'.'.$id => $key];
            })->toArray();

            app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract')
                ->attachToObject(request(), $item, $images, 'quizzes', 'question');

            $questions[$id] = $item;
        }

        return $questions;
    }

    /**
     * Prepare items data.
     *
     * @param  array  $data
     * @param  int  $quizId
     *
     * @return array
     */
    protected function prepareData(array $data, int $quizId): array
    {
        $preparedData = [];

        $ids = Arr::pull($data, 'keys', []);

        foreach ($ids as $id) {
            $itemData = [];

            foreach ($data as $field => $values) {
                $itemData[$field] = $values[$id] ?? null;
            }

            $itemData['quiz_id'] = $quizId;
            $preparedData[$id] = $itemData;
        }

        return $preparedData;
    }
}
