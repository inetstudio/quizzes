<?php

namespace InetStudio\QuizzesPackage\UsersResults\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Загрузка сервиса.
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerEvents();
    }

    /**
     * Регистрация команд.
     */
    protected function registerConsoleCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            'InetStudio\QuizzesPackage\UsersResults\Console\Commands\SetupCommand',
        ]);
    }

    /**
     * Регистрация ресурсов.
     */
    protected function registerPublishes(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        if (Schema::hasTable('quizzes_users_results')) {
            return;
        }

        $timestamp = date('Y_m_d_His', time());
        $this->publishes(
            [
                __DIR__.'/../../database/migrations/create_quizzes_users_results_tables.php.stub' => database_path(
                    'migrations/'.$timestamp.'_create_quizzes_users_results_tables.php'
                ),
            ], 'migrations'
        );
    }

    /**
     * Регистрация событий.
     */
    protected function registerEvents(): void
    {
        Event::listen(
            'InetStudio\QuizzesPackage\Quizzes\Contracts\Events\Front\ItemPassedEventContract',
            'InetStudio\QuizzesPackage\UsersResults\Contracts\Listeners\AddItemListenerContract'
        );
    }
}
