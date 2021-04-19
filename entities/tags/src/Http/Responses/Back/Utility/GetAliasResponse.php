<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Utility;

use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Utility\GetAliasResponseContract;

class GetAliasResponse implements GetAliasResponseContract
{
    protected UtilityServiceContract $utilityService;

    public function __construct(UtilityServiceContract $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    public function toResponse($request)
    {
        $text = $request->get('name', '') ?? '';

        $alias = $this->utilityService->getAlias($text);

        return response()->json($alias);
    }
}
