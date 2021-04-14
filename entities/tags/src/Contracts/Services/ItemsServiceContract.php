<?php

namespace InetStudio\QuizzesPackage\Tags\Contracts\Services;

use InetStudio\QuizzesPackage\Tags\Contracts\Models\TagModelContract;

interface ItemsServiceContract
{
    public function getModel(): TagModelContract;
}
