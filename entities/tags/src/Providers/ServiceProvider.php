<?php

namespace InetStudio\QuizzesPackage\Tags\Providers;

use Collective\Html\FormBuilder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerViews();
        $this->registerFormComponents();
    }

    protected function registerConsoleCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands(
            [
                'InetStudio\QuizzesPackage\Tags\Console\Commands\SetupCommand',
            ]
        );
    }

    protected function registerPublishes(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        if (Schema::hasTable('quizzes_tags')) {
            return;
        }

        $timestamp = date('Y_m_d_His', time());
        $this->publishes(
            [
                __DIR__.'/../../database/migrations/create_quizzes_tags_tables.php.stub' => database_path(
                    'migrations/'.$timestamp.'_create_quizzes_tags_tables.php'
                ),
            ],
            'migrations'
        );
    }

    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.quizzes-package.tags');
    }

    protected function registerFormComponents(): void
    {
        FormBuilder::component(
            'quizzes_tags',
            'admin.module.quizzes-package.tags::back.forms.fields.tags',
            ['name' => null, 'value' => null, 'attributes' => null]
        );
    }
}
