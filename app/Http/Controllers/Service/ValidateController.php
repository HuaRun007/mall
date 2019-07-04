<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2019/3/14
 * Time: 14:54
 */

namespace App\Http\Controllers\Service;


use App\Entity\Member;
use App\Entity\TempEmail;
use App\Entity\TempPhone;
use App\Http\Controllers\Controller;
use App\Models\M3Request;
use App\Tool\SMS\SendTemplateSMS;
use Illuminate\Http\Request;


class ValidateController extends Controller
{


    public function sendSMS(Request $request){
        $phone = $request->input('phone');
        $m3 = new M3Request();
        if($phone == ''){
            $m3->code = 1;
            $m3->message = "手机号不能为空";
            return $m3->toJson();
        }

        $sendTemplateSMS = new SendTemplateSMS();
        $charset = '1234567890'; //随机因子
        $_len    = strlen($charset)-1;
        $code    = '';

        for ($i = 0;$i<6;$i++){
            $code .= $charset[mt_rand(0,$_len)];
        }

        $request = $sendTemplateSMS->SendTemplateSMS($phone, array($code,'5'),'1');

        if($request->code != 0){
            $m3->code = 5;
            $m3->message = '发送失败';

            return $m3->toJson();
        }

        $temp_phone = new TempPhone();
        $temp_phone->phone = $phone;
        $temp_phone->code = $code;
        $temp_phone->deadline = date('Y-m-d H:i:s',time()+10*60);
        $temp_phone->save();

        $m3->code  = 0;
        $m3->message = '发送成功';

        return $m3->toJson();
    }

    public function validateEmail(Request $request)
    {
        $member_id = $request->input('member_id', '');
        $code = $request->input('code', '');

        $tempEmail = TempEmail::where('member_id', $member_id)->first();
        if($tempEmail == null){
            return '验证异常！';
        }

        if($tempEmail->code == $code){
            if(time() > strtotime($tempEmail->deadline)){
                return '该链接已失效！';

            }
            $member = Member::find($member_id);
            $member->active = 1;
            $member->save();

            return redirect('/login');
        } else{
            return '连接已失效！';
        }

    }
}
