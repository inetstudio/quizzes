<?php

namespace InetStudio\Quizzes\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class QuizzesBindingsServiceProvider.
 */
class QuizzesBindingsServiceProvider extends ServiceProvider
{
    /**
    * @var  bool
    */
    protected $defer = true;

    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\Quizzes\Contracts\Events\Back\ModifyQuizEventContract' => 'InetStudio\Quizzes\Events\Back\ModifyQuizEvent',
        'InetStudio\Quizzes\Contracts\Http\Controllers\Back\QuizzesControllerContract' => 'InetStudio\Quizzes\Http\Controllers\Back\QuizzesController',
        'InetStudio\Quizzes\Contracts\Http\Controllers\Back\QuizzesDataControllerContract' => 'InetStudio\Quizzes\Http\Controllers\Back\QuizzesDataController',
        'InetStudio\Quizzes\Contracts\Http\Controllers\Back\QuizzesUtilityControllerContract' => 'InetStudio\Quizzes\Http\Controllers\Back\QuizzesUtilityController',
        'InetStudio\Quizzes\Contracts\Http\Controllers\Front\QuizzesControllerContract' => 'InetStudio\Quizzes\Http\Controllers\Front\QuizzesController',
        'InetStudio\Quizzes\Contracts\Http\Requests\Back\SaveQuizRequestContract' => 'InetStudio\Quizzes\Http\Requests\Back\SaveQuizRequest',
        'InetStudio\Quizzes\Contracts\Http\Requests\Front\GetQuizDataRequestContract' => 'InetStudio\Quizzes\Http\Requests\Front\GetQuizDataRequest',
        'InetStudio\Quizzes\Contracts\Http\Requests\Front\GetQuizResultRequestContract' => 'InetStudio\Quizzes\Http\Requests\Front\GetQuizResultRequest',
        'InetStudio\Quizzes\Contracts\Http\Requests\Front\SendResultToEmailRequestContract' => 'InetStudio\Quizzes\Http\Requests\Front\SendResultToEmailRequest',
        'InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\DestroyResponseContract' => 'InetStudio\Quizzes\Http\Responses\Back\Quizzes\DestroyResponse',
        'InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\FormResponseContract' => 'InetStudio\Quizzes\Http\Responses\Back\Quizzes\FormResponse',
        'InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\IndexResponseContract' => 'InetStudio\Quizzes\Http\Responses\Back\Quizzes\IndexResponse',
        'InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\SaveResponseContract' => 'InetStudio\Quizzes\Http\Responses\Back\Quizzes\SaveResponse',
        'InetStudio\Quizzes\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\Quizzes\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\Quizzes\Contracts\Http\Responses\Front\GetQuizDataResponseContract' => 'InetStudio\Quizzes\Http\Responses\Front\GetQuizDataResponse',
        'InetStudio\Quizzes\Contracts\Http\Responses\Front\GetQuizResultResponseContract' => 'InetStudio\Quizzes\Http\Responses\Front\GetQuizResultResponse',
        'InetStudio\Quizzes\Contracts\Http\Responses\Front\SendResultToEmailResponseContract' => 'InetStudio\Quizzes\Http\Responses\Front\SendResultToEmailResponse',
        'InetStudio\Quizzes\Contracts\Mail\ResultMailContract' => 'InetStudio\Quizzes\Mail\ResultMail',
        'InetStudio\Quizzes\Contracts\Models\AnswerModelContract' => 'InetStudio\Quizzes\Models\AnswerModel',
        'InetStudio\Quizzes\Contracts\Models\QuestionModelContract' => 'InetStudio\Quizzes\Models\QuestionModel',
        'InetStudio\Quizzes\Contracts\Models\QuizModelContract' => 'InetStudio\Quizzes\Models\QuizModel',
        'InetStudio\Quizzes\Contracts\Models\ResultModelContract' => 'InetStudio\Quizzes\Models\ResultModel',
        'InetStudio\Quizzes\Contracts\Models\UserResultModelContract' => 'InetStudio\Quizzes\Models\UserResultModel',
        'InetStudio\Quizzes\Contracts\Notifications\Front\QuizResultNotificationContract' => 'InetStudio\Quizzes\Notifications\Front\QuizResultNotification',
        'InetStudio\Quizzes\Contracts\Observers\AnswerObserverContract' => 'InetStudio\Quizzes\Observers\AnswerObserver',
        'InetStudio\Quizzes\Contracts\Observers\QuestionObserverContract' => 'InetStudio\Quizzes\Observers\QuestionObserver',
        'InetStudio\Quizzes\Contracts\Observers\QuizObserverContract' => 'InetStudio\Quizzes\Observers\QuizObserver',
        'InetStudio\Quizzes\Contracts\Observers\ResultObserverContract' => 'InetStudio\Quizzes\Observers\ResultObserver',
        'InetStudio\Quizzes\Contracts\Repositories\AnswersRepositoryContract' => 'InetStudio\Quizzes\Repositories\AnswersRepository',
        'InetStudio\Quizzes\Contracts\Repositories\QuestionsRepositoryContract' => 'InetStudio\Quizzes\Repositories\QuestionsRepository',
        'InetStudio\Quizzes\Contracts\Repositories\QuizzesRepositoryContract' => 'InetStudio\Quizzes\Repositories\QuizzesRepository',
        'InetStudio\Quizzes\Contracts\Repositories\ResultsRepositoryContract' => 'InetStudio\Quizzes\Repositories\ResultsRepository',
        'InetStudio\Quizzes\Contracts\Repositories\UsersResultsRepositoryContract' => 'InetStudio\Quizzes\Repositories\UsersResultsRepository',
        'InetStudio\Quizzes\Contracts\Services\Back\Answers\AnswersObserverServiceContract' => 'InetStudio\Quizzes\Services\Back\Answers\AnswersObserverService',
        'InetStudio\Quizzes\Contracts\Services\Back\Answers\AnswersServiceContract' => 'InetStudio\Quizzes\Services\Back\Answers\AnswersService',
        'InetStudio\Quizzes\Contracts\Services\Back\Questions\QuestionsObserverServiceContract' => 'InetStudio\Quizzes\Services\Back\Questions\QuestionsObserverService',
        'InetStudio\Quizzes\Contracts\Services\Back\Questions\QuestionsServiceContract' => 'InetStudio\Quizzes\Services\Back\Questions\QuestionsService',
        'InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesDataTableServiceContract' => 'InetStudio\Quizzes\Services\Back\Quizzes\QuizzesDataTableService',
        'InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesObserverServiceContract' => 'InetStudio\Quizzes\Services\Back\Quizzes\QuizzesObserverService',
        'InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesServiceContract' => 'InetStudio\Quizzes\Services\Back\Quizzes\QuizzesService',
        'InetStudio\Quizzes\Contracts\Services\Back\Results\ResultsObserverServiceContract' => 'InetStudio\Quizzes\Services\Back\Results\ResultsObserverService',
        'InetStudio\Quizzes\Contracts\Services\Back\Results\ResultsServiceContract' => 'InetStudio\Quizzes\Services\Back\Results\ResultsService',
        'InetStudio\Quizzes\Contracts\Services\Front\QuizzesServiceContract' => 'InetStudio\Quizzes\Services\Front\QuizzesService',
        'InetStudio\Quizzes\Contracts\Services\Front\UsersResultsServiceContract' => 'InetStudio\Quizzes\Services\Front\UsersResultsService',
        'InetStudio\Quizzes\Contracts\Transformers\Back\QuizTransformerContract' => 'InetStudio\Quizzes\Transformers\Back\QuizTransformer',
        'InetStudio\Quizzes\Contracts\Transformers\Back\SuggestionTransformerContract' => 'InetStudio\Quizzes\Transformers\Back\SuggestionTransformer',
        'InetStudio\Quizzes\Contracts\Transformers\Front\AnswerTransformerContract' => 'InetStudio\Quizzes\Transformers\Front\AnswerTransformer',
        'InetStudio\Quizzes\Contracts\Transformers\Front\QuestionTransformerContract' => 'InetStudio\Quizzes\Transformers\Front\QuestionTransformer',
        'InetStudio\Quizzes\Contracts\Transformers\Front\QuizTransformerContract' => 'InetStudio\Quizzes\Transformers\Front\QuizTransformer',
        'InetStudio\Quizzes\Contracts\Transformers\Front\ResultTransformerContract' => 'InetStudio\Quizzes\Transformers\Front\ResultTransformer',
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
