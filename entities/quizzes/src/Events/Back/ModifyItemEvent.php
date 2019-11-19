<?php

namespace InetStudio\QuizzesPackage\Quizzes\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var QuizModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param QuizModelContract $item
     */
    public function __construct(QuizModelContract $item)
    {
        $this->item = $item;
    }
}
