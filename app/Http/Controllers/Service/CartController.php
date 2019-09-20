<?php

namespace App\Http\Controllers\Service;

use App\Entity\Cart;
use App\Models\JsonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public  function addCart(Request $request, $product_id)
    {
        $member = $request->session()->get('member','');

        if($member){
            $member_id = $member->id;
            $cart = Cart::where('member_id',$member_id)->where('product_id', $product_id)->first();
            $count = (int)$request->get('num');
            if($cart){
                $num = $cart->num+$count;
                Cart::where('member_id',$member_id)->where('product_id', $product_id)->update(['num'=>$num]);
            }else{
                $cart = new Cart();
                $cart->member_id = $member_id;
                $cart->product_id = $product_id;
                $cart->num = $count;
                $cart->save();

            }

        }else{
            $cart = $request->cookie( 'cart',[]);

            $count = (int)$request->get('num');

            if(!array_key_exists($product_id,$cart)){

                $cart[$product_id] = $count;
            }else{

                $cart[$product_id] += $count;
            }
        }

        $m3_request = new JsonService();
        $m3_request->code = 0;
        $m3_request->message = '添加成功';

        return response($m3_request->toJson())->withCookie('cart', $cart);

    }

    public function deleteCart(Request $request)
    {
        $m3_request = new JsonService();

        $product_ids = $request->input('id', '');



    }


    public function getCartnum(Request $request)
    {
        $member = $request->session()->get('member');

        if($member != null){
            $count = Cart::where('member_id', $member->id)->sum('num');
            $count = $count == null ? 0 : $count;

        }else{
            $cart = $request->cookie('cart',[]);
            $count = empty($cart) ? 0 :array_sum($cart);

        }

        return response()->json(['code'=>0,'num'=>$count]);
    }

    public function addCartSession(Request $request)
    {
        $request->session()->set('cart_products',$request->get('products'));


        return response()->json(['code'=>0,'message'=>'成功']);
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        $member = $request->session()->get('member');
        $m3_request = new JsonService();

        if(!$member){
         $cart = $request->cookie('cart');
         unset($cart[$id]);
         $m3_request->code = 0;
         $m3_request->message = '删除成功！';
         return response($m3_request->toJson())->withCookie('cart', $cart);
        }

        Cart::where('product_id',$id)->where('member_id', $member->id)->delete();


        $m3_request->code = 0;
        $m3_request->message = '删除成功！';

        return $m3_request->toJson();
    }
}
