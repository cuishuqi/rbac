<?php

namespace App\Model\Admin;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminUser extends Authenticatable
{
    use Notifiable;
    protected $table='admin_users';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany('App\Model\Admin\Role','admin_role_user','user_id','role_id');
    }
    public function hasRoles($roles){

        if (is_string($roles)){
            return $this->roles->contain($roles);
        }
        return !!$roles->intersect($this->roles)->count();
    }

}
