<?php

namespace App\Http\Controllers\View;

use App\Entity\Category;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Product;
use App\Models\M3Request;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class OrderController extends Controller
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
        $orders = Order::with('order_detail')->where('member_id',$member->id)->orderBy('created_at','desc')->get();

        return view('order',compact('member','index_category','orders'));
    }


    public function buyOne(Request $request,$product_id,$num)
    {
        $member = $request->session()->get('member','');
        $index_category = Category::where('parent_id',0)->get();


        $order_product = Product::find($product_id);
        $order_product->num = $num;
        $is_buyone = 1;
        $sum_price = doubleval($num*$order_product->price);
        $order_product->sumprice = sprintf("%.2f",$sum_price);

        $request->session()->set('buyone_product',$order_product);

        return view('order_pay',compact('member','index_category','order_product','is_buyone'));
    }

    public function toPay(Request $request)
    {

        $orderno = $this->setOrderno();

        return view('alipay',compact('orderno'));
    }

    public function toPay_no(Request $request,$no)
    {

        $orderno = $no;

        return view('alipay_again',compact('orderno'));
    }

    public function buy(Request $request)
    {
        $products = $request->get('products');

        $sum_price = 0;

        foreach ($products as $item){
            $item['sumprice'] = doubleval($item['num']*$item['price']);
            $sum_price += doubleval($item['num']*$item['price']);
        }

        $request->session()->set('cart_products',$products);

        $m3_request = new M3Request();

        $m3_request->code = 0;
        $m3_request->message = '成功！';

        return $m3_request->toJson();

    }

    public function toBuy(Request $request)
    {
        $member = $request->session()->get('member','');
        $index_category = Category::where('parent_id',0)->get();
        $order_product = $request->session()->get('cart_products','');
        $sum_price = 0;

        foreach ($order_product as $item){

            $sum_price += $item['sumprice'];
        }

        $is_buyone = 0;
        return view('order_pay',compact('member','index_category','order_product','is_buyone','sum_price'));
    }

    public function toDetail(Request $request,$id)
    {
        $member = $request->session()->get('member','');
        $index_category = Category::where('parent_id',0)->get();
        $order = Order::with(['order_detail'=>function($q){
            $q->leftJoin('product','order_detail.product_id','=','product.id');
        }])->find($id);

        return view('order_detail',compact('member','index_category','order'));
    }

    public function receipt(Request $request)
    {
        $order_id = $request->get('id');

        $order = Order::find($order_id);

        $order->status = 4;
        $res = $order->save();

        $m3_request = new M3Request();
        if($res){
            $m3_request->code = 0;
            $m3_request->message = '确认收货成功！';
        }else{
            $m3_request->code = 1;
            $m3_request->message = '确认收货失败！';
        }

        return $m3_request->toJson();
    }

    public function orderReview(Request $request,$id)
    {
        $member = $request->session()->get('member','');
        $index_category = Category::where('parent_id',0)->get();
        if($id==0){
            $order_detail = OrderDetail::whereNull('reviewed_at')->leftJoin('product','order_detail.product_id','=','product.id')->get();

        }else{

            $order_detail = OrderDetail::where('order_id',$id)
                ->whereNull('reviewed_at')
                ->leftJoin('product','order_detail.product_id','=','product.id')
                ->get(['order_detail.id','product.preview','product_name','product.price']);
        }
        return view('review',compact('member','index_category','order_detail'));
    }
}
