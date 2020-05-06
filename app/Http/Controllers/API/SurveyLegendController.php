<?php

namespace App\Http\Controllers\API;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PeerList;
use App\Jobs\SendEmail;



class SurveyLegendController extends Controller
{
    public function saveSurveyAnswers (Request $request) {

        $data_json = file_get_contents('php://input');
        $data = json_decode($data_json, true);

        /*$path_json = './json.txt';
        file_put_contents($path_json,serialize($data));
        $file = file_get_contents('./json.txt');
        $data = unserialize($file);*/

        // Peer Collection for participant
        if($data['survey_id'] == '-M5emlCGrGlnMqIDuEi5'){
            if(!empty($data['externalId'])){
                //$data['externalId'] = '234-2';
                $check_peer_list = strripos($data['externalId'], '-');
                if ($check_peer_list === false){
                    $participant_id = $data['externalId'];
                    $participant = Participant::find($participant_id);
                    if(!empty($participant)){
                        //var_dump($participant);die;
                        $participant->success_peer_reflection = 1;

                        $answers = $data['answers'];
                        $emails = array();
                        foreach ($answers as $answer) {
                            if($answer['itemType'] == 'emailBox' && !empty($answer['value'])){
                                $emails[] = trim($answer['value']);
                            }
                        }
                        //var_dump($emails);die;
                        $emails = array_unique($emails);
                        //unset($emails[2]);
                        //var_dump($emails);die;
                        if(!empty($emails)){
                            foreach ($emails as $email){
                                $peer_list_item = new PeerList();
                                $peer_list_item->participant_id = $participant_id;
                                $peer_list_item->email = $email;
                                $peer_list_item->counter_sending_peer_reflection = $peer_list_item->counter_sending_peer_reflection + 1;
                                $peer_list_item->save();
                                $peer_list_item_id = $peer_list_item->id;
                                //var_dump($peer_list_item_id);die;
                                $id = $participant_id . '-' . $peer_list_item_id;
                                $template_path = 'mailing.peerList.peerReflection';
                                SendEmail::dispatch($email, $id, $template_path);
                            }
                            $participant->status_peer_list = 1;
                        }
                        $participant->save();
                    }
                }
                response('',200);
            }
        }

        // Peer Reflection for peer list
        if($data['survey_id'] == '-M6ZX1eqM4oJLyOMXs9c'){
            if(!empty($data['externalId'])){
                $ids = explode('-', $data['externalId']);
                $participant_id = $ids[0];
                $peer_list_item_id = $ids[1];
                $peer_list_item = PeerList::find($peer_list_item_id);
                if(!empty($peer_list_item)){
                    $peer_list_item->success_peer_reflection = 1;
                    $peer_list_item->save();
                }
                response('',200);
            }
        }

        // Self Reflection for participant
        if($data['survey_id'] == '-M6VkzN2n37s5LFncIL7'){
            if (!empty($data['externalId'])){
                $participant = Participant::find($data['externalId']);
                if(!empty($participant)){
                    $participant->success_self_reflection = 1;
                    $participant->save();
                }
                response('',200);
            }
        }
    }
}
