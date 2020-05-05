<?php

namespace App\Console\Commands;

use App\Http\Controllers\Mailing\ReminderController;
use Illuminate\Console\Command;

class SendReminderForPeerCollection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:peerCollectionReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder for survey Peer Collection';

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
        ReminderController::reminderForPeerCollection();
    }
}
