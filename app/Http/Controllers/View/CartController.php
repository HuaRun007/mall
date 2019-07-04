<?php

namespace App\Http\Controllers\View;

use App\Entity\Cart;
use App\Entity\Category;
use App\Entity\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
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
        if($member){
            $sql = 'SELECT c.num,p.id,p.`name`,p.price,p.preview,p.price*c.num as sum_price FROM cart as c LEFT JOIN product as p ON c.product_id=p.id WHERE c.member_id = '.$member->id;
            $carts = DB::select($sql);
        }else{
            $cart = $request->cookie('cart',[]);
            $carts = [];
            foreach ($cart as $k=> $item){
                $temp = Product::find($k);
                $temp->sum_price = ($temp->price)*$item;
                $temp->num = $item;
                $carts[] = $temp;
            }
        }

//        dd($carts);
        return view('cart',compact('member','index_category','carts'));
    }

}
