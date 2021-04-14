<?php

namespace InetStudio\QuizzesPackage\UsersResults\Contracts\Listeners;

interface AddItemListenerContract
{
    public function handle($event): void;
}
