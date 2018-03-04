<?php

namespace InetStudio\Quizzes\Http\Responses\Back\Quizzes;

use Illuminate\View\View;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\IndexResponseContract;

/**
 * Class IndexResponse.
 */
class IndexResponse implements IndexResponseContract, Responsable
{
    /**
     * @var array
     */
    private $data;

    /**
     * IndexResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при открытии списка объектов.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return View
     */
    public function toResponse($request): View
    {
        return view('admin.module.quizzes::back.pages.index', $this->data);
    }
}
