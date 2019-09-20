<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2019/3/23
 * Time: 12:54
 */

namespace App\Http\Controllers\Service;


use App\Entity\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JsonService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class LoginController extends Controller
{
    protected $username;
    public function login(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        if(strpos($username, '@') != -1){
            $this->username = 'phone';
        } else{
            $this->username = 'email';
        }
        dd($this->username);
        $m3_request = new JsonService();
        if(Auth::attempt(['username' => $username, 'password' => $password]))
        {
            if($request->user()->status != 1){
                Auth::logout();
                $m3_request->code = 1;
                $m3_request->message = '该账号已被禁用！';
                return $m3_request->toJson();
            }elseif ($request->user()->active != 1 && $this->username=='email'){
                Auth::logout();
                $m3_request->code = 2;
                $m3_request->message = '账户没激活请去邮箱激活账号！';
                return $m3_request->toJson();
            }else{
                $m3_request->code = 0;
                $m3_request->message = '登录成功！';
                return $m3_request->toJson();
            }

        }else{
            $m3_request->code = 2;
            $m3_request->message = '用户名或密码错误！';
            return $m3_request->toJson();
        }
    }
}