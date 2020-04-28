<?php

namespace App\Http\Controllers\Mailing;

use App\Http\Requests\ParticipantCreateRequest;
use App\Models\Company;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mailing\MailController;

class MailingPageController extends Controller
{
    function LoadPageData(){
        $companies = Company::all();
        $company = $companies->first();
        //var_dump($company);die;
        if(!empty($company)){
            $company_id = $company->id;
            $participants = Participant::where('company_id', $company_id)->get();
            return view('layouts.mailing', compact('companies', 'participants'));

        }

        return view('layouts.mailing');

        //Company::where('id', 23)->delete();
        //var_dump(Participant::where('company_id', 22)->delete());die;
        //var_dump($participants);die;
        //$participants = Participant::all();
        //var_dump($companies);die;
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

    public function initMailing(Request $request){
        if($request->has('company_id')){
            $company_id = htmlentities(trim($request->post('company_id')));
            $participants = Participant::where('company_id', $company_id)->get();

            if(!empty($participants)){
                $data =  array();
                foreach ($participants as $participant) {
                    $mail = new MailController();
                    $response = $mail->sendSurveyInvitations($participant->email, $participant->id);
                    $data[] = $response;
                    //var_dump($participant->email);die;
                }
                return $data;
            }
        }
    }
}
