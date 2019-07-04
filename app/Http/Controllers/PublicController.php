<?php

namespace App\Http\Controllers;

use App\Entity\PdtImages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PublicController extends Controller
{
    public function uploadImg(Request $request)
    {

        //上传文件最大大小,单位M
        $maxSize = 10;
        //支持的上传图片类型
        $allowed_extensions = ["png", "jpg", "gif"];
        $fileCharater = $request->file('file');
        $data = ['code'=>200, 'msg'=>'上传失败', 'data'=>''];
        if ($request->isMethod('POST')) {

            if ($fileCharater->isValid()) { //括号里面的是必须加的哦
                //如果括号里面的不加上的话，下面的方法也无法调用的

                //获取文件的扩展名
                $ext = $fileCharater->getClientOriginalExtension();
                if (!in_array(strtolower($ext),$allowed_extensions)){
                    $data['msg'] = "请上传".implode(",",$allowed_extensions)."格式的图片";
                    return response()->json($data);
                }
                //检测图片大小
                if ($fileCharater->getClientSize() > $maxSize*1024*1024){
                    $data['msg'] = "图片大小限制".$maxSize."M";
                    return response()->json($data);
                }
                //获取文件的绝对路径
                $path = $fileCharater->getRealPath();

                //定义文件名
                $filename = date('Y-m-d')."_".time()."_".uniqid().".".$ext;

                //存储文件。disk里面的public。总的来说，就是调用disk模块里的public配置
                $disk = Storage::disk('public');
                $res = $disk->put($filename, file_get_contents($path));
                if($res){
                    $data = [
                        'code'    => 0,
                        'msg'     => '上传成功',
                        'imageId' => mt_rand(),
                        'url'     => '/images/'.$filename,
                        'name'    => $filename
                    ];
                }else{
                    $data['data'] = $fileCharater->getErrorMessage();
                }

            }

            return response()->json($data);
        }

    }

    public function deleteImg(Request $request)
    {
        $name = $request->get('image_name');
        if(is_array($name)){
                foreach ($name as $v){
                    unlink(public_path('images/').$v);
                }
            }else{
                unlink (public_path('images/').$name);
        }


        return response()->json(['code'=>0,'msg'=>'删除成功']);
    }

    public function deleteImg_database(Request $request,$id)
    {

        $path = $request->get('path');

        if($path){
            if(is_array($path)){
                foreach ($path as $v){
                    unlink(base_path().'/public'.$v);
                }
            }else{
                unlink (base_path('/public'.$path));
                PdtImages::destroy($id);
            }
        }

        return response()->json(['code'=>0,'msg'=>'删除成功']);
    }
}
