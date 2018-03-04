<?php

namespace InetStudio\Quizzes\Services\Back\Results;

use InetStudio\Quizzes\Contracts\Models\ResultModelContract;
use InetStudio\Quizzes\Contracts\Repositories\ResultsRepositoryContract;
use InetStudio\Quizzes\Contracts\Services\Back\Results\ResultsObserverServiceContract;

/**
 * Class ResultsObserverService.
 */
class ResultsObserverService implements ResultsObserverServiceContract
{
    /**
     * @var ResultsRepositoryContract
     */
    private $repository;

    /**
     * ResultsService constructor.
     *
     * @param ResultsRepositoryContract $repository
     */
    public function __construct(ResultsRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Событие "объект создается".
     *
     * @param ResultModelContract $item
     */
    public function creating(ResultModelContract $item): void
    {
    }

    /**
     * Событие "объект создан".
     *
     * @param ResultModelContract $item
     */
    public function created(ResultModelContract $item): void
    {
    }

    /**
     * Событие "объект обновляется".
     *
     * @param ResultModelContract $item
     */
    public function updating(ResultModelContract $item): void
    {
    }

    /**
     * Событие "объект обновлен".
     *
     * @param ResultModelContract $item
     */
    public function updated(ResultModelContract $item): void
    {
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param ResultModelContract $item
     */
    public function deleting(ResultModelContract $item): void
    {
    }

    /**
     * Событие "объект удален".
     *
     * @param ResultModelContract $item
     */
    public function deleted(ResultModelContract $item): void
    {
    }
}
