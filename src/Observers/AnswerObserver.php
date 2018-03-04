<?php

namespace InetStudio\Quizzes\Observers;

use InetStudio\Quizzes\Contracts\Models\AnswerModelContract;
use InetStudio\Quizzes\Contracts\Observers\AnswerObserverContract;

/**
 * Class AnswerObserver.
 */
class AnswerObserver implements AnswerObserverContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    protected $services;

    /**
     * AnswerObserver constructor.
     */
    public function __construct()
    {
        $this->services['answersObserver'] = app()->make('InetStudio\Quizzes\Contracts\Services\Back\Answers\AnswersObserverServiceContract');
    }

    /**
     * Событие "объект создается".
     *
     * @param AnswerModelContract $item
     */
    public function creating(AnswerModelContract $item): void
    {
        $this->services['answersObserver']->creating($item);
    }

    /**
     * Событие "объект создан".
     *
     * @param AnswerModelContract $item
     */
    public function created(AnswerModelContract $item): void
    {
        $this->services['answersObserver']->created($item);
    }

    /**
     * Событие "объект обновляется".
     *
     * @param AnswerModelContract $item
     */
    public function updating(AnswerModelContract $item): void
    {
        $this->services['answersObserver']->updating($item);
    }

    /**
     * Событие "объект обновлен".
     *
     * @param AnswerModelContract $item
     */
    public function updated(AnswerModelContract $item): void
    {
        $this->services['answersObserver']->updated($item);
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param AnswerModelContract $item
     */
    public function deleting(AnswerModelContract $item): void
    {
        $this->services['answersObserver']->deleting($item);
    }

    /**
     * Событие "объект удален".
     *
     * @param AnswerModelContract $item
     */
    public function deleted(AnswerModelContract $item): void
    {
        $this->services['answersObserver']->deleted($item);
    }
}
