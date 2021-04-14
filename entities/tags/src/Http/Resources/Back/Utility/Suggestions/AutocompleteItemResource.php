<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Resources\Back\Utility\Suggestions;

use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Utility\Suggestions\AutocompleteItemResourceContract;

class AutocompleteItemResource extends JsonResource implements AutocompleteItemResourceContract
{
    public function toArray($request): array
    {
        return [
            'value' => $this['name'],
            'data' => [
                'id' => $this['id'],
                'type' => get_class($this),
                'title' => $this['name'],
            ],
        ];
    }
}
