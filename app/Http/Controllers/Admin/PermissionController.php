<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Permission;
use App\Models\M3Request;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.permission.permission_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = $this->tree();
        return view('admin.permission.permission_add',compact('permission'));
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

        $permission = new Permission();

        $permission->name = $data['name'];
        $permission->display_name = $data['display_name'];
        $permission->description = $data['description'];
        $permission->parent_id = $data['parent_id'];

        $m3_request = new M3Request();
        if($permission->save()){
            $m3_request->code = 0;
            $m3_request->message = '添加权限成功';
        }else{
            $m3_request->code = 1;
            $m3_request->message = '添加权限失败';
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
        $permission = $this->tree();
        $permission_data = Permission::find($id);
        return view('admin.permission.permission_edit',compact('permission','permission_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->get('data');

        $permission = Permission::find($data['id']);

        $permission->name = $data['name'];
        $permission->display_name = $data['display_name'];
        $permission->description = $data['description'];
        $permission->parent_id = $data['parent_id'];

        $m3_request = new M3Request();
        if($permission->save()){
            $m3_request->code = 0;
            $m3_request->message = '修改权限成功';
        }else{
            $m3_request->code = 1;
            $m3_request->message = '修改权限失败';
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

    public function getPermissionList()
    {
        $permissions = Permission::get()->toArray();

        $result = [
            'code'  => 0,
            'msg'   => 'ok',
            'data'  => $permissions,
            'count' => 2,
        ];

        echo  json_encode($result);
    }
}
