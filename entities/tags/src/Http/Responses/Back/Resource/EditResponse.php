<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource;

use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\EditResponseContract;

class EditResponse implements EditResponseContract
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

        if (! $item) {
            abort(404);
        }

        return response()->view('admin.module.quizzes-package.tags::back.pages.form', compact('item'));
    }
}
