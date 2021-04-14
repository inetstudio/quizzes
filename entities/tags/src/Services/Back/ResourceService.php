<?php

namespace InetStudio\QuizzesPackage\Tags\Services\Back;

use InetStudio\QuizzesPackage\Tags\Contracts\Models\TagModelContract;
use InetStudio\QuizzesPackage\Tags\Services\ItemsService as BaseItemsService;
use InetStudio\QuizzesPackage\Tags\Contracts\DTO\Back\Resource\ItemDataContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\ResourceServiceContract;

class ResourceService extends BaseItemsService implements ResourceServiceContract
{
    public function create(): TagModelContract
    {
        return new $this->model;
    }

    public function destroy(string $id): int
    {
        return $this->model::destroy($id);
    }

    public function edit(?string $id): ?TagModelContract
    {
        return $this->show($id);
    }

    public function show(?string $id): ?TagModelContract
    {
        return $this->model::find($id);
    }

    public function store(ItemDataContract $data): TagModelContract
    {
        $item = new $this->model;

        $item = $this->save($data, $item);

        return $item;
    }

    public function update(ItemDataContract $data): ?TagModelContract
    {
        $item = $this->model::find($data->id);

        if (! $item) {
            return null;
        }

        $item = $this->save($data, $item);

        return $item;
    }

    protected function save(ItemDataContract $data, TagModelContract $item): TagModelContract
    {
        $item->parent_id = $data->parentId;
        $item->name = $data->name;

        $item->save();

        return $item;
    }
}
