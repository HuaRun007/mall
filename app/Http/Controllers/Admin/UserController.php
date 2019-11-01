<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2019/4/1
 * Time: 12:08
 */

namespace App\Http\Controllers\Admin;


use App\Entity\Role;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Models\JsonService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.user_list');
    }

    public function getUserList(Request $request)
    {
        $model = User::query();

        if($request->get('created_at')){
            $model = $model->where('created_at',$request->get('created_at'));
        }

        if($request->get('username')){
            $model = $model->where('username','like','%'.$request->get('username').'%');
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

    public function changeUserStatus(Request $request)
    {
        $user_id = $request->input('id');
        $change_value = $request->input('change_value');

        $user = User::find($user_id);
        $user->status = $change_value;
        $result = $user->save();
        $m3 = new JsonService();
        if($result){
            $m3->code = 0;
            $m3->message = '更新成功！';
        }else{
            $m3->code = 3;
            $m3->message = '更新失败！';
        }

        return $m3->toJson();

    }

    public function show_edit(Request $request)
    {
        $id = $request->input('id');
        $user_data = User::find($id);
        return view('admin.user.user_edit')->with('user_data', $user_data);
    }

    public function update(Request $request){


        $data = $request->except('password');
        $user = User::findOrFail($request->get('user_id'));

        if ($request->get('password')){
            $data['password'] = bcrypt($request->get('password'));
        }

        $m3_request = new JsonService();
        if($user->update($data)){
            $m3_request->code = 0;
            $m3_request->message = '更新用户成功';
        }else{
            $m3_request->code = 3;
            $m3_request->message = '系统错误';
        }

        return $m3_request->toJson();

    }

    public function show_userrole($id)
    {
        $user = User::find($id);
        $roles = Role::get();

        foreach ($roles as $role){
            $role->own = $user->hasRole($role->name) ? 'checkde' : '';
        }

        return view('admin.user.user_role')->with('user',$user)->with('roles', $roles);
    }

    /**
     * 给用户分配权限
     */
    public function role(Request $request,$id)
    {

        $user = User::find($id);

        $roles = $request->get('roles');

        $m3_request = new JsonService();
        if(empty($roles)){
            $user->detachRoles($roles);
        }else{
            $user->detachRoles($roles);
            $user->attachRoles($roles);
        }

        $m3_request->code = 0;
        $m3_request->message = '分配角色成功！';

        return $m3_request->toJson();

    }

    public function create()
    {

        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $data = $request->get('data');
        $data['password'] = bcrypt($data['password']);
        $user = User::where('username',$data['username'])->first();

        $m3_request = new JsonService();

        if($user){
            $m3_request->code = 1;
            $m3_request->msg  = '该用户名已存在！';

            return $m3_request->toJson();
        }

        $user = User::where('phone',$data['phone'])->first();

        if($user){
            $m3_request->code = 2;
            $m3_request->msg  = '该手机号已注册！';

            return $m3_request->toJson();
        }

        $user = User::where('email',$data['email'])->first();

        if($user){
            $m3_request->code = 3;
            $m3_request->msg  = '该邮箱号已注册！';

            return $m3_request->toJson();
        }

        $res = User::create($data);

        if($res){
            $m3_request->code = 0;
            $m3_request->msg  = '添加后台管理员成功！';

            return $m3_request->toJson();
        }

    }

    public function del(Request $request)
    {
        $data = $request->get('data');

        $m3_request = new JsonService();

        if(is_array($data)){
            //批量删除
            foreach ($data as $v){
                $user = User::find($v['id']);
                $user->delete();
                $res = $user->trashed();
                if(!$res){
                    $m3_request->code = 1;
                    $m3_request->message = '删除失败!';
                    return $m3_request->toJson();
                }
            }
            $m3_request->code = 0;
            $m3_request->message = '删除成功!';
        }else{
            $user = User::find($data);
            $user->delete();
            $res = $user->trashed();
            if($res){
                $m3_request->code = 0;
                $m3_request->message = '删除成功!';
            }else{
                $m3_request->code = 1;
                $m3_request->message = '删除失败!';
            }
        }

        return $m3_request->toJson();

    }

    public function permission(Request $request)
    {
        $user_id = $request->get('id');

        $user = User::find($user_id);

        $permissions = $this->tree();

        foreach ($permissions as $key =>$vlue){
            $permissions[$key]['own'] = $user->hasPermission($vlue['name']) ? 'checked' : false;

            if(isset($vlue['_child'])){
                foreach ($vlue['_child'] as $k2 => $v2){
                    $permissions[$key]['_child'][$k2]['own'] = $user->hasPermission($v2['name']) ? 'checked' : false;
                    if(isset($v2['_child'])){
                        foreach ($v2['_child'] as $k3 => $v3){
                            $permissions[$key]['_child'][$k2]['_child'][$k3]['own'] = $user->hasPermission($v3['name']) ? 'checked' : false;
                        }
                    }
                }
            }
        }

        return view('admin.user.user_permission',compact('user','permissions'));
    }

}