<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    private $view_path = 'email_register';
    private $content;

    /**
     * Create a new message instance.
     *
     * @param string $view_path
     * @param $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @param $view_path
     */
    public function setPath($view_path)
    {
        $this->view_path = $view_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->view_path)->with([
            'content'=> $this->content
        ]);
    }
}
