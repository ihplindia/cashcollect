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
     public $utitle;
     public $udate;
     public $uamount;
    public function __construct($title,$date,$amount){
      $this->utitle=$title;
      $this->udate=$date;
      $this->uamount=$amount;
}
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
      $email_title=$this->utitle;
      $email_date=$this->udate;
      $email_amount=$this->uamount;
        return $this->subject('Khorcha Notification')->view('admin.income.main.newslatter',compact('email_title','email_date','email_amount'));
    }
}
