<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class replyDiscussMsg extends Mailable
{
    use Queueable, SerializesModels;

    protected $userName;

    protected $hfUserName;
    protected $content;
    protected $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userName, $hfUserName, $content, $url)
    {
        $this->userName = $userName;
        $this->hfUserName = $hfUserName;
        $this->content = $content;
        $this->url = $url;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.replydiscussmsg')->with([
            'userName'      =>  $this->userName,
            'hfUserName'    =>  $this->hfUserName,
            'content'       =>  $this->content,
            'url'           =>  $this->url
        ]);
    }
}
