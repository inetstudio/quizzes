<?php

namespace InetStudio\QuizzesPackage\Questions\Providers;

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
        'InetStudio\QuizzesPackage\Questions\Contracts\Models\QuestionModelContract' => 'InetStudio\QuizzesPackage\Questions\Models\QuestionModel',
        'InetStudio\QuizzesPackage\Questions\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\QuizzesPackage\Questions\Services\Back\ItemsService',
        'InetStudio\QuizzesPackage\Questions\Contracts\Transformers\Front\ItemTransformerContract' => 'InetStudio\QuizzesPackage\Questions\Transformers\Front\ItemTransformer',
        'InetStudio\QuizzesPackage\Questions\Contracts\Transformers\Front\PreviewTransformerContract' => 'InetStudio\QuizzesPackage\Questions\Transformers\Front\PreviewTransformer',
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
