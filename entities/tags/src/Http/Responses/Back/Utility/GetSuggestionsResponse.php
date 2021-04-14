<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Utility;

use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Utility\GetSuggestionsResponseContract;

class GetSuggestionsResponse implements GetSuggestionsResponseContract
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
        $exclude = $request->get('exclude', []) ?? [];

        $resource = $this->utilityService->getSuggestions($search, $exclude);

        return resolve(
            'InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Utility\Suggestions\ItemsCollectionContract',
            compact('resource', 'type')
        );
    }
}
