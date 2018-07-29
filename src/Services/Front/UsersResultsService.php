<?php

namespace InetStudio\Quizzes\Services\Front;

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
