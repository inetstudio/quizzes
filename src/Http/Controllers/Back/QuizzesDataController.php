<?php

namespace InetStudio\Quizzes\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\Quizzes\Contracts\Http\Controllers\Back\QuizzesDataControllerContract;

/**
 * Class QuizzesDataController.
 */
class QuizzesDataController extends Controller implements QuizzesDataControllerContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    private $services;

    /**
     * QuizzesDataController constructor.
     */
    public function __construct()
    {
        $this->services['dataTables'] = app()->make('InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesDataTableServiceContract');
    }

    /**
     * Получаем данные для отображения в таблице.
     *
     * @return mixed
     */
    public function data()
    {
        return $this->services['dataTables']->ajax();
    }
}
