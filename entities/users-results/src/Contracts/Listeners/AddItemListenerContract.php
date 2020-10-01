<?php

namespace InetStudio\QuizzesPackage\UsersResults\Contracts\Listeners;

/**
 * Interface AddItemListenerContract.
 */
interface AddItemListenerContract
{
    public function handle($event): void;
}
