<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Controllers\Back\DataControllerContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Data\GetIndexDataRequestContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract;

class DataController extends Controller implements DataControllerContract
{
    public function getIndexData(GetIndexDataRequestContract $request, GetIndexDataResponseContract $response): GetIndexDataResponseContract
    {
        return $response;
    }
}
