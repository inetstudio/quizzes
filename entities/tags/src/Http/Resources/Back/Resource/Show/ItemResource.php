<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Resources\Back\Resource\Show;

use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
        ];
    }
}
