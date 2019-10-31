<?php

namespace App\Http\Controllers\Service;

use App\Entity\Cart;
use App\Entity\Member;
use App\Entity\TempEmail;
use App\Http\Controllers\Controller;
use App\Models\JsonService;
use App\Models\M3Email;
use App\Tool\UUID;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class MemberController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        $data = $request->get('data');
        //手机号注册
        if ($data['register_type'] == 1) {

            if (!Redis::ttl('Phone:' . $data['phone'])) {
                JsonService::responseError("手机验证码已过期");
            }

            $code = Redis::get('Phone:' . $data['phone']);

            if (empty($code) || $code != $data['phone_code']) {
                JsonService::responseError("手机验证码错误");
            }

            $member = Member::where('phone', $data['phone'])->first();

            if (!empty($member->id)) {
                JsonService::responseError("该手机号已注册");
            }

            $member = new Member();
            $member->nickname = $data['name'];
            $member->phone = $data['phone'];
            $member->password = bcrypt($data['password']);
            $res = $member->save();

            if ($res) {
                JsonService::responseOK('注册成功');
            }
        } else {
            $member = Member::where('email', $data['email'])->first();
            if (!empty($member->id)) {
                JsonService::responseError("该邮箱已注册");
            }

            $member = new Member();
            $member->nickname = $data['name'];
            $member->email = $data['email'];
            $member->password = bcrypt($data['password']);
            $member->save();

            $user_id = $member->getQueueableId();

            //发送邮件
            $uuid = UUID::create();
            $m3_email = new M3Email();
            $m3_email->to = $data['email'];
            $m3_email->cc = '15212119227@163.com';
            $m3_email->subject = '华润测试验证';
            $m3_email->content = '请于24小时点击该链接完成验证。' . $_SERVER['HTTP_HOST'] . '/service/validate_email'
                . '?member_id=' . $user_id
                . '&code=' . $uuid;

            $tempEmail = new TempEmail();
            $tempEmail->member_id = $user_id;
            $tempEmail->code = $uuid;
            $tempEmail->deadline = date('Y-m-d H:i:s', time() + 24 * 60 * 60);
            $tempEmail->save();

            Mail::send('email_register', ['m3_email' => $m3_email], function ($m) use ($m3_email) {
                $m->to($m3_email->to, '尊敬的用户')
                    ->cc($m3_email->cc)
                    ->subject($m3_email->subject);
            });

            JsonService::responseOK("注册成功！");
        }

    }

    public function login(Request $request)
    {
        //获取前端数据
        $username = $request->get('username', '');
        $password = $request->get('password', '');


        $m3_request = new JsonService();
        //判断

        $member = null;
        $is_emialuser = false; //是否是邮箱注册用户
        if (strpos($username, '@') != -1) {
            $member = Member::where('email', $username)->first();
            $is_emialuser = true;
        } else {
            $member = Member::where('phone', $username)->first();
        }

        if ($member == null) {
            $m3_request->code = 2;
            $m3_request->message = '该用户不存在';
            return $m3_request->toJson();
        } else {
            //判断密码是否正确

            if (!(Hash::check($password, $member->password))) {
                $m3_request->code = 3;
                $m3_request->message = '密码不正确';
                return $m3_request->toJson();
            }
        }

        if ($member->status == 0) {
            $m3_request->code = 5;
            $m3_request->message = '账户已被禁用请联系客服人员';
            return $m3_request->toJson();
        }

        if ($is_emialuser && $member->active == 0) {
            $m3_request->code = 4;
            $m3_request->message = '账户没激活请去邮箱激活账号';
            return $m3_request->toJson();
        }
        $request->session()->put('member', $member);

        $this->addCartToTable($request);
        $m3_request->code = 0;

        $url = $request->session()->get('redirectPath');

        $request->session()->forget('redirectPath');

        $m3_request->message = $url;
        return $m3_request->toJson();
    }

    public function logout(Request $request)
    {
        $request->session()->forget('member');
        return redirect('/');
    }

    public function addCartToTable(Request $request)
    {

        $cart_arr = $request->cookie('cart');

        if (!empty($cart_arr)) {
            $member_id = $request->session()->get('member')->id;

            foreach ($cart_arr as $k => $v) {
                $cart = Cart::where('member_id', $member_id)->where('product_id', $k)->first();
                if ($cart) {
                    $num = $cart->num + $v;
                    Cart::where('member_id', $member_id)->where('product_id', $k)->update(['num' => $num]);
                } else {
                    $cart = new Cart();
                    $cart->member_id = $member_id;
                    $cart->product_id = $k;
                    $cart->num = $v;
                    $cart->save();

                }
            }
        }

    }

    public function editInfo(Request $request)
    {
        $id = $request->get('member_id');
        $nickname = $request->get('nickname');
        $member = Member::find($id);
        $member->nickname = $nickname;

        $res = $member->save();

        $m3_request = new JsonService();

        if ($res) {
            $request->session()->set('member', $member);
            $m3_request->code = 0;
            $m3_request->message = '修改成功';
        } else {
            $m3_request->code = 1;
            $m3_request->message = '修改失败';
        }

        return $m3_request->toJson();
    }

    public function confimpassword(Request $request)
    {
        $member = Member::find($request->get('member_id'));
        $password = $request->get('password');
        $res = Hash::check($password, $member->password);

        $m3_request = new JsonService();
        if ($res) {
            $m3_request->code = 0;
            $m3_request->message = true;
        } else {
            $m3_request->code = 1;
            $m3_request->message = false;
        }

        return $m3_request->toJson();
    }

    public function changepassword(Request $request)
    {
        $member = Member::find($request->get('member_id'));
        $password = $request->get('password');
        $member->password = bcrypt($password);

        $res = $member->save();

        if ($res) {
            $request->session()->forget('member');
        }
        echo '';
    }
}
