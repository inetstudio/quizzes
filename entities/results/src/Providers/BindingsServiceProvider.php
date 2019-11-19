<?php

namespace InetStudio\QuizzesPackage\Results\Providers;

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
        'InetStudio\QuizzesPackage\Results\Contracts\Http\Controllers\Front\ItemsControllerContract' => 'InetStudio\QuizzesPackage\Results\Http\Controllers\Front\ItemsController',
        'InetStudio\QuizzesPackage\Results\Contracts\Http\Requests\Front\SendResultToEmailRequestContract' => 'InetStudio\QuizzesPackage\Results\Http\Requests\Front\SendResultToEmailRequest',
        'InetStudio\QuizzesPackage\Results\Contracts\Http\Responses\Front\SendResultToEmailResponseContract' => 'InetStudio\QuizzesPackage\Results\Http\Responses\Front\SendResultToEmailResponse',
        'InetStudio\QuizzesPackage\Results\Contracts\Mail\Front\ResultMailContract' => 'InetStudio\QuizzesPackage\Results\Mail\Front\ResultMail',
        'InetStudio\QuizzesPackage\Results\Contracts\Models\ResultModelContract' => 'InetStudio\QuizzesPackage\Results\Models\ResultModel',
        'InetStudio\QuizzesPackage\Results\Contracts\Notifications\Front\ResultNotificationContract' => 'InetStudio\QuizzesPackage\Results\Notifications\Front\ResultNotification',
        'InetStudio\QuizzesPackage\Results\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\QuizzesPackage\Results\Services\Back\ItemsService',
        'InetStudio\QuizzesPackage\Results\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\QuizzesPackage\Results\Services\Front\ItemsService',
        'InetStudio\QuizzesPackage\Results\Contracts\Transformers\Front\ItemTransformerContract' => 'InetStudio\QuizzesPackage\Results\Transformers\Front\ItemTransformer',
        'InetStudio\QuizzesPackage\Results\Contracts\Transformers\Front\PreviewTransformerContract' => 'InetStudio\QuizzesPackage\Results\Transformers\Front\PreviewTransformer',
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
