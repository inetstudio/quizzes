<?php

namespace InetStudio\QuizzesPackage\Results\Http\Controllers\Front;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\QuizzesPackage\Results\Contracts\Http\Controllers\Front\ItemsControllerContract;
use InetStudio\QuizzesPackage\Results\Contracts\Http\Requests\Front\SendResultToEmailRequestContract;
use InetStudio\QuizzesPackage\Results\Contracts\Http\Responses\Front\SendResultToEmailResponseContract;

/**
 * Class ItemsController.
 */
class ItemsController extends Controller implements ItemsControllerContract
{
    /**
     * Отправляем результат теста на почту.
     *
     * @param  SendResultToEmailRequestContract  $request
     * @param  SendResultToEmailResponseContract  $response
     *
     * @return SendResultToEmailResponseContract
     */
    public function sendResultToEmail(
        SendResultToEmailRequestContract $request,
        SendResultToEmailResponseContract $response
    ): SendResultToEmailResponseContract {
        return $response;
    }
}
