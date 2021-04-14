<?php

namespace InetStudio\QuizzesPackage\Tags\Services;

use Illuminate\Support\Arr;
use InetStudio\QuizzesPackage\Tags\Contracts\Models\TagModelContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Services\ItemsServiceContract;

class ItemsService implements ItemsServiceContract
{
    protected TagModelContract $model;

    public function __construct(TagModelContract $model)
    {
        $this->model = $model;
    }

    public function getModel(): TagModelContract
    {
        return $this->model;
    }

    public function getItemById($ids)
    {
        $ids = Arr::wrap($ids);

        return $this->model->find($ids);
    }
}
