<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\PdtImages;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use App\Models\JsonService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.product.product_list');
    }

    public function getProductList(Request $request)
    {
        $model = Product::query();

        if ($request->get('name')) {
            $model = $model->where('name', 'like', '%' . $request->get('name') . '%');
        }

        $res = $model->paginate($request->get('limit', 30))->toArray();

        $product__data_list = [
            'code'  => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data'],
        ];
        return response()->json($product__data_list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categorys = Category::get()->toArray();
        $categorys = $this->tree($categorys);

        return view('admin.product.product_add', compact('categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $data = $request->only(['category_id', 'name', 'price', 'preview', 'on_sale', 'rating', 'sold_count', 'description']);
        $res = Product::create($data);

        $m3_request = new JsonService();
        if ($res) {

            $image_data = $request->get('image_src');
            if ($image_data) {
                $data = [
                    'image_path' => '',
                    'product_id' => $res->id,
                ];
                for ($i = 0; $i <= count($image_data) - 1; $i++) {
                    $data['image_path'] = $image_data[$i];
                    PdtImages::create($data);
                }
            }
            $m3_request->code = 0;
            $m3_request->message = '添加商品成功';


        } else {
            $m3_request->code = 1;
            $m3_request->message = '添加商品失败';

        }

        return $m3_request->toJson();

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $product_data = Product::find($id);
        $image_data = PdtImages::where('product_id', $id)->get()->toArray();
        $categorys = Category::get()->toArray();
        $categorys = $this->tree($categorys);
        return view('admin.product.product_edit', compact('product_data', 'image_data', 'categorys'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function update(Request $request, $id)
    {

        $data = $request->only(['category_id', 'name', 'price', 'preview', 'on_sale', 'rating', 'stock', 'sold_count', 'description']);

        $product = Product::find($id);

        $res = $product->update($data);

        $m3_request = new JsonService();
        if ($res) {

            $image_data = $request->get('image_src');
            PdtImages::where('product_id', $id)->delete();
            if ($image_data) {
                $data = [
                    'image_path' => '',
                    'product_id' => $id,
                ];
                for ($i = 0; $i <= count($image_data) - 1; $i++) {
                    $data['image_path'] = $image_data[$i];
                    PdtImages::create($data);
                }
            }
            $m3_request->code = 0;
            $m3_request->message = '修改商品成功';


        } else {
            $m3_request->code = 1;
            $m3_request->message = '修改商品失败';

        }

        return $m3_request->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $images = PdtImages::where('product_id', $id)->get();

        foreach ($images as $v) {
            unlink(public_path($v->image_path));
        }

        $res = Product::destroy($id);
        if ($res) {
            return response()->json(['code' => 0, 'msg' => '删除成功']);
        }

    }

    public function msAdd(Request $request)
    {
        $data = $request->get('data');

        foreach ($data as $v) {
            Redis::setex('goods:' . $v['product_id'], 60 * 60, $v['stock']);
        }

        JsonService::responseOK();
    }
}
