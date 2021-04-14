<?php

namespace InetStudio\QuizzesPackage\Tags\Http\Resources\Back\Utility\Suggestions;

use Illuminate\Http\Resources\Json\ResourceCollection;
use InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Utility\Suggestions\ItemsCollectionContract;

class ItemsCollection extends ResourceCollection implements ItemsCollectionContract
{
    protected string $type;

    public function __construct($resource, string $type = '')
    {
        $this->type = $type;

        $itemResource = resolve(
            'InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Utility\Suggestions\\'.($type === 'autocomplete' ? 'Autocomplete' : '').'ItemResourceContract',
            [
                'resource' => null,
            ]
        );

        $this->collects = get_class($itemResource);

        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        return [
            ($this->type === 'autocomplete') ? 'suggestions' : 'items' => $this->collection,
        ];
    }
}
