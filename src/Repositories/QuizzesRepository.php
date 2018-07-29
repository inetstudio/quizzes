<?php

namespace InetStudio\Quizzes\Repositories;

use Illuminate\Database\Eloquent\Builder;
use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\Quizzes\Contracts\Repositories\QuizzesRepositoryContract;
use InetStudio\Quizzes\Contracts\Http\Requests\Back\SaveQuizRequestContract;

/**
 * Class QuizzesRepository.
 */
class QuizzesRepository implements QuizzesRepositoryContract
{
    /**
     * @var QuizModelContract
     */
    public $model;

    /**
     * QuizzesRepository constructor.
     *
     * @param QuizModelContract $model
     */
    public function __construct(QuizModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Получаем модель репозитория.
     *
     * @return QuizModelContract
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Возвращаем пустой объект по id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getEmptyObjectById(int $id)
    {
        return $this->model::select(['id'])->where('id', '=', $id)->first();
    }

    /**
     * Возвращаем объект по id, либо создаем новый.
     *
     * @param int $id
     *
     * @return QuizModelContract
     */
    public function getItemByID(int $id): QuizModelContract
    {
        return $this->model::find($id) ?? new $this->model;
    }

    /**
     * Возвращаем объект по id, либо создаем новый.
     *
     * @param int $id
     *
     * @return bool
     */
    public function itemExist(int $id): bool
    {
        return ! (! is_null($id) && $id > 0 && $item = $this->model::find($id));
    }

    /**
     * Возвращаем объекты по списку id.
     *
     * @param $ids
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getItemsByIDs($ids, bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery()->whereIn('id', (array) $ids);

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Сохраняем объект.
     *
     * @param SaveQuizRequestContract $request
     * @param int $id
     *
     * @return QuizModelContract
     */
    public function save(SaveQuizRequestContract $request, int $id): QuizModelContract
    {
        $item = $this->getItemByID($id);

        $item->setAttribute('quiz_type', strip_tags($request->get('quiz_type')));
        $item->setAttribute('title', strip_tags($request->get('title')));
        $item->setAttribute('description', $request->input('description.text'));
        $item->setAttribute('result_type', strip_tags($request->input('result_type')));
        $item->save();

        return $item;
    }

    /**
     * Удаляем объект.
     *
     * @param int $id
     *
     * @return bool
     */
    public function destroy($id): ?bool
    {
        return $this->getItemByID($id)->delete();
    }

    /**
     * Ищем объекты.
     *
     * @param array $conditions
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function searchItems(array $conditions, bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery([])->where($conditions);

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Получаем все объекты.
     *
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getAllItems(bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery(['created_at', 'updated_at']);

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Возвращаем запрос на получение объектов.
     *
     * @param array $extColumns
     * @param array $with
     *
     * @return Builder
     */
    protected function getItemsQuery($extColumns = [], $with = []): Builder
    {
        $defaultColumns = ['id', 'title', 'quiz_type'];

        $relations = [
            'media' => function ($query) {
                $query->select(['id', 'model_id', 'model_type', 'collection_name', 'file_name', 'disk']);
            },
        ];

        return $this->model::select(array_merge($defaultColumns, $extColumns))
            ->with(array_intersect_key($relations, array_flip($with)));
    }
}
