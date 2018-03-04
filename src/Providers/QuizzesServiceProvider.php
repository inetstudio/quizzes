<?php

namespace InetStudio\Quizzes\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class QuizzesServiceProvider.
 */
class QuizzesServiceProvider extends ServiceProvider
{
    /**
     * Загрузка сервиса.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerViews();
        $this->registerObservers();
    }

    /**
     * Регистрация привязки в контейнере.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerBindings();
    }

    /**
     * Регистрация команд.
     *
     * @return void
     */
    protected function registerConsoleCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                'InetStudio\Quizzes\Console\Commands\SetupCommand',
                'InetStudio\Quizzes\Console\Commands\CreateFoldersCommand',
            ]);
        }
    }

    /**
     * Регистрация ресурсов.
     *
     * @return void
     */
    protected function registerPublishes(): void
    {
        $this->publishes([
            __DIR__.'/../../public' => public_path(),
        ], 'public');

        $this->publishes([
            __DIR__.'/../../config/quizzes.php' => config_path('quizzes.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../../config/filesystems.php', 'filesystems.disks'
        );

        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateQuizzesTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__.'/../../database/migrations/create_quizzes_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_quizzes_tables.php'),
                ], 'migrations');
            }
        }
    }

    /**
     * Регистрация путей.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    /**
     * Регистрация представлений.
     *
     * @return void
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.quizzes');
    }

    /**
     * Регистрация наблюдателей.
     *
     * @return void
     */
    public function registerObservers(): void
    {
        $this->app->make('InetStudio\Quizzes\Contracts\Models\AnswerModelContract')::observe($this->app->make('InetStudio\Quizzes\Observers\AnswerObserver'));
        $this->app->make('InetStudio\Quizzes\Contracts\Models\QuizModelContract')::observe($this->app->make('InetStudio\Quizzes\Observers\QuizObserver'));
        $this->app->make('InetStudio\Quizzes\Contracts\Models\QuestionModelContract')::observe($this->app->make('InetStudio\Quizzes\Observers\QuestionObserver'));
        $this->app->make('InetStudio\Quizzes\Contracts\Models\ResultModelContract')::observe($this->app->make('InetStudio\Quizzes\Observers\ResultObserver'));
    }

    /**
     * Регистрация привязок, алиасов и сторонних провайдеров сервисов.
     *
     * @return void
     */
    public function registerBindings(): void
    {
        // Controllers
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Controllers\Back\QuizzesControllerContract', 'InetStudio\Quizzes\Http\Controllers\Back\QuizzesController');
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Controllers\Back\QuizzesDataControllerContract', 'InetStudio\Quizzes\Http\Controllers\Back\QuizzesDataController');
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Controllers\Back\QuizzesUtilityControllerContract', 'InetStudio\Quizzes\Http\Controllers\Back\QuizzesUtilityController');
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Controllers\Front\QuizzesControllerContract', 'InetStudio\Quizzes\Http\Controllers\Front\QuizzesController');

        // Events
        $this->app->bind('InetStudio\Quizzes\Contracts\Events\Back\ModifyQuizEventContract', 'InetStudio\Quizzes\Events\ModifyQuizEvent');

        // Mail
        $this->app->bind('InetStudio\Quizzes\Contracts\Mail\ResultMailContract', 'InetStudio\Quizzes\Mail\ResultMail');

        // Models
        $this->app->bind('InetStudio\Quizzes\Contracts\Models\AnswerModelContract', 'InetStudio\Quizzes\Models\AnswerModel');
        $this->app->bind('InetStudio\Quizzes\Contracts\Models\QuizModelContract', 'InetStudio\Quizzes\Models\QuizModel');
        $this->app->bind('InetStudio\Quizzes\Contracts\Models\QuestionModelContract', 'InetStudio\Quizzes\Models\QuestionModel');
        $this->app->bind('InetStudio\Quizzes\Contracts\Models\ResultModelContract', 'InetStudio\Quizzes\Models\ResultModel');

        // Observers
        $this->app->bind('InetStudio\Quizzes\Contracts\Observers\AnswerObserverContract', 'InetStudio\Quizzes\Observers\AnswerObserver');
        $this->app->bind('InetStudio\Quizzes\Contracts\Observers\QuizObserverContract', 'InetStudio\Quizzes\Observers\QuizObserver');
        $this->app->bind('InetStudio\Quizzes\Contracts\Observers\QuestionObserverContract', 'InetStudio\Quizzes\Observers\QuestionObserver');
        $this->app->bind('InetStudio\Quizzes\Contracts\Observers\ResultObserverContract', 'InetStudio\Quizzes\Observers\ResultObserver');

        // Repositories
        $this->app->bind('InetStudio\Quizzes\Contracts\Repositories\QuizzesRepositoryContract', 'InetStudio\Quizzes\Repositories\QuizzesRepository');
        $this->app->bind('InetStudio\Quizzes\Contracts\Repositories\AnswersRepositoryContract', 'InetStudio\Quizzes\Repositories\AnswersRepository');
        $this->app->bind('InetStudio\Quizzes\Contracts\Repositories\QuestionsRepositoryContract', 'InetStudio\Quizzes\Repositories\QuestionsRepository');
        $this->app->bind('InetStudio\Quizzes\Contracts\Repositories\ResultsRepositoryContract', 'InetStudio\Quizzes\Repositories\ResultsRepository');

        // Requests
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Requests\Back\SaveQuizRequestContract', 'InetStudio\Quizzes\Http\Requests\Back\SaveQuizRequest');
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Requests\Front\GetQuizDataRequestContract', 'InetStudio\Quizzes\Http\Requests\Front\GetQuizDataRequest');
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Requests\Front\GetQuizResultRequestContract', 'InetStudio\Quizzes\Http\Requests\Front\GetQuizResultRequest');
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Requests\Front\SendResultToEmailRequestContract', 'InetStudio\Quizzes\Http\Requests\Front\SendResultToEmailRequest');

        // Responses
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\DestroyResponseContract', 'InetStudio\Quizzes\Http\Responses\Back\Quizzes\DestroyResponse');
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\FormResponseContract', 'InetStudio\Quizzes\Http\Responses\Back\Quizzes\FormResponse');
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\IndexResponseContract', 'InetStudio\Quizzes\Http\Responses\Back\Quizzes\IndexResponse');
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\SaveResponseContract', 'InetStudio\Quizzes\Http\Responses\Back\Quizzes\SaveResponse');
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract', 'InetStudio\Quizzes\Http\Responses\Back\Utility\SuggestionsResponse');
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Responses\Front\GetQuizDataResponseContract', 'InetStudio\Quizzes\Http\Responses\Front\GetQuizDataResponse');
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Responses\Front\GetQuizResultResponseContract', 'InetStudio\Quizzes\Http\Responses\Front\GetQuizResultResponse');
        $this->app->bind('InetStudio\Quizzes\Contracts\Http\Responses\Front\SendResultToEmailResponseContract', 'InetStudio\Quizzes\Http\Responses\Front\SendResultToEmailResponse');

        // Services
        $this->app->bind('InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesDataTableServiceContract', 'InetStudio\Quizzes\Services\Back\Quizzes\QuizzesDataTableService');
        $this->app->bind('InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesServiceContract', 'InetStudio\Quizzes\Services\Back\Quizzes\QuizzesService');
        $this->app->bind('InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesObserverServiceContract', 'InetStudio\Quizzes\Services\Back\Quizzes\QuizzesObserverService');
        $this->app->bind('InetStudio\Quizzes\Contracts\Services\Back\Answers\AnswersServiceContract', 'InetStudio\Quizzes\Services\Back\Answers\AnswersService');
        $this->app->bind('InetStudio\Quizzes\Contracts\Services\Back\Answers\AnswersObserverServiceContract', 'InetStudio\Quizzes\Services\Back\Answers\AnswersObserverService');
        $this->app->bind('InetStudio\Quizzes\Contracts\Services\Back\Questions\QuestionsServiceContract', 'InetStudio\Quizzes\Services\Back\Questions\QuestionsService');
        $this->app->bind('InetStudio\Quizzes\Contracts\Services\Back\Questions\QuestionsObserverServiceContract', 'InetStudio\Quizzes\Services\Back\Questions\QuestionsObserverService');
        $this->app->bind('InetStudio\Quizzes\Contracts\Services\Back\Results\ResultsServiceContract', 'InetStudio\Quizzes\Services\Back\Results\ResultsService');
        $this->app->bind('InetStudio\Quizzes\Contracts\Services\Back\Results\ResultsObserverServiceContract', 'InetStudio\Quizzes\Services\Back\Results\ResultsObserverService');
        $this->app->bind('InetStudio\Quizzes\Contracts\Services\Front\QuizzesServiceContract', 'InetStudio\Quizzes\Services\Front\QuizzesService');

        // Transformers
        $this->app->bind('InetStudio\Quizzes\Contracts\Transformers\Back\QuizTransformerContract', 'InetStudio\Quizzes\Transformers\Back\QuizTransformer');
        $this->app->bind('InetStudio\Quizzes\Contracts\Transformers\Front\AnswerTransformerContract', 'InetStudio\Quizzes\Transformers\Front\AnswerTransformer');
        $this->app->bind('InetStudio\Quizzes\Contracts\Transformers\Front\QuestionTransformerContract', 'InetStudio\Quizzes\Transformers\Front\QuestionTransformer');
        $this->app->bind('InetStudio\Quizzes\Contracts\Transformers\Front\QuizTransformerContract', 'InetStudio\Quizzes\Transformers\Front\QuizTransformer');
        $this->app->bind('InetStudio\Quizzes\Contracts\Transformers\Front\ResultTransformerContract', 'InetStudio\Quizzes\Transformers\Front\ResultTransformer');
    }
}
