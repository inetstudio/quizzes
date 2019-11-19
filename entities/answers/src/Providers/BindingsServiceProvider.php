<?php

namespace InetStudio\QuizzesPackage\Answers\Providers;

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
        'InetStudio\QuizzesPackage\Answers\Contracts\Models\AnswerModelContract' => 'InetStudio\QuizzesPackage\Answers\Models\AnswerModel',
        'InetStudio\QuizzesPackage\Answers\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\QuizzesPackage\Answers\Services\Back\ItemsService',
        'InetStudio\QuizzesPackage\Answers\Contracts\Transformers\Front\ItemTransformerContract' => 'InetStudio\QuizzesPackage\Answers\Transformers\Front\ItemTransformer',
        'InetStudio\QuizzesPackage\Answers\Contracts\Transformers\Front\PreviewTransformerContract' => 'InetStudio\QuizzesPackage\Answers\Transformers\Front\PreviewTransformer',
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
