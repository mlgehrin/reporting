<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Surveys extends Mailable
{
    use Queueable, SerializesModels;

    //public $mail_data;
    public $user_id;
    public $template_path;
    public $form_id;
    public $first_name;
    public $last_name;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_id, $template_path, $form_id, $first_name, $last_name, $subject)
    {
        $this->user_id = $user_id;
        $this->template_path = $template_path;
        $this->form_id = $form_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view($this->template_path);
    }
}
