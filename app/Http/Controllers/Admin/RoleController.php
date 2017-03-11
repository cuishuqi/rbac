<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RoleCreateRequest;
use App\Model\Admin\AdminUser;
use App\Model\Admin\Permission;
use App\Model\Admin\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    protected $fields = [
        'name' => '',
        'description' => '',
        'permissions' => [],
    ];

    public function store(RoleCreateRequest $request)
    {
        $role = new Role();
        $data = [];
        foreach (array_keys($this->fields) as $field) {
            $role->$field = $request->has($field) ? $request->get($field) : $this->fields[$field];
        }
        unset($role->permissions);
        $role->save();
        if (is_array($request->get('permissions'))) {
            if ($role->givePermissionsTo($request->get('permissions'))) {
                $data['status'] = 1;
                $data['msg'] = '添加角色成功';
            }
        }
        return response()->json($data);

    }

    public function create()
    {
        $permission = Permission::all();
        $data = $this->getTree($permission);
        return view('admin/role/add')->with('data', $data);
    }

    public function index()
    {
        /*SELECT a.*,GROUP_CONCAT(c.`username`) AS users FROM telecom_admin_roles AS a
LEFT JOIN telecom_admin_role_user b ON a.`id`=b.`role_id`
LEFT JOIN telecom_admin_users c ON c.`id` =  b.`user_id`
GROUP BY a.`id`*/
    ;
        $roles = DB::table('admin_roles as a')
            ->leftjoin('admin_role_user as b','a.id','=' ,'b.role_id')
            ->leftjoin('admin_users as c','c.id','=','b.user_id')
            ->groupBy('a.id')
            ->selectRaw('telecom_a.*,GROUP_CONCAT(telecom_c.username) as user')
            ->get();
        return view('admin/role/index')->with('roles',$roles);
    }

    public function update()
    {

    }

    public function edit()
    {
        return view('admin.role.edit');
    }

    public function delete($rid)
    {
        $data = [];
        $role = Role::find($rid);
        if ($role == null) {
            $data['status'] = 0;
            $data['msg'] = '你要删除的角色不存';
            return response()->json($data);
        }

    }

    private function getTree($data)
    {
        static $arr = [];
        foreach ($data as $key => $value) {

            if ($value->cid == 0) {
                $arr[$key] = $value->toArray();
                foreach ($data as $k => $v) {
                    if ($v->cid == $value->id) {
                        $arr [$key]['son'][] = $v->toArray();
                    }
                }
            }

        }
        return $arr;
    }


}
