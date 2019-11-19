<?php

namespace InetStudio\QuizzesPackage\Answers\Contracts\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use InetStudio\AdminPanel\Base\Contracts\Models\BaseModelContract;

/**
 * Interface AnswerModelContract.
 */
interface AnswerModelContract extends BaseModelContract, Auditable, HasMedia
{
}
