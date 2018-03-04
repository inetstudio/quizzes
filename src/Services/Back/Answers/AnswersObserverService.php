<?php

namespace InetStudio\Quizzes\Services\Back\Answers;

use InetStudio\Quizzes\Contracts\Models\AnswerModelContract;
use InetStudio\Quizzes\Contracts\Repositories\AnswersRepositoryContract;
use InetStudio\Quizzes\Contracts\Services\Back\Answers\AnswersObserverServiceContract;

/**
 * Class AnswersObserverService.
 */
class AnswersObserverService implements AnswersObserverServiceContract
{
    /**
     * @var AnswersRepositoryContract
     */
    private $repository;

    /**
     * AnswersService constructor.
     *
     * @param AnswersRepositoryContract $repository
     */
    public function __construct(AnswersRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Событие "объект создается".
     *
     * @param AnswerModelContract $item
     */
    public function creating(AnswerModelContract $item): void
    {
    }

    /**
     * Событие "объект создан".
     *
     * @param AnswerModelContract $item
     */
    public function created(AnswerModelContract $item): void
    {
    }

    /**
     * Событие "объект обновляется".
     *
     * @param AnswerModelContract $item
     */
    public function updating(AnswerModelContract $item): void
    {
    }

    /**
     * Событие "объект обновлен".
     *
     * @param AnswerModelContract $item
     */
    public function updated(AnswerModelContract $item): void
    {
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param AnswerModelContract $item
     */
    public function deleting(AnswerModelContract $item): void
    {
    }

    /**
     * Событие "объект удален".
     *
     * @param AnswerModelContract $item
     */
    public function deleted(AnswerModelContract $item): void
    {
    }
}
