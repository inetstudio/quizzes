<?php

namespace InetStudio\QuizzesPackage\Questions\Contracts\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use InetStudio\AdminPanel\Base\Contracts\Models\BaseModelContract;

/**
 * Interface QuestionModelContract.
 */
interface QuestionModelContract extends BaseModelContract, Auditable, HasMedia
{
}
