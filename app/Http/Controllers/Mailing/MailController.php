<?php

namespace App\Http\Controllers\Mailing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Surveys;
use Illuminate\Support\Facades\Mail;
use App\Models\Participant;
use App\Models\PeerList;

class MailController extends Controller
{
    public function sendSurveyInvitations($email, $user_id) {
        Mail::to($email)->send(new Surveys($user_id));

        return 'success';
    }

    // add function for another surveys

    public function unsubscribe($user_id) {
        $user_id = htmlentities(trim($user_id));
        $result = Participant::where('id', $user_id)->delete();
        return view('mailing.unsubscribe', compact('result'));
    }

    public function unsubscribePeerList($user_id) {
        $user_id = htmlentities(trim($user_id));
        $result = PeerList::where('id', $user_id)->delete();
        return view('mailing.unsubscribe', compact('result'));
    }

}
