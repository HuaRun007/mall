<?php
/**
 * Created by PhpStorm.
 * User: HuaRun
 * Date: 2019/3/19
 * Time: 20:03
 */

namespace App\Http\Controllers\Admin;


use App\Entity\Member;
use App\Http\Controllers\Controller;
use App\Models\M3Request;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function toMember_list()
    {
        return view('admin.member.member_list');
    }

    public function todelMembers_list()
    {
        return view('admin.member.delmember_list');
    }
    public function getMemberList(Request $request)
    {

        $model = Member::query();

        if ($request->get('created_at')){
            $model = $model->where('created_at','>=', $request->get('created_at'));
        }
        if ($request->get('nickname')){
            $model = $model->where('nickname','like','%'.$request->get('nickname').'%');
        }
        $res = $model->orderBy('id','desc')->paginate($request->get('limit',30))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }

    public function changeMemberStatus(Request $request)
    {
        $member_id = $request->input('id');
        $change_value = $request->input('change_value');

        $member = Member::find($member_id);
        $member->status = $change_value;
        $result = $member->save();
        $m3 = new M3Request();
        if($result){
            $m3->code = 0;
            $m3->message = '更新成功！';
        }else{
            $m3->code = 3;
            $m3->message = '更新失败！';
        }

        return $m3->toJson();

    }

    public function member_edit(Request $request)
    {
        $id = $request->input('id');
        $member_data = Member::find($id);
        return view('admin.member.member_edit')->with('member_data', $member_data);
    }

    public function edit(Request $request)
    {
        $input = $request->input('data');
        $member = Member::find($input['member_id']);
        $member->nickname = $input['nickname'];
        $member->phone = $input['phone'];
        $member->email = $input['email'];
        $member->status = $input['status'];
        $member->integral = $input['integral'];

        $result = $member->save();
        $m3 = new M3Request();
        if($result){
            $m3->code = 0;
            $m3->message = '用户信息更新成功！';
        }else{
            $m3->code = 3;
            $m3->message = '用户信息更新失败！';
        }

        return $m3->toJson();

    }

    public function delMember(Request $request)
    {
        $member = Member::find($request->get('ids'));
        $member->delete();

        $m3_request = new M3Request();
        if($member->trashed()){
            $m3_request->code = 0;
            $m3_request->message = '删除成功!';
        }else{
            $m3_request->code = 3;
            $m3_request->message = '删除失败，请重试！';
        }

        return $m3_request->toJson();
    }

    public function getdelMembersList(Request $request)
    {

        $model = Member::onlyTrashed();

        if ($request->get('created_at')){
            $model = $model->where('created_at','>=', $request->get('created_at'));
        }
        if ($request->get('nickname')){
            $model = $model->where('nickname','like','%'.$request->get('nickname').'%');
        }
        $res = $model->orderBy('id','desc')->paginate($request->get('limit',30))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }

    public  function member_restore(Request $request)
    {

        $member = Member::onlyTrashed();
        $result = $member->where('id',$request->get('ids'))->restore();

        $m3_request = new M3Request();
        if($result){
            $m3_request->code = 0;
            $m3_request->message = '恢复成功!';
        }else{
            $m3_request->code = 3;
            $m3_request->message = '恢复失败，请重试！';
        }

        return $m3_request->toJson();
    }

    public function ResetPassword($id)
    {
        $member = Member::find($id);
        $member->password = bcrypt('123456');
        $member->save();

        M3Request::responseOK();
    }
}