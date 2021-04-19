<?php

namespace InetStudio\QuizzesPackage\Tags\DTO\Back\Resource;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;
use InetStudio\QuizzesPackage\Tags\Contracts\DTO\Back\Resource\ItemDataContract;

class ItemData extends FlexibleDataTransferObject implements ItemDataContract
{
    public ?string $id;

    public ?string $parentId;

    public string $name;

    public string $alias;

    public static function fromRequest(Request $request): self
    {
        $data = [
            'id' => $request->input('id'),
            'parentId' => $request->input('parent_id'),
            'name' => trim(strip_tags($request->input('name'))),
            'alias' => trim(strip_tags($request->input('alias'))),
        ];

        return new self($data);
    }
}
