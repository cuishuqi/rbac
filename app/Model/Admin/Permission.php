<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    protected $table = 'admin_permissions';

    public function Roles()
    {
        return $this->belongsToMany('App\Model\Admin\Role','admin_permission_role','permission_id','role_id');
    }
}
