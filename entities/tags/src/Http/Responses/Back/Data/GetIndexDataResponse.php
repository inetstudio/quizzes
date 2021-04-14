<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Data;

use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\DataTables\IndexServiceContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract;

class GetIndexDataResponse implements GetIndexDataResponseContract
{
    protected IndexServiceContract $dataService;

    public function __construct(IndexServiceContract $dataService)
    {
        $this->dataService = $dataService;
    }

    public function toResponse($request)
    {
        return $this->dataService->ajax();
    }
}
