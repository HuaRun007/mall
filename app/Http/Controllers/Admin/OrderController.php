<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Order;
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
    public function index()
    {
        return view('admin.order.order_list');
    }

    public function getOrderList(Request $request)
    {
        $model = Order::query();

        if($request->get('created_at')){
            $model = $model->where('created_at',$request->get('created_at'));
        }

        if($request->get('paystatus')){
            $model = $model->where('paystatus',$request->get('paystatus'));
        }

        if($request->get('no')){
            $model = $model->where('no','like', '%'.$request->get('no').'%');
        }

        if($request->get('status')){
            $model = $model->where('status',$request->get('status'));
        }

        if($request->get('payment_method')){
            $model = $model->where('payment_method',$request->get('payment_method'));
        }

        $res = $model->paginate($request->get('limit', 30))->toArray();

        $data = [
            'code' => 0,
            'msg'  => '正在请求中...',
            'count' => $res['total'],
            'data' => $res['data']
        ];

        return response()->json($data);
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
    public function show($id)
    {
        $order_data = Order::with('order_detail')->find($id);
        $order_look = 1;
        return view('admin.order.order_edit',compact('order_data','order_look'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order_data = Order::with('order_detail')->find($id);
        $order_look = 0;
        return view('admin.order.order_edit',compact('order_data','order_look'));
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
        $data = $request->only(['address','payment_method','remark','status']);
        $order = Order::find($id);

        $order->address = $data['address'];
        $order->payment_method = $data['payment_method'];
        $order->remark = $data['remark'];
        $order->status = $data['status'];

        $res = $order->save();

        $m3_request = new M3Request();
        if($res){
            $m3_request->code = 0;
            $m3_request->message = '修改成功';
        }else{
            $m3_request->code = 0;
            $m3_request->message = '修改失败';
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
        //
    }



}
