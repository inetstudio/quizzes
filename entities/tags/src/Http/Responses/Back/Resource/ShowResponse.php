<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource;

use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\ShowResponseContract;

class ShowResponse implements ShowResponseContract
{
    protected ResourceServiceContract $resourceService;

    public function __construct(ResourceServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $id = $request->route('tag');

        $item = $this->resourceService->show($id);

        return response()->json($item->toArray());
    }
}
