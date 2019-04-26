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
    protected $hidden = ['password', 'salt'];

    protected $name = 'user';

    public $status = [
        0 => '正常',
        1 => '禁用'
    ];

    public function meta()
    {
        return $this->hasMany('user_meta')->whereNull('delete_time');
    }

    public function roles()
    {
        return $this->belongsToMany('AuthRole', 'thans\layuiAdmin\model\AuthRoleUser', 'role_id', 'user_id');
    }

    public function hidden($array = [], $override = false)
    {
        parent::hidden(array_merge($this->hidden, $array), $override);
        return $this;
    }

    public function getLastLoginTimeAttr($value)
    {
        return date('Y-m-d H:i:s', $value);
    }

    public function getStatusTextAttr($value, $data)
    {
        return $this->status[$data['status']];
    }
}
