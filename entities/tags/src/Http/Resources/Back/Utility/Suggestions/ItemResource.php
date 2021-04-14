<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Resources\Back\Utility\Suggestions;

use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Utility\Suggestions\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request): array
    {
        return [
            'id' => $this['id'],
            'name' => ($this['parent']) ? $this['parent']['name'].' / '.$this['name'] : $this['name'],
        ];
    }
}
