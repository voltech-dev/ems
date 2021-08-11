<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferletterMail extends Mailable
{
    use Queueable, SerializesModels;  
    public $details;
    public $subject;     
   

    public function __construct($subject,$details)
    {
        $this->subject = $subject;    
        $this->details = $details;   
    }
    
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.offerletter');
    }
}
