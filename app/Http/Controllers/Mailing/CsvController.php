<?php

namespace App\Http\Controllers\Mailing;

use App\Models\Company;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CsvController extends Controller
{
    function saveCsvFile (Request $request){
        if($request->isMethod('post')){
            if($request->hasFile('csv_file')) {

                $file = $request->file('csv_file');
                $data = $request->all();

                if($file->getClientOriginalExtension() == 'csv'){
                    $fileName = str_replace('.csv', '', $file->getClientOriginalName());

                    $company = new Company();
                    $company->name = $fileName;
                    $company->id_form_self_reflection = !empty($data['id_form_self_reflection']) ? htmlentities(trim($data['id_form_self_reflection'])) : NULL;
                    $company->id_form_peer_collection = !empty($data['id_form_peer_collection']) ? htmlentities(trim($data['id_form_peer_collection'])) : NULL;
                    $company->id_form_peer_reflection = !empty($data['id_form_peer_reflection']) ? htmlentities(trim($data['id_form_peer_reflection'])) : NULL;
                    $company->save();

                    $company_id = $company->id;

                    $csvFile = file($file);

                    foreach ($csvFile as $key => $line) {
                        if($key == 0){
                            continue;
                        }
                        $data = explode(';', $line);

                        $participant = new Participant();
                        $participant->company_id = $company_id;
                        $participant->first_name = $data[0];
                        $participant->last_name = $data[1];
                        $participant->email = trim($data[2]);
                        $participant->save();
                    }
                }
                return array('save_file' => true);
            }
            return array('save_file' => false);
        }
    }
}
