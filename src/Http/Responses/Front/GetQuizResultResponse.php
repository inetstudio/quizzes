<?php

namespace InetStudio\Quizzes\Http\Responses\Front;

use Illuminate\View\View;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Quizzes\Contracts\Http\Responses\Front\GetQuizResultResponseContract;

/**
 * Class GetQuizResultResponse.
 */
class GetQuizResultResponse implements GetQuizResultResponseContract, Responsable
{
    /**
     * @var array
     */
    private $data;

    /**
     * GetQuizResultResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при выводе результатов теста.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return View
     */
    public function toResponse($request): View
    {
        return view('admin.module.quizzes::front.result', $this->data);
    }
}
