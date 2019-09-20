<?php

namespace App\Http\Controllers\Admin;

use App\Models\JsonService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = DB::table('site')->get();
        return view('admin.site.index')->with('config', $config);
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

    public function siteimage()
    {
        return view('admin.site.image');
    }

    public function getsiteimageList(Request $request)
    {
        $site_image = DB::table('site_image')->paginate($request->get('limit',30))->toArray();

        $data = [
            'code' => 0,
            'msg' => '请求中。。。',
            'count' => $site_image['total'],
            'data' => $site_image['data']
        ];

        return response()->json($data);
    }

    public function siteimagecreate()
    {
        return view('admin.site.imageadd');
    }

    public function siteimagestore(Request $request)
    {
        $data = $request->get('data');
        unset($data['file']);
        date_default_timezone_set('PRC');
        $data['created_at'] = date('Y-m-d H:i:s',time());
        $data['updated_at'] = date('Y-m-d H:i:s',time());
        $res = DB::table('site_image')->insert($data);

        $m3_request = new JsonService();
        if($res){
            $m3_request->code = 0 ;
            $m3_request->message = '添加成功！';
        }else{
            $m3_request->code = 1 ;
            $m3_request->message = '添加失败！';
        }

        return $m3_request->toJson();
    }

    public function siteimagedestroy(Request $request)
    {
        $id = $request->get('ids');
        $res = DB::table('site_image')->find($id);
        unlink(public_path($res->image_path));

        $res = DB::table('site_image')->delete($id);

        $m3_request = new JsonService();
        if($res){
            $m3_request->code = 0 ;
            $m3_request->message = '删除成功！';
        }else{
            $m3_request->code = 1 ;
            $m3_request->message = '删除失败！';
        }

        return $m3_request->toJson();
    }
}
