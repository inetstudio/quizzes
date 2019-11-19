<?php

namespace InetStudio\QuizzesPackage\UsersResults\Providers;

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
        'InetStudio\QuizzesPackage\UsersResults\Contracts\Listeners\AddItemListenerContract' => 'InetStudio\QuizzesPackage\UsersResults\Listeners\AddItemListener',
        'InetStudio\QuizzesPackage\UsersResults\Contracts\Models\UserResultModelContract' => 'InetStudio\QuizzesPackage\UsersResults\Models\UserResultModel',
        'InetStudio\QuizzesPackage\UsersResults\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\QuizzesPackage\UsersResults\Services\Front\ItemsService',
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
