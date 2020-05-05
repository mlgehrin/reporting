<?php

namespace App\Http\Controllers\Mailing;

use App\Http\Requests\ParticipantCreateRequest;
use App\Models\Company;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mailing\MailController;
use App\Jobs\SendEmail;

class MailingPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    function LoadPageData(){
        $companies = Company::all();
        $company = $companies->first();

        if(!empty($company)){
            $company_id = $company->id;
            $participants = Participant::where('company_id', $company_id)->get();

            return view('layouts.mailing', compact('companies', 'participants'));

        }

        return view('layouts.mailing');
    }

    public function createParticipant(ParticipantCreateRequest $request)
    {
        $data = $request->input();
        $participant = new Participant();
        $participant->company_id = $data['company_id'];
        $participant->first_name = $data['first_name'];
        $participant->last_name = $data['last_name'];
        $participant->email = $data['email'];
        $participant->self_reflection = !empty($data['self_reflection'])?1:0;
        $participant->peer_reflection = !empty($data['peer_reflection'])?1:0;
        //$participant->peer_collection = 'test';
        $participant->save();

        return $this->LoadPageData()->with('status', 'Participant added successfully!');
    }

    public function removeParticipant(Request $request){
        if($request->has('user_id')){
            $user_id = htmlentities(trim($request->post('user_id')));
            $result = Participant::where('id', $user_id)->delete();

            return array('remove_user' => $result);
        }
    }

    // Fix this START
    public function updatePeerReflection(Request $request){
        if($request->has('peer_reflection')){
            $data = htmlentities(trim($request->post('peer_reflection')));
            $users_id = explode(',', $data);
            foreach ($users_id as $id){
                $participant = Participant::find($id);
                $participant->peer_reflection = 1;
                $participant->save();
            }
            return array('update_peer_reflection' => true);
        }
    }

    public function removePeerReflection(Request $request){
        if($request->has('peer_reflection')){
            $data = htmlentities(trim($request->post('peer_reflection')));
            $users_id = explode(',', $data);
            foreach ($users_id as $id){
                $participant = Participant::find($id);
                $participant->peer_reflection = 0;
                $participant->save();
            }
            return array('remove_peer_reflection' => true);
        }
    }

    public function updateSelfReflection(Request $request){
        if($request->has('self_reflection')){
            $data = htmlentities(trim($request->post('self_reflection')));
            $users_id = explode(',', $data);
            foreach ($users_id as $id){
                $participant = Participant::find($id);
                $participant->self_reflection = 1;
                $participant->save();
            }
            return array('update_self_reflection' => true);
        }
    }

    public function removeSelfReflection(Request $request){
        if($request->has('self_reflection')){
            $data = htmlentities(trim($request->post('self_reflection')));
            $users_id = explode(',', $data);
            foreach ($users_id as $id){
                $participant = Participant::find($id);
                $participant->self_reflection = 0;
                $participant->save();
            }
            return array('update_self_reflection' => true);
        }
    }
    // Fix this END

    public function updateParticipantForCompany(Request $request){
        if($request->has('company_id')){
            $company_id = htmlentities(trim($request->post('company_id')));
            $participants = Participant::where('company_id', $company_id)->get();

            if(!empty($participants)){
                $html = '';
                $html .= '<div id="participant-list" class="list col-9">';
                    $html .= '<table class="participant-list table table-striped">';
                        foreach ($participants as $key => $participant) {
                            $num = ++$key;
                            $checked_self_reflection = $participant->self_reflection == 1?'checked="checked"':'';
                            $checked_peer_reflection = $participant->peer_reflection == 1?'checked="checked"':'';
                            $html .= '<tr class="item-row-' . $participant->id . '">';
                                $html .= '<td>' . $num . '</td>';
                                $html .= '<td>' . $participant->first_name . '</td>';
                                $html .= '<td>' . $participant->last_name . '</td>';
                                $html .= '<td>' . $participant->email . '</td>';
                                $html .= '<td>';
                                    $html .= '<div class="custom-control custom-checkbox">';
                                        $html .= '<input type="checkbox"
                                        class="custom-control-input"
                                        id="self-refl-' . $participant->id . '"
                                        name="self_reflection"
                                        value="' . $participant->self_reflection . '" ' . $checked_self_reflection . '>';
                                        $html .= '<label class="custom-control-label" for="self-refl-' . $participant->id . '">Self Reflection</label>';
                                    $html .= '</div>';
                                $html .= '</td>';
                                $html .= '<td>';
                                    $html .= '<div class="custom-control custom-checkbox">';
                                        $html .= '<input type="checkbox"
                                        class="custom-control-input"
                                        id="peer-refl-' . $participant->id . '"
                                        name="peer_reflection"
                                        value="' . $participant->peer_reflection . '" ' . $checked_peer_reflection . '>';
                                        $html .= '<label class="custom-control-label" for="peer-refl-' . $participant->id . '">Peer Reflection</label>';
                                    $html .= '</div>';
                                $html .= '</td>';
                                $html .= '<td id="remove-participant" data-user-id="' . $participant->id . '">';
                                    $html .= '<button class="btn btn-outline-danger btn-sm">Remove</button>';
                                $html .= '</td>';

                            $html .= '</tr>';
                        }
                    $html .= '</table>';
                $html .= '</div>';

                $response = array(
                    'update' => true,
                    'participant_list' => $html,
                );

                return $response;
            }
            //var_dump($remove_participant, $remove_company);
            return array('update' => false);
        }
    }

    public function removeCompany(Request $request){
        if($request->has('company_id')){
            $company_id = htmlentities(trim($request->post('company_id')));
            Participant::where('company_id', $company_id)->delete();
            $remove_company = Company::destroy($company_id);
            if($remove_company > 0){
                $company = Company::first();
                $company_id = $company->id;
                $participants = Participant::where('company_id', $company_id)->get();

                $response = array(
                    'remove' => true,
                    'company_id' => $company_id,
                    'participant_list' => $participants,
                );

                return $response;
            }
            return array('remove' => false);
        }
    }

    public function initMailing(Request $request){
        if($request->has('company_id')){
            $company_id = htmlentities(trim($request->post('company_id')));
            $participants = Participant::where('company_id', $company_id)->get();

            if(!empty($participants)){

                foreach ($participants as $participant) {

                    if($participant->self_reflection == 1){
                        $template_path = 'mailing.selfReflection';
                        $participant->counter_sending_self_reflection = $participant->counter_sending_self_reflection + 1;
                        $participant->save();
                        SendEmail::dispatch($participant->email, $participant->id, $template_path);
                    }
                    if($participant->peer_reflection == 1){
                        $participant->counter_sending_peer_reflection = $participant->counter_sending_peer_reflection + 1;
                        $participant->save();
                        $template_path = 'mailing.peerCollection';
                        SendEmail::dispatch($participant->email, $participant->id, $template_path);
                    }
                    /*$mail = new MailController();
                    $response = $mail->sendSurveyInvitations($participant->email, $participant->id);*/
                }
                return array(
                    'send' => true
                );
            }
        }
    }
}
