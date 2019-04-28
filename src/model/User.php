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

    public $statusText = [
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
        return $this->statusText[$data['status']];
    }

    public static function init()
    {
        self::event('before_insert', function ($user) {
            self::existUser($user);
        });
        self::event('before_update', function ($user) {
            self::existUser($user, $user['id']);
        });
    }

    public static function existUser($user, $user_id = '')
    {
        if (self::exist('name', $user['name'], $user_id)) {
            exception("用户已存在");
        }
        if (self::exist('nickname', $user['nickname'], $user_id)) {
            exception("昵称已存在");
        }
        if (self::exist('mobile', $user['mobile'], $user_id)) {
            exception("手机号已存在");
        }
        if (self::exist('email', $user['email'], $user_id)) {
            exception("邮箱已存在");
        }
    }

    public static function exist($field, $value, $user_id = '')
    {
        $where = [];
        if ($user_id) {
            $where[] = ['id', 'neq', $user_id];
        }
        $model = self::where($where);
        if ($value && $model->where($field, $value)->find()) {
            return true;
        }
        return false;
    }
}
