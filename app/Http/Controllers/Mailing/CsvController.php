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
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $file = $request->file('csv_file');

                if($file->getClientOriginalExtension() == 'csv'){
                    $fileName = str_replace('.csv', '', $file->getClientOriginalName());

                    $company = new Company();
                    $company->name = $fileName;
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
                        $participant->email = $data[2];
                        $participant->save();
                    }
                }
                //var_dump();die;
                //$csv = array_map('str_getcsv', file($file));
                //var_dump($file->getClientOriginalExtension());die;

                $page = new MailingPageController();
                return $page->LoadPageData();

            }
        }

    }
}
