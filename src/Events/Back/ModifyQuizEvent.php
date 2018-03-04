<?php

namespace InetStudio\Quizzes\Events;

use Illuminate\Queue\SerializesModels;
use InetStudio\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\Quizzes\Contracts\Events\Back\ModifyQuizEventContract;

/**
 * Class ModifyQuizEvent.
 */
class ModifyQuizEvent implements ModifyQuizEventContract
{
    use SerializesModels;

    /**
     * @var QuizModelContract
     */
    public $object;

    /**
     * ModifyQuizEvent constructor.
     *
     * @param QuizModelContract $object
     */
    public function __construct(QuizModelContract $object)
    {
        $this->object = $object;
    }
}
