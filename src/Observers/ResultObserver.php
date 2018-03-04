<?php

namespace InetStudio\Quizzes\Observers;

use InetStudio\Quizzes\Contracts\Models\ResultModelContract;
use InetStudio\Quizzes\Contracts\Observers\ResultObserverContract;

/**
 * Class ResultObserver.
 */
class ResultObserver implements ResultObserverContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    protected $services;

    /**
     * ResultObserver constructor.
     */
    public function __construct()
    {
        $this->services['resultsObserver'] = app()->make('InetStudio\Quizzes\Contracts\Services\Back\Results\ResultsObserverServiceContract');
    }

    /**
     * Событие "объект создается".
     *
     * @param ResultModelContract $item
     */
    public function creating(ResultModelContract $item): void
    {
        $this->services['resultsObserver']->creating($item);
    }

    /**
     * Событие "объект создан".
     *
     * @param ResultModelContract $item
     */
    public function created(ResultModelContract $item): void
    {
        $this->services['resultsObserver']->created($item);
    }

    /**
     * Событие "объект обновляется".
     *
     * @param ResultModelContract $item
     */
    public function updating(ResultModelContract $item): void
    {
        $this->services['resultsObserver']->updating($item);
    }

    /**
     * Событие "объект обновлен".
     *
     * @param ResultModelContract $item
     */
    public function updated(ResultModelContract $item): void
    {
        $this->services['resultsObserver']->updated($item);
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param ResultModelContract $item
     */
    public function deleting(ResultModelContract $item): void
    {
        $this->services['resultsObserver']->deleting($item);
    }

    /**
     * Событие "объект удален".
     *
     * @param ResultModelContract $item
     */
    public function deleted(ResultModelContract $item): void
    {
        $this->services['resultsObserver']->deleted($item);
    }    
}
