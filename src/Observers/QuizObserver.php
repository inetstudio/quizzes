<?php

namespace InetStudio\Quizzes\Observers;

use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\Quizzes\Contracts\Observers\QuizObserverContract;

/**
 * Class QuizObserver.
 */
class QuizObserver implements QuizObserverContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    protected $services;

    /**
     * QuizObserver constructor.
     */
    public function __construct()
    {
        $this->services['quizzesObserver'] = app()->make('InetStudio\Quizzes\Contracts\Services\Back\Quizzes\QuizzesObserverServiceContract');
    }

    /**
     * Событие "объект создается".
     *
     * @param QuizModelContract $item
     */
    public function creating(QuizModelContract $item): void
    {
        $this->services['quizzesObserver']->creating($item);
    }

    /**
     * Событие "объект создан".
     *
     * @param QuizModelContract $item
     */
    public function created(QuizModelContract $item): void
    {
        $this->services['quizzesObserver']->created($item);
    }

    /**
     * Событие "объект обновляется".
     *
     * @param QuizModelContract $item
     */
    public function updating(QuizModelContract $item): void
    {
        $this->services['quizzesObserver']->updating($item);
    }

    /**
     * Событие "объект обновлен".
     *
     * @param QuizModelContract $item
     */
    public function updated(QuizModelContract $item): void
    {
        $this->services['quizzesObserver']->updated($item);
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param QuizModelContract $item
     */
    public function deleting(QuizModelContract $item): void
    {
        $this->services['quizzesObserver']->deleting($item);
    }

    /**
     * Событие "объект удален".
     *
     * @param QuizModelContract $item
     */
    public function deleted(QuizModelContract $item): void
    {
        $this->services['quizzesObserver']->deleted($item);
    }
}
