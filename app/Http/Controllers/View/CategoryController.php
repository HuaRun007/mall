<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2019/5/5
 * Time: 13:18
 */

namespace App\Http\Controllers\View;

use App\Entity\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function index(Request $request,$id)
    {
        $member = $request->session()->get('member','');
        $index_category = Category::where('parent_id',0)->get();

        $cmodel = DB::select("select id from category where path like '%$id,%'");
        $categorys = [];
        foreach ($cmodel as $item){
            $categorys[] = $item->id;
        }
        $products = Category::whereHas('product',function ($q){})->with(['product'=> function ($q) {
            $q->where('product.on_sale', '1');
        }])->whereIn('id',$categorys)->get();
        $category = Category::find($id);
        return view('category',compact('member','index_category','products','category'));
    }
}