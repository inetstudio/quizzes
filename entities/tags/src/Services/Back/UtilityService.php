<?php

namespace InetStudio\QuizzesPackage\Tags\Services\Back;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use InetStudio\QuizzesPackage\Tags\Services\ItemsService as BaseItemsService;
use InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\UtilityServiceContract;

class UtilityService extends BaseItemsService implements UtilityServiceContract
{
    public function getAlias(string $text): string
    {
        return Str::slug($text, '_');
    }

    public function getSuggestions(string $search, array $exclude): Collection
    {
        $query = $this->model::where(
            [
                ['name', 'LIKE', '%'.$search.'%'],
            ]
        );

        if (! empty($exclude)) {
            $query = $query->whereNotIn('id', $exclude);
        }

        return $query->get();
    }

    public function getSuggestionsChildren(string $search): Collection
    {
        return $this->model::where(
                [
                    ['name', 'LIKE', '%'.$search.'%'],
                ]
            )
            ->whereNotNull('parent_id')
            ->get();
    }
}
