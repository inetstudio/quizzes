<?php

namespace InetStudio\Quizzes\Repositories;

use Illuminate\Database\Eloquent\Builder;
use InetStudio\Quizzes\Contracts\Models\UserResultModelContract;
use InetStudio\Quizzes\Contracts\Repositories\UsersResultsRepositoryContract;

/**
 * Class UsersResultsRepository.
 */
class UsersResultsRepository implements UsersResultsRepositoryContract
{
    /**
     * @var UserResultModelContract
     */
    public $model;

    /**
     * ResultsRepository constructor.
     *
     * @param UserResultModelContract $model
     */
    public function __construct(UserResultModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Получаем модель репозитория.
     *
     * @return UserResultModelContract
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
     * @param $id
     *
     * @return UserResultModelContract
     */
    public function getItemByID($id): UserResultModelContract
    {
        return $this->model::find($id) ?? new $this->model;
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
     * Возвращаем объекты, принадлежащие тесту.
     *
     * @param int $quizID
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getItemsByQuiz(int $quizID, bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery()->where('quiz_id', $quizID);

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Возвращаем объекты, принадлежащие результату.
     *
     * @param int $resultID
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getItemsByResult(int $resultID, bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery()->where('result_id', $resultID);

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Сохраняем объект.
     *
     * @param array $data
     * @param int $id
     *
     * @return UserResultModelContract
     */
    public function save(array $data, int $id): UserResultModelContract
    {
        $item = $this->getItemByID($id);
        $item->fill($data);
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
        $defaultColumns = ['id', 'quiz_id', 'result_id', 'email'];

        $relations = [
            'quiz' => function ($query) {
                $query->select(['id', 'title', 'quiz_type']);
            },
            'result' => function ($query) {
                $query->select(['id', 'title']);
            },
        ];

        return $this->model::select(array_merge($defaultColumns, $extColumns))
            ->with(array_intersect_key($relations, array_flip($with)));
    }
}
