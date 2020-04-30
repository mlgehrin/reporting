<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SurveyLegendController extends Controller
{
    public function saveSurveyAnswers (Request $request) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

var_dump(3242);
            //$json = json_decode($request->getContent(), true);
        $method = $_SERVER['REQUEST_METHOD'];
        $data_json = file_get_contents('php://input');
        var_dump($data_json);
        $data = json_decode($data_json, true);
        var_dump($data);
            $name = $request->input();
            $get = $_GET;
            $post = $_POST;
            $path_get = './get.txt';
            $path_post = './post.txt';
            $path_name = './name.txt';
            $path_json = './json.txt';
            $path_method = './method.txt';
            file_put_contents($path_get,$get);
            file_put_contents($path_post,$post);
            file_put_contents($path_json,serialize($data));
            file_put_contents($path_name,$name);
            file_put_contents($path_method,$method);

       // var_dump(file_put_contents($path_get,$get));die;
        die;
    }
}
