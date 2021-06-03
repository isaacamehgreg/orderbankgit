<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DefaultMailer extends Mailable
{
    use Queueable, SerializesModels;
    protected $payload;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payload)
    {
        $this->payload = (object) $payload;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->payload->view)->with($this->payload->data)->subject($this->payload->subject)->from('support@orderbank.com.ng', 'OrderBank App');
    }
}
