<?php

namespace App\Http\Controllers\Mailing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\PeerList;
use App\Jobs\SendEmail;


class ReminderController extends Controller
{
    public static function reminderForSelfReflection(){

        $participants = Participant::where([['self_reflection', '1'], ['success_self_reflection', '0'], ['unsubscribed_self_reflection', '0']])->get();

        if(!empty($participants)){
            foreach ($participants as $participant) {
                $template_path = 'mailing.reminder.selfReflection';
                $participant->reminder_self_reflection = $participant->reminder_self_reflection + 1;
                $participant->save();
                SendEmail::dispatch($participant->email, $participant->id, $template_path);
            }
        }

    }

    public static function reminderForPeerCollection(){

        $participants = Participant::where([['peer_reflection', '1'], ['success_peer_reflection', '0'], ['unsubscribed_peer_reflection', '0']])->get();

        if(!empty($participants)){
            foreach ($participants as $participant) {
                $template_path = 'mailing.reminder.peerCollection';
                $participant->reminder_peer_reflection = $participant->reminder_peer_reflection + 1;
                $participant->save();
                SendEmail::dispatch($participant->email, $participant->id, $template_path);
            }
        }

    }

    public static function reminderForPeerReflection(){

        $peer_list = PeerList::where([['peer_reflection', '1'], ['success_peer_reflection', '0'], ['unsubscribed_peer_reflection', '0']])->get();

        if(!empty($peer_list)){
            foreach ($peer_list as $peer_list_item) {
                $template_path = 'mailing.reminder.peerReflection';
                $peer_list_item->reminder_peer_reflection = $peer_list_item->reminder_peer_reflection + 1;
                $peer_list_item->save();
                SendEmail::dispatch($peer_list_item->email, $peer_list_item->id, $template_path);
            }
        }

    }
}
