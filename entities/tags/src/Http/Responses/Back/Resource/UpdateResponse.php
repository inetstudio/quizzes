<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource;

use Illuminate\Support\Facades\Session;
use InetStudio\QuizzesPackage\Tags\DTO\Back\Resource\ItemData;
use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\UpdateResponseContract;

class UpdateResponse implements UpdateResponseContract
{
    protected ResourceServiceContract $resourceService;

    public function __construct(ResourceServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $data = ItemData::fromRequest($request);

        $item = $this->resourceService->update($data);

        if (! $item) {
            abort(404);
        }

        Session::flash('success', 'Тег «'.$item['name'].'» успешно обновлен');

        return response()->redirectToRoute('back.quizzes-package.tags.edit', $item['id']);
    }
}
