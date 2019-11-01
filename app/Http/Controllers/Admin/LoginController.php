<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JsonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Response
     */
    protected $username = 'username';

    public function index()
    {
        if(Auth::check())
        {
            return Redirect::to('/admin/');
        }

        return View('admin.login');
    }

    /**
     * Post login credentials
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {

        $data['username'] = $request->get('username');
        $data['password'] = $request->get('password');
        $username = isset($data['username']) ? $data['username'] : null;
        $password = isset($data['password']) ? $data['password'] : null;
        $remember = isset($data['remember']) ? $data['remember'] : null;
        $m3_request = new JsonService();
        if(Auth::attempt(['username' => $username, 'password' => $password], $remember))
        {
            if($request->user()->status != 1){
                Auth::logout();
                $m3_request->code = 1;
                $m3_request->message = '该账号已被禁用！';
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

    /**
     * Log out
     *
     * @return Response
     */
    public function logout()
    {
        Auth::logout();

        return Redirect::to('/admin/login');
    }

}
