<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2019/3/19
 * Time: 19:24
 */

namespace App\Http\Controllers\Admin;


use App\Entity\Member;
use App\Entity\Order;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function toLogin()
    {
        return view('admin.login');
    }
    public function toWelcome(Request $request)
    {
        $user = $request->user();
        $data['member_num'] = Member::count();
        $data['order_num'] = Order::count();
        $data['product_num'] = Product::count();
        $data['total_amount'] = Order::sum('total_amount');

        return view('admin.index.welcome')->with('data', $data)->with('user', $user);
    }
    public function toIndex(Request $request)
    {
        $user = $request->user();
        return view('admin.index.index',compact('user'));
    }

}