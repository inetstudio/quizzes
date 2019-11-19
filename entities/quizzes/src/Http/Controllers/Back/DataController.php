<?php

namespace InetStudio\QuizzesPackage\Quizzes\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Controllers\Back\DataControllerContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract;

/**
 * Class DataController.
 */
class DataController extends Controller implements DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param  Request  $request
     * @param  GetIndexDataResponseContract  $response
     *
     * @return GetIndexDataResponseContract
     */
    public function getIndexData(Request $request, GetIndexDataResponseContract $response): GetIndexDataResponseContract
    {
        return $response;
    }
}
