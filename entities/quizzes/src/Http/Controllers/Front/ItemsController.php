<?php

namespace InetStudio\QuizzesPackage\Quizzes\Http\Controllers\Front;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Requests\Front\GetDataRequestContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Requests\Front\GetResultRequestContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Front\GetDataResponseContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Controllers\Front\ItemsControllerContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Front\GetResultResponseContract;

/**
 * Class ItemsController.
 */
class ItemsController extends Controller implements ItemsControllerContract
{
    /**
     * Получаем информацию по тесту.
     *
     * @param  GetDataRequestContract  $request
     * @param  GetDataResponseContract  $response
     *
     * @return GetDataResponseContract
     */
    public function getData(
        GetDataRequestContract $request,
        GetDataResponseContract $response
    ): GetDataResponseContract {
        return $response;
    }

    /**
     * Получаем результат теста на основе ответов пользователя.
     *
     * @param  GetResultRequestContract  $request
     * @param  GetResultResponseContract  $response
     *
     * @return GetResultResponseContract
     */
    public function getResult(
        GetResultRequestContract $request,
        GetResultResponseContract $response
    ): GetResultResponseContract {
        return $response;
    }
}
