<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\Surveys;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $user_id;
    protected $template_path;
    protected $form_id;
    protected $first_name;
    protected $last_name;
    protected $subject;

    public $tries = 3;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $user_id, $template_path, $form_id, $first_name, $last_name, $subject)
    {
        $this->email = $email;
        $this->user_id = $user_id;
        $this->template_path = $template_path;
        $this->form_id = $form_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new Surveys($this->user_id, $this->template_path, $this->form_id, $this->first_name, $this->last_name, $this->subject));
    }
}
