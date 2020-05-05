<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Mailing\ReminderController;

class SendReminderForPeerReflection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:peerReflectionReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder for survey Peer Reflection';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ReminderController::reminderForPeerReflection();
    }
}
