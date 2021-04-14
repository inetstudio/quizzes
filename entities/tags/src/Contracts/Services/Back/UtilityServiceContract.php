<?php

namespace InetStudio\QuizzesPackage\Tags\Contracts\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\QuizzesPackage\Tags\Contracts\Services\ItemsServiceContract as BaseItemsServiceContract;

interface UtilityServiceContract extends BaseItemsServiceContract
{
    public function getSuggestions(string $search, array $exclude): Collection;

    public function getSuggestionsChildren(string $search): Collection;
}
