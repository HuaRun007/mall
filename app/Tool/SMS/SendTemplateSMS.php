<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2018/10/23
 * Time: 15:09
 */

namespace App\Tool\SMS;


use App\Models\JsonService;

class SendTemplateSMS
{
    //主账号
    private $accountSid = "8aaf0708582eefe901584194c99b0b91";

    //主账号Token
    private $accountToken = "dcaff20496f641feade5d5754043e2db";

    //应用ID
    private $appId = "8aaf0708582eefe901584194ca1e0b95";

    //请求地址
    private $serverIP = "app.cloopen.com";

    //请求端口
    private $serverPort = "8883";

    //REST版本号
    private $softVersion = "2013-12-26 ";

    public function SendTemplateSMS($to,$datas,$tempId)

    {
        // 初始化REST SDK
        $rest = new REST($this->serverIP,$this->serverPort,$this->softVersion);
        $rest->setAccount($this->accountSid,$this->accountToken);
        $rest->setAppId($this->appId);


        // 发送模板短信
        $m3_request = new JsonService();
        $result = $rest->sendTemplateSMS($to,$datas,$tempId);

        if($result == NULL){
            $m3_request->code = 2;
            $m3_request->message = 'result error!';
        }

        if($result->statusCode !=0){
            $m3_request->code = 3;
            $m3_request->message = $result->statusMsg;
        }else{

            $m3_request->code = 0;
            $m3_request->message = '发送成功';
        }

        return $m3_request;
    }

}
