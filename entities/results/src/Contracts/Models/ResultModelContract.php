<?php

namespace InetStudio\QuizzesPackage\Results\Contracts\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use InetStudio\AdminPanel\Base\Contracts\Models\BaseModelContract;

/**
 * Interface ResultModelContract.
 */
interface ResultModelContract extends BaseModelContract, Auditable, HasMedia
{
}
