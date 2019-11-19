<?php

namespace InetStudio\QuizzesPackage\Quizzes\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\QuizzesPackage\Quizzes\Events\Back\ModifyItemEvent',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Events\Front\ItemPassedEventContract' => 'InetStudio\QuizzesPackage\Quizzes\Events\Front\ItemPassedEvent',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Controllers\Back\DataController',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Controllers\Back\ResourceController',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Controllers\Back\UtilityControllerContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Controllers\Back\UtilityController',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Controllers\Front\ItemsControllerContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Controllers\Front\ItemsController',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Requests\Back\SaveItemRequestContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Requests\Back\SaveItemRequest',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Requests\Front\GetDataRequestContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Requests\Front\GetDataRequest',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Requests\Front\GetResultRequestContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Requests\Front\GetResultRequest',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Responses\Back\Data\GetIndexDataResponse',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Back\Resource\CreateResponseContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Responses\Back\Resource\CreateResponse',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Back\Resource\EditResponseContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Responses\Back\Resource\EditResponse',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Front\GetDataResponseContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Responses\Front\GetDataResponse',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Front\GetResultResponseContract' => 'InetStudio\QuizzesPackage\Quizzes\Http\Responses\Front\GetResultResponse',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Models\QuizModelContract' => 'InetStudio\QuizzesPackage\Quizzes\Models\QuizModel',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Services\Back\DataTables\IndexServiceContract' => 'InetStudio\QuizzesPackage\Quizzes\Services\Back\DataTables\IndexService',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\QuizzesPackage\Quizzes\Services\Back\ItemsService',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Services\Back\UtilityServiceContract' => 'InetStudio\QuizzesPackage\Quizzes\Services\Back\UtilityService',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Services\Front\FeedsServiceContract' => 'InetStudio\QuizzesPackage\Quizzes\Services\Front\FeedsService',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\QuizzesPackage\Quizzes\Services\Front\ItemsService',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Transformers\Back\Resource\IndexTransformerContract' => 'InetStudio\QuizzesPackage\Quizzes\Transformers\Back\Resource\IndexTransformer',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Transformers\Back\Utility\SuggestionTransformerContract' => 'InetStudio\QuizzesPackage\Quizzes\Transformers\Back\Utility\SuggestionTransformer',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Transformers\Front\ItemTransformerContract' => 'InetStudio\QuizzesPackage\Quizzes\Transformers\Front\ItemTransformer',
        'InetStudio\QuizzesPackage\Quizzes\Contracts\Transformers\Front\PreviewTransformerContract' => 'InetStudio\QuizzesPackage\Quizzes\Transformers\Front\PreviewTransformer',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return  array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
