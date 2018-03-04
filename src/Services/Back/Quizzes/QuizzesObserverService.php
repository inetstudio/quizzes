<?php

namespace InetStudio\Quizzes\Services\Back\Quizzes;

use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\Quizzes\Contracts\Repositories\QuizzesRepositoryContract;
use InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesObserverServiceContract;

/**
 * Class QuizzesObserverService.
 */
class QuizzesObserverService implements QuizzesObserverServiceContract
{
    /**
     * @var QuizzesRepositoryContract
     */
    private $repository;

    /**
     * QuizzesService constructor.
     *
     * @param QuizzesRepositoryContract $repository
     */
    public function __construct(QuizzesRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Событие "объект создается".
     *
     * @param QuizModelContract $item
     */
    public function creating(QuizModelContract $item): void
    {
    }

    /**
     * Событие "объект создан".
     *
     * @param QuizModelContract $item
     */
    public function created(QuizModelContract $item): void
    {
    }

    /**
     * Событие "объект обновляется".
     *
     * @param QuizModelContract $item
     */
    public function updating(QuizModelContract $item): void
    {
    }

    /**
     * Событие "объект обновлен".
     *
     * @param QuizModelContract $item
     */
    public function updated(QuizModelContract $item): void
    {
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param QuizModelContract $item
     */
    public function deleting(QuizModelContract $item): void
    {
    }

    /**
     * Событие "объект удален".
     *
     * @param QuizModelContract $item
     */
    public function deleted(QuizModelContract $item): void
    {
    }
}
