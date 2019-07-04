<?php

namespace App\Http\Controllers\Service;

use App\Entity\Cart;
use App\Entity\Member;
use App\Entity\Order;
use App\Entity\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayController extends Controller
{
    public function alipay(Request $request)
    {

        require_once (app_path() .'/Tool/alipay/config.php');
        require_once (app_path() .'/Tool/alipay/pagepay/service/AlipayTradeService.php');
        require_once (app_path() .'/Tool/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');

        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = trim($_POST['WIDout_trade_no']);

        //订单名称，必填
        $subject = trim($_POST['WIDsubject']);

        //付款金额，必填
        $total_amount = trim($_POST['WIDtotal_amount']);

        //商品描述，可空
        $body = trim($_POST['WIDbody']);

        //生成订单

        $order_product  = $request->session()->get('buyone_product','');

        $member = $request->session()->get('member','');
        $order = new Order();

        if($order_product){
            $request->session()->forget('buyone_product');
            $order->no = $out_trade_no;
            $order->member_id = $member->id;
            $order->member_name = $member->nickname;
            $order->phone = $member->phone;
            $order->address = '暂无';
            $order->total_amount = $order_product->sumprice;
            $order->save();

            $order_id = $order->getQueueableId();

            $order_detail = new OrderDetail();

            $order_detail->order_id = $order_id;
            $order_detail->product_id = $order_product->id;
            $order_detail->product_name = $order_product->name;
            $order_detail->number = $order_product->num;
            $order_detail->price = $order_product->price;
            $order_detail->total = $order_product->sumprice;
            $order_detail->save();

        }else{
            $order_products = $request->session()->get('cart_products','');
            $request->session()->forget('cart_products');
            $order->no = $out_trade_no;
            $order->member_id = $member->id;
            $order->member_name = $member->nickname;
            $order->phone = $member->phone;
            $order->address = '暂无';

            $order->save();

            $order_id = $order->getQueueableId();

            $sumprice1 = 0;
            foreach ($order_products as $v){
                $order_detail = new OrderDetail();

                $order_detail->order_id = $order_id;
                $order_detail->product_id = $v['id'];
                $order_detail->product_name = $v['name'];
                $order_detail->number = $v['num'];
                $order_detail->price = $v['price'];
                $order_detail->total = $v['sumprice'];
                $sumprice1 += (int)$v['sumprice'];
                $order_detail->save();
                Cart::where('member_id',$member->id)->where('product_id',$v['id'])->delete();
            }

            $order->total_amount = $sumprice1;
            $order->save();

        }

        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);

        $aop = new \AlipayTradeService($config);

        /**
         * pagePay 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);

        //输出表单
        var_dump($response);
    }


    public function alipay_again()
    {

        require_once (app_path() .'/Tool/alipay/config.php');
        require_once (app_path() .'/Tool/alipay/pagepay/service/AlipayTradeService.php');
        require_once (app_path() .'/Tool/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');

        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = trim($_POST['WIDout_trade_no']);

        //订单名称，必填
        $subject = trim($_POST['WIDsubject']);

        //付款金额，必填
        $total_amount = trim($_POST['WIDtotal_amount']);

        //商品描述，可空
        $body = trim($_POST['WIDbody']);



        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);

        $aop = new \AlipayTradeService($config);

        /**
         * pagePay 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */
        $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);

        //输出表单
        var_dump($response);
    }

    public function notify(Request $request)
    {
//        return 1;
        require_once (app_path() .'/Tool/alipay/config.php');
        require_once (app_path() .'/Tool/alipay/pagepay/service/AlipayTradeService.php');

        $arr=$_POST;
        $alipaySevice = new \AlipayTradeService($config);
        $alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($arr);
        $request->session()->set('paystatus',1);
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            //商户订单号

            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号

            $trade_no = $_POST['trade_no'];

            //交易状态
            $trade_status = $_POST['trade_status'];

            if($_POST['trade_status'] == 'TRADE_FINISHED') {


            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {


            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success";	//请不要修改或删除
        }else {
            //验证失败
            echo "fail";

        }
    }

    public function call_back(Request $request)
    {

        require_once (app_path() .'/Tool/alipay/config.php');
        require_once (app_path() .'/Tool/alipay/pagepay/service/AlipayTradeService.php');


        $arr=$_GET;
        $alipaySevice = new \AlipayTradeService($config);
        $result = $alipaySevice->check($arr);

        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            //商户订单号
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);


            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);

            $order = Order::where('no', $out_trade_no)->first();
            $order->paystatus = 1;
            $order->status = 2;
            $order->payment_no = $trade_no;
            $order->save();

            $member = Member::find($request->session()->get('member')->id);
            $member->integral = ($order->total_amount)/10;
            $member->save();

            $member = Member::find($request->session()->get('member')->id);
            $request->session()->set('member',$member);

            return view('alipay.call_back_url',compact('trade_no'));

        }
        else {
            //验证失败
            return "验证失败!";
        }
    }
}
