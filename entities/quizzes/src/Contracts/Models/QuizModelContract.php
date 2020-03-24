<?php

namespace InetStudio\QuizzesPackage\Quizzes\Contracts\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use InetStudio\AdminPanel\Base\Contracts\Models\BaseModelContract;

/**
 * Interface QuizModelContract.
 */
interface QuizModelContract extends BaseModelContract, Auditable, HasMedia
{
}
