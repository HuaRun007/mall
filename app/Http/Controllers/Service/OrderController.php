<?php

namespace App\Http\Controllers\Service;

use App\Entity\Comment;
use App\Entity\OrderDetail;
use App\Models\M3Request;
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function review(Request $request)
    {

        $detail_id = $request->get('detail_id');
        $detail = OrderDetail::find($detail_id);

        $m3_request = new M3Request();
        if($detail->reviewed_at!=null){
            $m3_request->code=1;
            $m3_request->message = '该商品已经评价过了！';
            return $m3_request->toJson();
        }

        $rating = $request->get('rating');
        $review = $request->get('content');

        $detail->rating = $rating;
        $detail->review = $review;
        date_default_timezone_set('PRC');
        $detail->reviewed_at = date('Y-m-d H:i:s', time());
        $detail->save();

        $comment = new Comment();
        $comment->member_id = $request->session()->get('member')->id;
        $comment->product_id = $detail->product_id;
        $comment->content = $review;
        $comment->save();

        $m3_request->code = 0;
        $m3_request->message = '评论成功！';

        return $m3_request->toJson();
    }
}
