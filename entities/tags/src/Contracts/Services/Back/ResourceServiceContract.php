<?php

namespace InetStudio\QuizzesPackage\Tags\Contracts\Services\Back;

use InetStudio\QuizzesPackage\Tags\Contracts\Models\TagModelContract;
use InetStudio\QuizzesPackage\Tags\Contracts\DTO\Back\Resource\ItemDataContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Services\ItemsServiceContract as BaseItemsServiceContract;

interface ResourceServiceContract extends BaseItemsServiceContract
{
    public function create(): TagModelContract;

    public function destroy(string $id): int;

    public function edit(?string $id): ?TagModelContract;

    public function show(?string $id): ?TagModelContract;

    public function store(ItemDataContract $data): TagModelContract;

    public function update(ItemDataContract $data): ?TagModelContract;
}
