<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2019/3/14
 * Time: 18:32
 */

namespace App\Models;


class JsonService
{
    public $code;
    public $message;

    public function toJson(){
        return json_encode($this,JSON_UNESCAPED_UNICODE);
    }

    public static  function responseOK($message=null)
    {
        header('Content-Type: application/json; charset=utf-8');
        if(empty($message)){
            $message="恭喜你，操作成功";
        }
        $response = array(
            "code"	=>	0,
            "title"=> "操作提示",
            "message"=> $message
        );
        echo json_encode($response);
        exit;
    }

    public static function responseError($message = null){
        header('Content-Type: application/json; charset=utf-8');
        if (is_array($message)){
            $error = '';
            foreach ($message as $value){
                foreach ($value as $k => $v){
                    $error .=$v .',';
                }
            }
            $message = $error;
        }

        if(empty($message)){
            $message="操作失败";
        }
        $response = array(
            "code"	=>	300,
            "title"=> "操作提示",
            "message"=> $message
        );
        echo json_encode($response);
        exit;
    }

    public static function responseObj($data = null)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo  json_encode($data,JSON_UNESCAPED_UNICODE);
        exit;

    }

    public static function responseCode($statusCode,$message = null){
        header('Content-Type: application/json; charset=utf-8');
        if(empty($message)){
            $message="恭喜你，操作成功";
        }
        $response = array(
            "code"	=>	$statusCode,
            "title"=> "操作提示",
            "message"=> $message
        );
        echo json_encode($response);
        exit;
    }
}