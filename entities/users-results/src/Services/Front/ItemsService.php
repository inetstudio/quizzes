<?php

namespace InetStudio\QuizzesPackage\UsersResults\Services\Front;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\QuizzesPackage\UsersResults\Contracts\Models\UserResultModelContract;
use InetStudio\QuizzesPackage\UsersResults\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  UserResultModelContract  $model
     */
    public function __construct(UserResultModelContract $model)
    {
        parent::__construct($model);
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
        $items = $this->model->where($conditions)->get();

        foreach ($items as $item) {
            $this->save($data, $item->id);
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
        $itemData = Arr::only($data, $this->model->getFillable());
        $item = $this->saveModel($itemData, $id);

        return $item;
    }
}
