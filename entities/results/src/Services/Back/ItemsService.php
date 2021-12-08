<?php

namespace InetStudio\QuizzesPackage\Results\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Database\QueryException;
use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\QuizzesPackage\Results\Contracts\Models\ResultModelContract;
use InetStudio\QuizzesPackage\Results\Contracts\Services\Back\ItemsServiceContract;

class ItemsService extends BaseService implements ItemsServiceContract
{
    public function __construct(ResultModelContract $model)
    {
        parent::__construct($model);
    }

    public function save(array $data, int $quizId): array
    {
        $data = $this->prepareData($data, $quizId);

        $ids = Arr::wrap(array_keys($data));

        $this->model->where('quiz_id', $quizId)->whereNotIn('id', $ids)->get()->each(
            function (ResultModelContract $result) {
                $this->destroy($result['id']);
            }
        );

        $results = [];
        foreach ($ids as $id) {
            $itemData = Arr::only($data[$id], $this->model->getFillable());
            $item = $this->saveModel($itemData, $id);

            $tagsData = Arr::only($data[$id], 'tags');
            if (isset($tagsData['tags'])) {
                if (! $tagsData['tags']) {
                    $item->tags()->detach($item->tags()->pluck('id')->toArray());
                } else {
                    $item->tags()->sync($tagsData['tags']);
                }
            } else {
                $item->tags()->detach($item->tags()->pluck('id')->toArray());
            }

            $images = collect(config('quizzes.images.conversions.result'))->mapWithKeys(
                    function ($item, $key) use ($id) {
                        return ['result.'.$key.'.'.$id => $key];
                    }
                )->toArray();

            resolve(
                'InetStudio\UploadsPackage\Uploads\Contracts\Actions\AttachMediaToObjectActionContract',
                [
                    'item' => $item,
                    'media' => Arr::get($data, 'media', []),
                ]
            )->execute();

            $results[$id] = $item;
        }

        return $results;
    }

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
