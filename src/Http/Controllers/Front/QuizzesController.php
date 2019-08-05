<?php

namespace InetStudio\Quizzes\Http\Controllers\Front;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\Quizzes\Contracts\Http\Requests\Front\GetQuizDataRequestContract;
use InetStudio\Quizzes\Contracts\Http\Controllers\Front\QuizzesControllerContract;
use InetStudio\Quizzes\Contracts\Http\Requests\Front\GetQuizResultRequestContract;
use InetStudio\Quizzes\Contracts\Http\Responses\Front\GetQuizDataResponseContract;
use InetStudio\Quizzes\Contracts\Http\Responses\Front\GetQuizResultResponseContract;
use InetStudio\Quizzes\Contracts\Http\Requests\Front\SendResultToEmailRequestContract;
use InetStudio\Quizzes\Contracts\Http\Responses\Front\SendResultToEmailResponseContract;

/**
 * Class QuizzesController.
 */
class QuizzesController extends Controller implements QuizzesControllerContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    protected $services;

    /**
     * QuizzesController constructor.
     */
    public function __construct()
    {
        $this->services['quizzes'] = app()->make('InetStudio\Quizzes\Contracts\Services\Front\QuizzesServiceContract');
    }

    /**
     * Получаем информацию по тесту.
     *
     * @param GetQuizDataRequestContract $request
     *
     * @return GetQuizDataResponseContract
     */
    public function getQuizData(GetQuizDataRequestContract $request): GetQuizDataResponseContract
    {
        $id = $request->get('id');

        $data = $this->services['quizzes']->getQuizData($id);

        return app()->makeWith('InetStudio\Quizzes\Contracts\Http\Responses\Front\GetQuizDataResponseContract', [
            'data' => $data,
        ]);
    }

    /**
     * Получаем результат теста на основе ответов пользователя.
     *
     * @param GetQuizResultRequestContract $request
     *
     * @return GetQuizResultResponseContract
     */
    public function getQuizResult(GetQuizResultRequestContract $request): GetQuizResultResponseContract
    {
        $id = $request->get('id');
        $userAnswers = $request->input('answers');

        $data = $this->services['quizzes']->getQuizResult($id, $userAnswers);
        $data['currentUrl'] = $request->input('current_url', '');

        return app()->makeWith('InetStudio\Quizzes\Contracts\Http\Responses\Front\GetQuizResultResponseContract', [
            'data' => $data,
        ]);
    }

    /**
     * Отправляем результат теста на почту.
     *
     * @param SendResultToEmailRequestContract $request
     *
     * @return SendResultToEmailResponseContract
     */
    public function sendResultToEmail(SendResultToEmailRequestContract $request): SendResultToEmailResponseContract
    {
        $quizId = $request->get('quiz_id');
        $resultId = $request->get('result_id');
        $url = $request->get('current_url');
        $email = $request->get('email');

        if ($request->has('subscribe-agree')) {
            $subscriptionService = app()->make('InetStudio\Subscription\Contracts\Services\Front\SubscriptionServiceContract');
            $subscriptionService->subscribeByRequest($request);
        }

        $data = $this->services['quizzes']->sendResultToEmail($quizId, $resultId, $url, $email);

        return app()->makeWith('InetStudio\Quizzes\Contracts\Http\Responses\Front\SendResultToEmailResponseContract', [
            'data' => $data,
        ]);
    }
}
