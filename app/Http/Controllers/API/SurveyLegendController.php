<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SurveyLegendController extends Controller
{
    public function saveSurveyAnswers (Request $request) {
        //if(!empty($_GET) || !empty($_POST)){

            //$json = json_decode($request->getContent(), true);
        $data_json = file_get_contents('php://input');
        $data = json_decode($data_json, true);
            $name = $request->input();
            $get = $_GET;
            $post = $_POST;
            $path_get = './get.txt';
            $path_post = './post.txt';
            $path_name = './name.txt';
            $path_json = './json.txt';
            file_put_contents($path_get,$get);
            file_put_contents($path_post,$post);
            file_put_contents($path_json,$data);
            file_put_contents($path_name,$name);
        //}
       // var_dump(file_put_contents($path_get,$get));die;
    }
}
