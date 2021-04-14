<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource;

use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\DataTables\IndexServiceContract as DataTableServiceContract;

class IndexResponse implements IndexResponseContract
{
    protected DataTableServiceContract $datatableService;

    public function __construct(DataTableServiceContract $datatableService)
    {
        $this->datatableService = $datatableService;
    }

    public function toResponse($request)
    {
        $table = $this->datatableService->html();

        return view('admin.module.quizzes-package.tags::back.pages.index', compact('table'));
    }
}
