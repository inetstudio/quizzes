<?php

namespace InetStudio\QuizzesPackage\Tags\Contracts\Http\Controllers\Back;

use InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Utility\GetAliasRequestContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Utility\GetAliasResponseContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Utility\GetSuggestionsRequestContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Utility\GetSuggestionsResponseContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Utility\GetSuggestionsChildrenRequestContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Utility\GetSuggestionsChildrenResponseContract;

interface UtilityControllerContract
{
    public function getAlias(GetAliasRequestContract $request, GetAliasResponseContract $response): GetAliasResponseContract;

    public function getSuggestions(GetSuggestionsRequestContract $request, GetSuggestionsResponseContract $response): GetSuggestionsResponseContract;

    public function getSuggestionsChildren(GetSuggestionsChildrenRequestContract $request, GetSuggestionsChildrenResponseContract $response): GetSuggestionsChildrenResponseContract;
}
