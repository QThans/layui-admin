<?php


namespace thans\layuiAdmin\model;


use think\Model;
use think\model\concern\SoftDelete;

class AuthRole extends Model
{
    use SoftDelete;

    protected $name = 'auth_role';

    public function permissions()
    {
        return $this->belongsToMany('AuthPermission', 'thans\layuiAdmin\model\AuthRolePermission', 'permission_id', 'role_id');
    }
}