<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource;

use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\CreateResponseContract;

class CreateResponse implements CreateResponseContract
{
    protected ResourceServiceContract $resourceService;

    public function __construct(ResourceServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $item = $this->resourceService->create();

        return response()->view('admin.module.quizzes-package.tags::back.pages.form', compact('item'));
    }
}
