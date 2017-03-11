<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'admin_roles';
    protected $fillable = ['name','description'];

    public function Permission(){

        return $this->belongsToMany('App\Model\Admin\Permission','admin_permission_role','role_id','permission_id');
    }

    public function AdminUsers(){

        return $this->belongsToMany('App\Model\Admin\AdminUser','admin_role_user','role_id','user_id');
    }

    public function givePermissionsTo($permissionid){
        $this->Permission()->detach();

        $permissions = Permission::whereIn('id',$permissionid)->get();

        foreach ($permissions as $permission){
            $this ->givePermissionTo($permission);
        }
        return
            true;
    }

    public function givePermissionTo($permission){
        $this->Permission()->save($permission);
    }


}
