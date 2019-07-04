<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2019/3/14
 * Time: 14:13
 */

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;
use URL;
use App\Http\Controllers\Controller;


class MemberController extends Controller
{
    public function toLogin(Request $request){
        $is_register = 0;

        $request->session()->put('redirectPath', URL::previous());
        return view('login',compact('is_register'));
    }

    public function toRegister(){
        $is_register =1;
        return view('login',compact('is_register'));
    }
}