<?php

namespace App\Http\Controllers\Service;

use App\Entity\Product;
use App\Models\M3Request;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function search(Request $request)
    {
        $product = $request->get('product','');
        $products = Product::where('name', 'like', '%'.$product.'%')->get(['name','id'])->toArray();

        $m3_request = new M3Request();
        if($products){
            $m3_request->code = 0;
            $m3_request->message = $products;
        }else{
            $m3_request->code = 1;
            $m3_request->message = '无数据';
        }


        return $m3_request->toJson();
    }
}
