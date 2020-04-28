<?php

namespace App\Http\Controllers\Mailing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Surveys;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendSurveyInvitations($email) {
        Mail::to($email)->send(new Surveys());

        return 'success';
    }
}
