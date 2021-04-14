<?php

namespace InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Utility\Suggestions;

interface AutocompleteItemResourceContract
{
    public function toArray($request): array;
}
