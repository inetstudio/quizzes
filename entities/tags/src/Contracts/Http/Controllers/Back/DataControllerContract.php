<?php

namespace InetStudio\QuizzesPackage\Tags\Contracts\Http\Controllers\Back;

use InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Data\GetIndexDataRequestContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract;

interface DataControllerContract
{
    public function getIndexData(GetIndexDataRequestContract $request, GetIndexDataResponseContract $response): GetIndexDataResponseContract;
}
