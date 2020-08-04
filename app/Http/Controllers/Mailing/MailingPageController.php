<?php

namespace App\Http\Controllers\Mailing;

use App\Http\Requests\ParticipantCreateRequest;
use App\Models\Company;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mailing\MailController;
use App\Jobs\SendEmail;
use Carbon\Carbon;

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

        $participant->save();

        return array('create_user' => true);
        //return $this->LoadPageData()->with('status', 'Participant added successfully!');
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

            $html = '';
            if(!empty($participants)){

                $html .= '<div id="participant-list" class="list col-10">';
                    $html .= '<table class="participant-list table table-striped table-sm">';
                        foreach ($participants as $key => $participant) {
                            $num = ++$key;
                            $checked_self_reflection = $participant->self_reflection == 1?'checked="checked"':'';
                            $checked_peer_reflection = $participant->peer_reflection == 1?'checked="checked"':'';
                            $data_send_self_reflection = $participant->data_send_self_reflection === null?'not sent':$participant->data_send_self_reflection;
                            $data_send_peer_reflection = $participant->data_send_peer_reflection === null?'not sent':$participant->data_send_peer_reflection;
                            $html .= '<tr class="item-row-' . $participant->id . '">';
                                $html .= '<td class="align-middle"><small>' . $num . '</small></td>';
                                $html .= '<td class="align-middle">' . $participant->first_name . ' ' . $participant->last_name . '</td>';
                                $html .= '<td class="align-middle">' . $participant->email . '</td>';
                                $html .= '<td>';
                                    $html .= '<div class="custom-control custom-checkbox"><div class="row">';
                                        $html .= '<input type="checkbox"
                                        class="custom-control-input"
                                        id="self-refl-' . $participant->id . '"
                                        data-user-id= ' . $participant->id . '
                                        name="self_reflection"
                                        value="' . $participant->self_reflection . '" ' . $checked_self_reflection . '>';
                                        $html .= '<label class="custom-control-label" for="self-refl-' . $participant->id . '">Self Reflection</label>';
                                    $html .= '</div></div>';
                                    $html .= '<div class="row"><small>' . $data_send_self_reflection . '</small></div>';
                                $html .= '</td>';
                                $html .= '<td>';
                                    $html .= '<div class="custom-control custom-checkbox"><div class="row">';
                                        $html .= '<input type="checkbox"
                                        class="custom-control-input"
                                        id="peer-refl-' . $participant->id . '"
                                        data-user-id= ' . $participant->id . '
                                        name="peer_reflection"
                                        value="' . $participant->peer_reflection . '" ' . $checked_peer_reflection . '>';
                                        $html .= '<label class="custom-control-label" for="peer-refl-' . $participant->id . '">Leadership Reflection</label>';
                                    $html .= '</div></div>';
                                    $html .= '<div class="row"><small>' . $data_send_peer_reflection . '</small></div>';
                                $html .= '</td>';
                                $html .= '<td id="remove-participant" data-user-id="' . $participant->id . '" class="align-middle">';
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

    public function updateSurveyFormId(Request $request){
        $form_id = htmlentities(trim($request->post('form_id')));
        $form_name = htmlentities(trim($request->post('form_name')));
        $company_id = htmlentities(trim($request->post('company_id')));
        if(!empty($company_id) && !empty($form_name)){
            $company = Company::find($company_id);
            if(!empty($company)){
                $save = false;
                if($form_name == 'id_form_self_reflection'){
                    $company->id_form_self_reflection = $form_id;
                    $save = $company->save();
                }
                if($form_name == 'id_form_peer_collection'){
                    $company->id_form_peer_collection = $form_id;
                    $save = $company->save();
                }
                if($form_name == 'id_form_peer_reflection'){
                    $company->id_form_peer_reflection = $form_id;
                    $save = $company->save();
                }
                if($save){
                    return array(
                        'update' => true
                    );
                }
            }
        }
        return array(
            'update' => false
        );
    }

    public function changeSurveyFormId(Request $request){
        if($request->has('company_id')){

            $company_id = htmlentities(trim($request->post('company_id')));
            $company = Company::find($company_id);
            $id_form_self_reflection = !empty($company->id_form_self_reflection) ? $company->id_form_self_reflection : '';
            $id_form_peer_collection = !empty($company->id_form_peer_collection) ? $company->id_form_peer_collection : '';
            $id_form_peer_reflection = !empty($company->id_form_peer_reflection) ? $company->id_form_peer_reflection : '';

            $html = '';
            if(!empty($company)){
                $html .= '<label class="col-4">';
                $html .= '<input class="form-control survey-id" 
                                        name="id_form_self_reflection" 
                                        data-company-id="' . $company->id . '" 
                                        type="text" 
                                        value="' . $id_form_self_reflection . '">';
                $html .= 'Self Reflection ID</label>';

                $html .= '<label class="col-4">';
                $html .= '<input class="form-control survey-id" 
                                        name="id_form_peer_collection" 
                                        data-company-id="' . $company->id . '" 
                                        type="text" 
                                        value="' . $id_form_peer_collection . '">';
                $html .= 'Leadership Collection ID</label>';

                $html .= '<label class="col-4">';
                $html .= '<input class="form-control survey-id" 
                                        name="id_form_peer_reflection" 
                                        data-company-id="' . $company->id . '" 
                                        type="text" 
                                        value="' . $id_form_peer_reflection . '">';
                $html .= 'Leadership Reflection ID</label>';

                $response = array(
                    'change' => true,
                    'forms_id' => $html,
                );

                return $response;
            }
            return array('change' => false);
        }
    }

    public function initMailing(Request $request){
        if($request->has('company_id')){
            $company_id = htmlentities(trim($request->post('company_id')));
            $participants = Participant::where('company_id', $company_id)->get();
            $company = Company::find($company_id)->first();

            if(!empty($participants) && !empty($company)){
                $forms_submitted = 0;
                foreach ($participants as $participant) {

                    if($participant->self_reflection == 1 && $participant->unsubscribed_self_reflection == 0){
                        $id_form_self_reflection = $company->id_form_self_reflection;
                        if(!empty($id_form_self_reflection)){
                            $participant->counter_sending_self_reflection = $participant->counter_sending_self_reflection + 1;
                            $participant->data_send_self_reflection = Carbon::now('-7:00');
                            $participant->save();
                            $template_path = 'mailing.selfReflection';
                            $first_name = $participant->first_name;
                            $last_name = $participant->last_name;
                            $subject = 'Your Move Mountains Self Reflection';
                            SendEmail::dispatch($participant->email, $participant->id, $template_path, $id_form_self_reflection, $first_name, $last_name, $subject);
                            $forms_submitted++;
                        }

                    }
                    if($participant->peer_reflection == 1 && $participant->unsubscribed_peer_reflection == 0){
                        $id_form_peer_collection = $company->id_form_peer_collection;
                        if(!empty($id_form_peer_collection)){
                            $participant->counter_sending_peer_reflection = $participant->counter_sending_peer_reflection + 1;
                            $participant->data_send_peer_reflection = Carbon::now('-7:00');
                            $participant->save();
                            $template_path = 'mailing.peerCollection';
                            $id_form_peer_collection = $company->id_form_peer_collection;
                            $first_name = $participant->first_name;
                            $last_name = $participant->last_name;
                            $subject = 'Your Move Mountains Leadership Reflection';
                            SendEmail::dispatch($participant->email, $participant->id, $template_path, $id_form_peer_collection, $first_name, $last_name, $subject);
                            $forms_submitted++;
                        }
                    }
                }

                if($forms_submitted > 0){
                    return array(
                        'send' => true
                    );
                }
                return array(
                    'send' => false
                );
            }
        }
    }
}
