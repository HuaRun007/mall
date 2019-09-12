<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2019/3/14
 * Time: 18:32
 */

namespace App\Models;


class M3Request
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
}