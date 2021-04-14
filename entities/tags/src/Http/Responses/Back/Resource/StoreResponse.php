<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource;

use Illuminate\Support\Facades\Session;
use InetStudio\QuizzesPackage\Tags\DTO\Back\Resource\ItemData;
use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\StoreResponseContract;

class StoreResponse implements StoreResponseContract
{
    protected ResourceServiceContract $resourceService;

    public function __construct(ResourceServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $data = ItemData::fromRequest($request);

        $item = $this->resourceService->store($data);

        Session::flash('success', 'Тег «'.$item['name'].'» успешно создан');

        return response()->redirectToRoute('back.quizzes-package.tags.edit', $item['id']);
    }
}
