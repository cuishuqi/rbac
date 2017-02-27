<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PremissionCreateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Permission;

class PermissionController extends Controller
{

    protected $fields = [
        'name'        => '',
        'label'       => '',
        'description' => '',
        'icon'        => '',
        'cid'         => 0,
   ];



    public function index($cid = 0)
    {
        $id = (int)$cid;
        $datas['cid'] = $cid;
        $datas['data'] = Permission::where('cid',$id)->get();
        $datas['count'] = Permission::where('cid',$id)->count();
        return view('admin.permission.index')
            ->with('datas',$datas);
    }

    public function create($cid = 0)
    {
        $cid =(int)$cid;
        $data['cid'] = $cid;

        return view('admin.permission.add')->with('data',$data);
    }

    public function store(PremissionCreateRequest $request)
    {
        $permission = new Permission();
        $data = [];
        $tablefields = array_keys($this->fields);


        foreach($tablefields as $field)
        {
            $permission->$field = $request->has($field)? $request->get($field):$this->fields[$field];
        }
//        dd($request->all() );

//        dd($request->get('icons',$this->fields['icons']));
        $permission->save();
        $data['status'] = 1;
        $data['msg'] = '保存权限成功';
        return response()->json($data);
    }

    public function edit($pid){

        $id = (int)$pid;
        $permission = Permission::find($id);
        $data = Permission::where('cid',0)->get();
        return view('admin.permission.edit')
            ->with('data',$data)
            ->with('permission',$permission);
    }

    public function update(){


    }

    public function delete($id)
    {
        $pid = (int)$id;
        $data = [];
        $permission = Permission::find($pid);
        if(!$permission)
        {
            $date['msg'] = '找不到指定的权限';
            $data['status'] = 0;
            return response()->json($data);
        }
        $subPermission = Permission::where('cid',$pid)->first();
        if($subPermission)
        {
            $data['msg'] = '请先删除子权限';
            $data['status'] = 1;
            return response()->json($data);
        }
        $permission ->delete();
        $data['msg']= '删除权限成功';
        $data['status'] = 1;
        return response()->json($data);
    }



}
