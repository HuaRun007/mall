<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\PdtImages;
use App\Entity\Product;
use App\Models\M3Request;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.product_list');
    }

    public function getProductList(Request $request)
    {
        $model = Product::query();

        if($request->get('name')){
            $model = $model->where('name','like', '%'.$request->get('name').'%');
        }

        $res = $model->paginate($request->get('limit', 30))->toArray();

        $product__data_list = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($product__data_list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorys = Category::get()->toArray();
        $categorys = $this->tree($categorys);

        return view('admin.product.product_add',compact('categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->only([ 'category_id', 'name', 'price', 'preview', 'on_sale', 'rating', 'sold_count', 'description']);
        $res = Product::create($data);
//        dd($data['name']);
        $m3_request = new M3Request();
        if($res){

            $image_data = $request->get('image_src');
            if($image_data){
                $data = [
                    'image_path' => '',
                    'product_id' => $res->id,
                ];
                for ($i=0;$i<=count($image_data)-1;$i++){
                    $data['image_path'] = $image_data[$i];
                    PdtImages::create($data);
                }
            }
            $m3_request->code = 0;
            $m3_request->message = '添加商品成功';


        }else{
            $m3_request->code = 1;
            $m3_request->message = '添加商品失败';

        }

        return $m3_request->toJson();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product_data = Product::find($id);
        $image_data = PdtImages::where('product_id', $id)->get()->toArray();
        $categorys = Category::get()->toArray();
        $categorys = $this->tree($categorys);
        return view('admin.product.product_edit',compact('product_data','image_data','categorys'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $request->only([ 'category_id', 'name', 'price', 'preview', 'on_sale', 'rating', 'sold_count', 'description']);
        $product = Product::find($id);

        $res = $product->update($data);
        $m3_request = new M3Request();
        if($res){

            $image_data = $request->get('image_src');
            PdtImages::where('product_id', $id)->delete();
            if($image_data){
                $data = [
                    'image_path' => '',
                    'product_id' => $id,
                ];
                for ($i=0;$i<=count($image_data)-1;$i++){
                    $data['image_path'] = $image_data[$i];
                    PdtImages::create($data);
                }
            }
            $m3_request->code = 0;
            $m3_request->message = '修改商品成功';


        }else{
            $m3_request->code = 1;
            $m3_request->message = '修改商品失败';

        }

        return $m3_request->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $images = PdtImages::where('product_id',$id)->get();

        foreach ($images as $v){
            unlink(public_path($v->image_path));
        }

        $res = Product::destroy($id);
        if($res){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }

    }
}
