<?php

namespace App\Http\Controllers\API;

use App\Models\Company;
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

        // for tests
        /*$path_json = './json.txt';
        file_put_contents($path_json,serialize($data));
        response('',200);die;
        $file = file_get_contents('./json.txt');
        $data = unserialize($file);*/

        if(!empty($data)){
            if (!empty($data['form_response']['hidden']['participant_id'])){
                $check_peer_list = strripos($data['form_response']['hidden']['participant_id'], '-');
                if($check_peer_list === false){
                    $participant_id = htmlentities(trim($data['form_response']['hidden']['participant_id']));
                    $participant = Participant::find($participant_id);
                    $company = Company::find($participant->company_id);
                    if(!empty($company)){
                        // Self Reflection for participant (typeform)
                        if($company->id_form_self_reflection == $data['form_response']['form_id']){
                            $participant->success_self_reflection = 1;
                            $save = $participant->save();
                            if($save){
                                response('',200);die;
                            }
                        }
                        // Peer Collection for participant (typeform)
                        if($company->id_form_peer_collection == $data['form_response']['form_id']){

                            if(!empty($data['form_response']['answers'])){
                                $participant->success_peer_reflection = 1;

                                $answers = $data['form_response']['answers'];
                                $emails = array();
                                foreach ($answers as $answer) {
                                    if($answer['type'] == 'email' && !empty($answer['email'])){
                                        $emails[] = htmlentities(trim($answer['email']));
                                    }
                                }
                                $emails = array_unique($emails);
                                if(!empty($emails)){
                                    foreach ($emails as $email){
                                        $count_duplicate = PeerList::where('email', $email)->count();
                                        if($count_duplicate >= 5){
                                            continue;
                                        }else{
                                            $peer_list_item = new PeerList();
                                            $peer_list_item->participant_id = $participant_id;
                                            $peer_list_item->email = $email;
                                            $peer_list_item->counter_sending_peer_reflection = $peer_list_item->counter_sending_peer_reflection + 1;
                                            $peer_list_item->save();
                                            $peer_list_item_id = $peer_list_item->id;
                                            $id = $participant_id . '-' . $peer_list_item_id;
                                            $template_path = 'mailing.peerList.peerReflection';
                                            $id_form_peer_reflection = $company->id_form_peer_reflection;
                                            $first_name = $participant->first_name;
                                            $last_name = $participant->last_name;
                                            $subject = $first_name . ' ' . $last_name . ' has asked for your input';
                                            if(!empty($id_form_peer_reflection)){
                                                SendEmail::dispatch($email, $id, $template_path, $id_form_peer_reflection, $first_name, $last_name, $subject);
                                            }
                                        }
                                    }
                                    $participant->status_peer_list = 1;
                                }
                                $save = $participant->save();
                                if($save){
                                    response('',200);die;
                                }
                            }
                        }
                    }
                }
                if($check_peer_list !== false){
                    $survey_participant_id = htmlentities(trim($data['form_response']['hidden']['participant_id']));
                    $ids = explode('-', $survey_participant_id);
                    $participant_id = $ids[0];
                    $participant = Participant::find($participant_id);
                    $company = Company::find($participant->company_id);
                    if(!empty($company)){
                        if($company->id_form_peer_reflection == $data['form_response']['form_id']){
                            $peer_list_item_id = $ids[1];
                            $peer_list_item = PeerList::find($peer_list_item_id);
                            if(!empty($peer_list_item)){
                                $peer_list_item->success_peer_reflection = 1;
                                $save = $peer_list_item->save();
                                if($save){
                                    response('',200);die;
                                }
                            }
                        }
                    }
                }
                response('',200);die;
            }
        }
    }
}
