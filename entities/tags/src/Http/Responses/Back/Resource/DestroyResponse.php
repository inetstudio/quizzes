<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource;

use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

class DestroyResponse implements DestroyResponseContract
{
    protected ResourceServiceContract $resourceService;

    public function __construct(ResourceServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $id = $request->route('tag');

        $count = $this->resourceService->destroy($id);

        return response()->json(
            [
                'success' => ($count > 0),
            ]
        );
    }
}
