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
    public $docname;

    public function __construct($subject,$details,$docname)
    {
        $this->subject = $subject;    
        $this->details = $details;   
        $this->docname = $docname;  
    }
    
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.offerletter')->with(['details'=>$this->details])
                    ->attachFromStorage('/public/employee/', $this->docname, [
                        'mime' => 'application/pdf'
                    ]);
    }
}
