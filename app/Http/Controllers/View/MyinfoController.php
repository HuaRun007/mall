<?php

namespace App\Http\Controllers\View;

use App\Entity\Category;
use App\Entity\Member;
use App\Entity\Order;
use App\Entity\OrderDetail;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MyinfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $member = $request->session()->get('member','');
        $index_category = Category::where('parent_id',0)->get();
        $payorders = Order::where('member_id',$member->id)->where('paystatus',2)->count();
        $waitorders = Order::where('member_id',$member->id)->where('status',2)->count();
        $waitreviews = OrderDetail::leftJoin('orders','order_detail.order_id','=','orders.id')->where('orders.member_id',$member->id)->whereNull('reviewed_at')->count();

        return view('center',compact('member','index_category','payorders','waitorders','waitreviews'));
    }

    public function toInfo(Request $request)
    {
        $member = $request->session()->get('member','');
        $member = Member::find($member->id);
        $index_category = Category::where('parent_id',0)->get();

        return view('edit_info',compact('member','index_category'));
    }

    public function toRestPassword(Request $request)
    {
        $member = $request->session()->get('member','');
        $index_category = Category::where('parent_id',0)->get();
        return view('restpassword',compact('member','index_category'));
    }
}
