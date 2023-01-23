<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IncomeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mailData=array();
    public $subject='';
    public function __construct($mailData,$subject)
    {
        $this->mailData=$mailData;
        $this->subject = $subject;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
      $mailData =$this->mailData;
      $subject =$this->subject;

      return $this->subject($subject)->view('admin.income.main.newslatter',compact('mailData'));
    }
}
