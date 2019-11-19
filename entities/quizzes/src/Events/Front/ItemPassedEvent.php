<?php

namespace InetStudio\QuizzesPackage\Quizzes\Events\Front;

use Illuminate\Queue\SerializesModels;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Models\QuizModelContract;
use InetStudio\QuizzesPackage\Results\Contracts\Models\ResultModelContract;
use InetStudio\QuizzesPackage\Quizzes\Contracts\Events\Front\ItemPassedEventContract;

/**
 * Class ItemPassedEvent.
 */
class ItemPassedEvent implements ItemPassedEventContract
{
    use SerializesModels;

    /**
     * @var QuizModelContract
     */
    public $quiz;

    /**
     * @var ResultModelContract
     */
    public $result;

    /**
     * @var int
     */
    public $points;

    /**
     * ItemPassedEvent constructor.
     *
     * @param  QuizModelContract  $quiz
     * @param  ResultModelContract  $result
     * @param  int  $points
     */
    public function __construct(QuizModelContract $quiz, ResultModelContract $result, int $points = 0)
    {
        $this->quiz = $quiz;
        $this->result = $result;
        $this->points = $points;
    }
}
