<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Models\JsonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.category_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::get()->toArray();
        $categorys = $this->tree($data);
        return view('admin.category.category_add',compact('categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->get('data');

        $category = new Category();

        $category->parent_id = $data['parent_id'];
        $category->name = $data['name'];
        $category->preview = $data['preview'];
        $res = $category->save();
        if($data['parent_id']!=0){
            $path = Category::find($data['parent_id']);
            $category->path = $path->path.','.$category->id;
        }else{
            $category->path = $category->id;
        }
        $category->save();
        $m3_request = new JsonService();
        if($res){
            $m3_request->code = 0;
            $m3_request->message = '添加分类成功！';

        }else{
            $m3_request->code = 1;
            $m3_request->message = '添加分类失败！';
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
        $category_data = Category::find($id);
        $data = Category::get()->toArray();
        $categorys = $this->tree($data);
        return view('admin.category.category_edit',compact('category_data','categorys'));
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
        $category = Category::find($id);
        $data = $request->get('data');
//        dd($data);
        $category->name = $data['name'];
        $category->parent_id = $data['parent_id'];
        $category->preview = $data['preview'];

        $res = $category->save();

        $m3_request = new JsonService();
        if($res){
            $m3_request->code = 0;
            $m3_request->message = '修改分类成功！';

        }else{
            $m3_request->code = 1;
            $m3_request->message = '修改分类失败！';
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
        $res = Category::where('parent_id', $id)->get()->toArray();

        $m3_request = new JsonService();
        if(!empty($res)){
            $m3_request->code = 3;
            $m3_request->message = '删除失败，此分类下面有子分类';
            return $m3_request->toJson();
        }

        $res = Category::destroy($id);

        if($res){
            $m3_request->code = 0;
            $m3_request->message = '删除成功';
        }else{
            $m3_request->code = 1;
            $m3_request->message = '删除失败';
        }

        return $m3_request->toJson();
    }

    public function getCategorylist(Request $request)
    {
        $categorys = Category::get()->toArray();

        $result = [
            'code'  => 0,
            'msg'   => 'ok',
            'data'  => $categorys,
            'count' => 2,
        ];

        return  response()->json($result);
    }
}
