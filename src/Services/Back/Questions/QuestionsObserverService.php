<?php

namespace InetStudio\Quizzes\Services\Back\Questions;

use InetStudio\Quizzes\Contracts\Models\QuestionModelContract;
use InetStudio\Quizzes\Contracts\Repositories\QuestionsRepositoryContract;
use InetStudio\Quizzes\Contracts\Services\Back\Questions\QuestionsObserverServiceContract;

/**
 * Class QuestionsObserverService.
 */
class QuestionsObserverService implements QuestionsObserverServiceContract
{
    /**
     * @var QuestionsRepositoryContract
     */
    private $repository;

    /**
     * QuestionsService constructor.
     *
     * @param QuestionsRepositoryContract $repository
     */
    public function __construct(QuestionsRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Событие "объект создается".
     *
     * @param QuestionModelContract $item
     */
    public function creating(QuestionModelContract $item): void
    {
    }

    /**
     * Событие "объект создан".
     *
     * @param QuestionModelContract $item
     */
    public function created(QuestionModelContract $item): void
    {
    }

    /**
     * Событие "объект обновляется".
     *
     * @param QuestionModelContract $item
     */
    public function updating(QuestionModelContract $item): void
    {
    }

    /**
     * Событие "объект обновлен".
     *
     * @param QuestionModelContract $item
     */
    public function updated(QuestionModelContract $item): void
    {
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param QuestionModelContract $item
     */
    public function deleting(QuestionModelContract $item): void
    {
    }

    /**
     * Событие "объект удален".
     *
     * @param QuestionModelContract $item
     */
    public function deleted(QuestionModelContract $item): void
    {
    }
}
