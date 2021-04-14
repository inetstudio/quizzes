<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Resources\Back\Resource\Index;

use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Resource\Index\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request): array
    {
        return [
            'id' => (int) $this['id'],
            'name' => $this['name'],
            'parent' => ($this['parent']) ? $this['parent']['name'] : '',
            'created_at' => (string) $this['created_at'],
            'updated_at' => (string) $this['updated_at'],
            'actions' => view(
                    'admin.module.quizzes-package.tags::back.partials.datatables.actions',
                    [
                        'item' => $this,
                    ]
                )
                ->render(),
        ];
    }
}
