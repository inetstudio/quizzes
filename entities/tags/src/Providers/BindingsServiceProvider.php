<?php

namespace InetStudio\QuizzesPackage\Tags\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public array $bindings = [
        'InetStudio\QuizzesPackage\Tags\Contracts\DTO\Back\Resource\Save\ItemDataContract' => 'InetStudio\QuizzesPackage\Tags\DTO\Back\Resource\Save\ItemData',

        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\QuizzesPackage\Tags\Http\Controllers\Back\ResourceController',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\QuizzesPackage\Tags\Http\Controllers\Back\DataController',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Controllers\Back\UtilityControllerContract' => 'InetStudio\QuizzesPackage\Tags\Http\Controllers\Back\UtilityController',

        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Data\GetIndexDataRequestContract' => 'InetStudio\QuizzesPackage\Tags\Http\Requests\Back\Data\GetIndexDataRequest',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Resource\CreateRequestContract' => 'InetStudio\QuizzesPackage\Tags\Http\Requests\Back\Resource\CreateRequest',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Resource\DestroyRequestContract' => 'InetStudio\QuizzesPackage\Tags\Http\Requests\Back\Resource\DestroyRequest',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Resource\EditRequestContract' => 'InetStudio\QuizzesPackage\Tags\Http\Requests\Back\Resource\EditRequest',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Resource\IndexRequestContract' => 'InetStudio\QuizzesPackage\Tags\Http\Requests\Back\Resource\IndexRequest',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Resource\ShowRequestContract' => 'InetStudio\QuizzesPackage\Tags\Http\Requests\Back\Resource\ShowRequest',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Resource\StoreRequestContract' => 'InetStudio\QuizzesPackage\Tags\Http\Requests\Back\Resource\StoreRequest',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Resource\UpdateRequestContract' => 'InetStudio\QuizzesPackage\Tags\Http\Requests\Back\Resource\UpdateRequest',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Utility\GetSuggestionsChildrenRequestContract' => 'InetStudio\QuizzesPackage\Tags\Http\Requests\Back\Utility\GetSuggestionsChildrenRequest',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Requests\Back\Utility\GetSuggestionsRequestContract' => 'InetStudio\QuizzesPackage\Tags\Http\Requests\Back\Utility\GetSuggestionsRequest',

        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Resource\Index\ItemResourceContract' => 'InetStudio\QuizzesPackage\Tags\Http\Resources\Back\Resource\Index\ItemResource',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract' => 'InetStudio\QuizzesPackage\Tags\Http\Resources\Back\Resource\Show\ItemResource',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Utility\Suggestions\AutocompleteItemResourceContract' => 'InetStudio\QuizzesPackage\Tags\Http\Resources\Back\Utility\Suggestions\AutocompleteItemResource',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Utility\Suggestions\ItemResourceContract' => 'InetStudio\QuizzesPackage\Tags\Http\Resources\Back\Utility\Suggestions\ItemResource',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Resources\Back\Utility\Suggestions\ItemsCollectionContract' => 'InetStudio\QuizzesPackage\Tags\Http\Resources\Back\Utility\Suggestions\ItemsCollection',

        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract' => 'InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Data\GetIndexDataResponse',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\CreateResponseContract' => 'InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource\CreateResponse',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\EditResponseContract' => 'InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource\EditResponse',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\StoreResponseContract' => 'InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource\StoreResponse',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Resource\UpdateResponseContract' => 'InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Resource\UpdateResponse',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Utility\GetSuggestionsChildrenResponseContract' => 'InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Utility\GetSuggestionsChildrenResponse',
        'InetStudio\QuizzesPackage\Tags\Contracts\Http\Responses\Back\Utility\GetSuggestionsResponseContract' => 'InetStudio\QuizzesPackage\Tags\Http\Responses\Back\Utility\GetSuggestionsResponse',

        'InetStudio\QuizzesPackage\Tags\Contracts\Models\TagModelContract' => 'InetStudio\QuizzesPackage\Tags\Models\TagModel',

        'InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\DataTables\IndexServiceContract' => 'InetStudio\QuizzesPackage\Tags\Services\Back\DataTables\IndexService',
        'InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\QuizzesPackage\Tags\Services\Back\ItemsService',
        'InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\ResourceServiceContract' => 'InetStudio\QuizzesPackage\Tags\Services\Back\ResourceService',
        'InetStudio\QuizzesPackage\Tags\Contracts\Services\Back\UtilityServiceContract' => 'InetStudio\QuizzesPackage\Tags\Services\Back\UtilityService',
        'InetStudio\QuizzesPackage\Tags\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\QuizzesPackage\Tags\Services\Front\ItemsService',
        'InetStudio\QuizzesPackage\Tags\Contracts\Services\ItemsServiceContract' => 'InetStudio\QuizzesPackage\Tags\Services\ItemsService',
    ];

    public function provides()
    {
        return array_keys($this->bindings);
    }
}
