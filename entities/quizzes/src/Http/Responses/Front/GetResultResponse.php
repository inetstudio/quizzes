<?php

namespace InetStudio\QuizzesPackage\Quizzes\Http\Responses\Front;

use Illuminate\Http\Request;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Http\Responses\Front\GetResultResponseContract;

/**
 * Class GetResultResponse.
 */
class GetResultResponse implements GetResultResponseContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $itemsService;

    /**
     * GetResultResponse constructor.
     *
     * @param  ItemsServiceContract  $itemsService
     */
    public function __construct(ItemsServiceContract $itemsService)
    {
        $this->itemsService = $itemsService;
    }

    /**
     * Возвращаем ответ при выводе результатов теста.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $id = $request->get('id');
        $userAnswers = $request->input('answers');

        $data = $this->itemsService->getItemResult($id, $userAnswers);
        $data['currentUrl'] = $request->input('current_url', '');

        return view('admin.module.quizzes-package.quizzes::front.result', $data);
    }
}
