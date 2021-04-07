<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
//use Mail;
use App\Mail\EMSMail;

class SendMissPunchMorning implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $details;
    public $subject; 
    public function __construct($subject,$details)
    {
        $this->subject = $subject;    
        $this->details = $details;   
    }
    public function handle()
    {
        $email = new EMSMail($this->subject, $this->details);
        Mail::to('prakashv85@gmail.com')->send($email);
    }
}
