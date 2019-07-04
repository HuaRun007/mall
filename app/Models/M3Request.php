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
}