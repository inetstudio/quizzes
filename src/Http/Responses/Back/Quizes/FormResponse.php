<?php

namespace InetStudio\Quizzes\Http\Responses\Back\Quizzes;

use Illuminate\View\View;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\FormResponseContract;

/**
 * Class FormResponse.
 */
class FormResponse implements FormResponseContract, Responsable
{
    /**
     * @var array
     */
    private $data;

    /**
     * FormResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при открытии формы объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return View
     */
    public function toResponse($request): View
    {
        return view('admin.module.quizzes::back.pages.form', $this->data);
    }
}
