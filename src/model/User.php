<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin\model;

use think\Model;

class User extends Model
{
    protected $name = 'user';

    public function meta()
    {
        return $this->hasMany('user_meta')->whereNull('delete_time');
    }

    public function roles()
    {
        return $this->belongsToMany('AuthRole', 'thans\layuiAdmin\model\AuthRoleUser', 'role_id', 'user_id');
    }

}
