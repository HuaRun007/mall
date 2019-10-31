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
use App\Http\Controllers\Controller;
use App\Models\JsonService;
use App\Tool\SMS\SendTemplateSMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class ValidateController extends Controller
{


    public function sendSMS(Request $request)
    {
        $phone = $request->input('phone');
        if ($phone == '') {
            JsonService::responseError("手机号不能为空");
        }

        $sendTemplateSMS = new SendTemplateSMS();
        $charset = '1234567890'; //随机因子
        $_len = strlen($charset) - 1;
        $code = '';

        for ($i = 0; $i < 6; $i++) {
            $code .= $charset[mt_rand(0, $_len)];
        }

        $request = $sendTemplateSMS->SendTemplateSMS($phone, array($code, '5'), '1');


        if ($request->code != 0) {
            JsonService::responseError('发送失败');
        }
        $res = Redis::setex('Phone:' . $phone, 5 * 60, $code);

        if($res){
            JsonService::responseOK();
        }

    }

    public function validateEmail(Request $request)
    {
        $member_id = $request->input('member_id', '');
        $code = $request->input('code', '');

        $tempEmail = TempEmail::where('member_id', $member_id)->first();
        if ($tempEmail == null) {
            return '验证异常！';
        }

        if ($tempEmail->code == $code) {
            if (time() > strtotime($tempEmail->deadline)) {
                return '该链接已失效！';
            }
            $member = Member::find($member_id);
            $member->active = 1;
            $member->save();

            return redirect('/login');
        } else {
            return '连接已失效！';
        }

    }
}
