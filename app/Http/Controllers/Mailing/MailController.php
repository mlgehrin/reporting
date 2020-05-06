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
   /* public function sendSurveyInvitations($email, $user_id) {
        Mail::to($email)->send(new Surveys($user_id));

        return 'success';
    }*/

    public function unsubscribeSelfReflection($user_id) {
        $user_id = htmlentities(trim($user_id));
        $participant = Participant::find($user_id);
        if($participant->unsubscribed_self_reflection == 0){
            $participant->unsubscribed_self_reflection = 1;
            $result = $participant->save();
        }else{
            $result = false;
        }
        return view('mailing.unsubscribe', compact('result'));
    }

    //  for participant PeerCollection equally PeerReflection
    public function unsubscribePeerCollection($user_id) {
        $user_id = htmlentities(trim($user_id));
        $participant = Participant::find($user_id);
        if($participant->unsubscribed_peer_reflection == 0){
            $participant->unsubscribed_peer_reflection = 1;
            $result = $participant->save();
        }else{
            $result = false;
        }
        return view('mailing.unsubscribe', compact('result'));
    }



    public function unsubscribePeerList($user_id) {
        $user_id = htmlentities(trim($user_id));
        $peer_list_item = PeerList::find($user_id);
        if($peer_list_item->unsubscribed_peer_reflection == 0){
            $peer_list_item->unsubscribed_peer_reflection = 1;
            $result = $peer_list_item->save();
        }else{
            $result = false;
        }
        return view('mailing.unsubscribe', compact('result'));
    }

}
