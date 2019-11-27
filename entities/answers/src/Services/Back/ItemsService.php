<?php

namespace InetStudio\QuizzesPackage\Answers\Services\Back;

use Illuminate\Support\Arr;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\QuizzesPackage\Answers\Contracts\Models\AnswerModelContract;
use InetStudio\QuizzesPackage\Answers\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  AnswerModelContract  $model
     */
    public function __construct(AnswerModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем объекты.
     *
     * @param  array  $data
     * @param  array  $questions
     * @param  array  $results
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, array $questions, array $results): array
    {
        $data = $this->prepareData($data);

        $ids = Arr::wrap(array_keys($data));

        $questionsIds = collect($questions)->pluck('id')->toArray();

        $this->model->whereIn('quiz_question_id', $questionsIds)->whereNotIn('id', $ids)->get()->each(
            function (AnswerModelContract $answer) {
                $this->destroy($answer['id']);
            }
        );

        $answers = [];

        foreach ($ids as $id) {
            $question = $questions[$data[$id]['quiz_question_id']] ?? null;

            if (! $question) {
                continue;
            }

            $data[$id]['quiz_question_id'] = $question['id'];

            $itemData = Arr::only($data[$id], $this->model->getFillable());
            $item = $this->saveModel($itemData, $id);

            $images = collect(config('quizzes.images.conversions.answer'))->mapWithKeys(
                    function ($item, $key) use ($id) {
                        return ['answer.'.$key.'.'.$id => $key];
                    }
                )->toArray();

            app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract')
                ->attachToObject(request(), $item, $images, 'quizzes', 'answer');

            if (isset($data[$id]['association'])) {
                $assocResults = [];

                collect($data[$id]['association'])->each(
                    function ($item, $key) use ($results, &$assocResults) {
                        $assocResults[$results[$key]->id] = ['association' => $item];
                    });

                $item->results()->sync($assocResults);
            }

            $answers[$id] = $item;
        }

        return $answers;
    }

    /**
     * Prepare items data.
     *
     * @param  array  $data
     *
     * @return array
     */
    protected function prepareData(array $data): array
    {
        $preparedData = [];

        $ids = Arr::pull($data, 'keys');

        foreach ($ids as $id) {
            $itemData = [];

            foreach ($data as $field => $values) {
                $itemData[$field] = $values[$id] ?? null;
            }

            $preparedData[$id] = $itemData;
        }

        return $preparedData;
    }
}
