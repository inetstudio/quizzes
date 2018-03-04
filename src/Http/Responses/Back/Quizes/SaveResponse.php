<?php

namespace InetStudio\Quizzes\Http\Responses\Back\Quizzes;

use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\Quizzes\Contracts\Http\Responses\Back\Quizzes\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract, Responsable
{
    /**
     * @var QuizModelContract
     */
    private $item;

    /**
     * SaveResponse constructor.
     *
     * @param QuizModelContract $item
     */
    public function __construct(QuizModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        return response()->redirectToRoute('back.quizzes.edit', [
            $this->item->fresh()->id,
        ]);
    }
}
