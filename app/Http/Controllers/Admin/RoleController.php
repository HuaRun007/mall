<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Permission;
use App\Entity\Role;
use App\Models\JsonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.role.role_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.role_add');
    }

    public function getRoleList(Request $request)
    {
        $role = Role::query();
        $res = $role->paginate($request->get('limit',30))->toArray();

        $data = [
            'code'  => 0,
            'msg'   => '正在请求...',
            'count' => $res['total'],
            'data'  => $res['data'],
        ];
        return response()->json($data);
    }

    public function edit(Request $request){
        $id = $request->get('id');
        $role = Role::find($id);
        return view('admin.role.role_edit')->with('role_data', $role);
    }

    public function update(Request $request)
    {

        $data = $request->except('role_id');

        $role = Role::findOrFail($request->get('role_id'));

        $role->name = $data['name'];
        $role->display_name = $data['display_name'];
        $role->description = $data['description'];
        $m3_request = new JsonService();
        if($role->save()){
            $m3_request->code = 0;
            $m3_request->message = '更新角色成功';
        }else{
            $m3_request->code = 3;
            $m3_request->message = '系统错误';
        }

        return $m3_request->toJson();


    }

    /**
     * 展示权限
     */
    public function permission(Request $request,$id)
    {

        $role = Role::find($id);
        $permissions = $this->tree();

        foreach ($permissions as $key1 => $item1){
            $permissions[$key1]['own'] = $role->hasPermission($item1['name']) ? 'checked' : false ;

            if (isset($item1['_child'])){
                foreach ($item1['_child'] as $key2 => $item2){
                    $permissions[$key1]['_child'][$key2]['own'] = $role->hasPermission($item2['name']) ? 'checked' : false ;
                    if (isset($item2['_child'])){
                        foreach ($item2['_child'] as $key3 => $item3){
                            $permissions[$key1]['_child'][$key2]['_child'][$key3]['own'] = $role->hasPermission($item3['name']) ? 'checked' : false ;
                        }
                    }
                }
            }

        }

        return view('admin.role.permission',compact('role','permissions'));
    }


    /**
     * 添加角色
     */
    public function store(Request $request)
    {
        $data = $request->get('data');

        $role = new Role();
        $role->name = $data['name'];
        $role->display_name = $data['display_name'];
        $role->description = $data['description'];
        $role = $role->save();

        $m3_request = new JsonService();
        if(!empty($role)){
            $m3_request->code = 0;
            $m3_request->message = '添加角色成功！';
        }else{
            $m3_request->code = 1;
            $m3_request->message = '添加角色失败，请重试！';
        }

        return $m3_request->toJson();

    }

    /**
     * 修改角色权限
     */
    public function permission_update(Request $request,$id)
    {
        $role = Role::find($id);
        $permissions = $request->get('permissions');

        $m3_request = new JsonService();
        if (empty($permissions)){
            DB::table('permission_role')->where('role_id',$id)->delete();
            $m3_request->code = 0;
            $m3_request->message = '更新'.$role->name.'权限成功！';
        }
        // 删除所有权限
        DB::table('permission_role')->where('role_id',$id)->delete();

        $role->attachPermissions($permissions);
        $m3_request->code = 0;
        $m3_request->message = '更新'.$role->name.'权限成功！';
        return $m3_request->toJson();
    }

    public function destroy(Request $request)
    {
       $id = $request->get('ids');
       $res = Role::destroy($id);

       $m3_request = new JsonService();
       if($res){
           $m3_request->code = 0;
           $m3_request->message = '删除角色成功！';
       }else{
           $m3_request->code = 1;
           $m3_request->message = '删除角色失败！';
       }

       return $m3_request->toJson();
    }
}
