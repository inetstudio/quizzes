<?php

namespace InetStudio\QuizzesPackage\Quizzes\Services\Front;

use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Services\Front\FeedsServiceContract;

/**
 * Class FeedsService.
 */
class FeedsService extends BaseService implements FeedsServiceContract
{
    /**
     * FeedsService constructor.
     *
     * @param  QuizModelContract  $model
     */
    public function __construct(QuizModelContract $model)
    {
        parent::__construct($model);
    }
}
