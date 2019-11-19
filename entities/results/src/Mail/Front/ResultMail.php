<?php

namespace InetStudio\QuizzesPackage\Results\Mail\Front;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use InetStudio\QuizzesPackage\Results\Contracts\Mail\Front\ResultMailContract;

/**
 * Class ResultMail.
 */
class ResultMail extends Mailable implements ResultMailContract
{
    use SerializesModels;

    protected $data;

    /**
     * ResultMail constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Результаты теста')
            ->view('admin.module.quizzes-package.results::mails.result', $this->data);
    }
}
