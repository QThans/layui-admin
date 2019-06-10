<?php

namespace thans\layuiAdmin\model;

use think\facade\Request;
use think\Model;
use think\model\concern\SoftDelete;

class AuthRole extends Model
{
    use SoftDelete;

    protected $name = 'auth_role';

    public function permissions()
    {
        return $this->belongsToMany(
            'AuthPermission', 'thans\layuiAdmin\model\AuthRolePermission',
            'permission_id', 'role_id'
        );
    }

    public function menus()
    {
        return $this->belongsToMany(
            'Menu', 'thans\layuiAdmin\model\AuthRoleMenu', 'menu_id', 'role_id'
        );
    }

    //中间表，不获取用户
    public function roleUser()
    {
        return $this->hasMany('AuthRoleUser', 'role_id', 'id');
    }

    protected static function init()
    {
        self::event(
            'before_write', function ($role) {
                $role['status'] = Request::param('status', null) == null ? 0 : 1;
            }
        );
    }
}
