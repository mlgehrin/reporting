<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PeerList;


class SurveyLegendController extends Controller
{
    public function saveSurveyAnswers (Request $request) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        //$json = json_decode($request->getContent(), true);
        //$name = $request->input();
        //$path_name = './name.txt';

        /*$get = $_GET['id'];
        $path_get = './get.txt';
        file_put_contents($path_get, serialize($get));*/


        /*$data_json = file_get_contents('php://input');
        $data = json_decode($data_json, true);
        $path_json = './json.txt';
        file_put_contents($path_json,serialize($data));
        die;*/

        $file = file_get_contents('./json.txt');
        $data = unserialize($file);


        //file_put_contents($path_name,$name); // тут ощибка
        // добавить разные варианты форм $data['survey_id']
        // если это опрос для сбора емайл адресов заходим сюда
        if($data['survey_id'] = '-M5emlCGrGlnMqIDuEi5'){
            if(!empty($data['externalId'])){
                $data['externalId'] = '234-2';
                $check_if_isset = strripos($data['externalId'], '-');
                if ($check_if_isset === false){
                    $participant_id = $data['externalId'];
                    $answers = $data['answers'];
                    $emails = array();
                    foreach ($answers as $answer) {
                        if($answer['itemType'] == 'emailBox'){
                            $emails[] = $answer['value'];
                        }
                    }
                    $emails = array_unique($emails);
                    if(!empty($emails)){
                        foreach ($emails as $email){
                            $peer_list_item = new PeerList();
                            var_dump($email);die;
                            $peer_list_item->participant_id = $participant_id;
                            $peer_list_item->email = $email;
                            $peer_list_item->save();
                        }

                    }
                    var_dump($emails);die;
                }else{
                    $ids = explode('-', $data['externalId']);
                    $participant_id = $ids[0];
                    $peer_list_item_id = $ids[1];

                    var_dump(32234234);die;
                }

            }
        }
        /// если это простой опрос
        if($data['survey_id']){

        }


    }
}
