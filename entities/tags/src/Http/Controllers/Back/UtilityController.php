<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Controllers\Back\UtilityControllerContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Utility\GetSuggestionsRequestContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Utility\GetSuggestionsResponseContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Utility\GetSuggestionsChildrenRequestContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Utility\GetSuggestionsChildrenResponseContract;

class UtilityController extends Controller implements UtilityControllerContract
{
    public function getSuggestions(GetSuggestionsRequestContract $request, GetSuggestionsResponseContract $response): GetSuggestionsResponseContract
    {
        return $response;
    }

    public function getSuggestionsChildren(GetSuggestionsChildrenRequestContract $request, GetSuggestionsChildrenResponseContract $response): GetSuggestionsChildrenResponseContract
    {
        return $response;
    }
}
