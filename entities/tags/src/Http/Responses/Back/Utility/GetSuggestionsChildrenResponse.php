<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Utility;

use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Utility\GetSuggestionsChildrenResponseContract;

class GetSuggestionsChildrenResponse implements GetSuggestionsChildrenResponseContract
{
    protected UtilityServiceContract $utilityService;

    public function __construct(UtilityServiceContract $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    public function toResponse($request)
    {
        $search = $request->get('q', '') ?? '';
        $type = $request->get('type', '') ?? '';

        $resource = $this->utilityService->getSuggestionsChildren($search);

        return resolve(
            'InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Utility\Suggestions\ItemsCollectionContract',
            compact('resource', 'type')
        );
    }
}
