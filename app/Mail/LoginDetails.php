<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginDetails extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $myArray;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($myArray)
    {
        $this->myArray = $myArray;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.LoginEmail.details');
    }
}
