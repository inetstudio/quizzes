<?php

namespace InetStudio\Quizzes\Services\Front;

use Illuminate\Support\Collection;
use InetStudio\Quizzes\Contracts\Models\UserResultModelContract;
use InetStudio\Quizzes\Contracts\Services\Front\UsersResultsServiceContract;

/**
 * Class UsersResultsService.
 */
class UsersResultsService implements UsersResultsServiceContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    public $services = [];

    /**
     * @var mixed
     */
    public $repository;

    /**
     * UsersResultsService constructor.
     */
    public function __construct()
    {
        $this->repository = app()->make('InetStudio\Quizzes\Contracts\Repositories\UsersResultsRepositoryContract');
    }

    /**
     * Обновляем модель.
     *
     * @param array $data
     * @param array $conditions
     *
     * @return Collection
     */
    public function update(array $data, array $conditions): Collection
    {
        $items = $this->repository->searchItems($conditions);

        foreach ($items as $item) {
            $this->repository->save($data, $item->id);
        }

        return $items;
    }

    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     *
     * @return UserResultModelContract
     */
    public function save(array $data, int $id): UserResultModelContract
    {
        $item = $this->repository->save($data, $id);

        return $item;
    }
}
