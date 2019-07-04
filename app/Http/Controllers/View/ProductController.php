<?php

namespace App\Http\Controllers\View;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\PdtImages;
use App\Entity\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
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

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {

        $product = Product::find($id);
        $product_img = PdtImages::where('product_id',$id)->get();

        $path = Category::find($product->category_id,['path']);
        $likeList = Product::whereIn('category_id',explode(',',$path->path))->limit(10)->get();
        $member = $request->session()->get('member','');
        $index_category = Category::where('parent_id',0)->get();
        $reviews = Comment::where('product_id',$id)->leftJoin('member','comment.member_id','=','member.id')->get(['comment.*','member.nickname']);
        return view('product_detail',compact('product','product_img','likeList','member','index_category','reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
