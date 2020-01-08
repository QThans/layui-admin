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

class Admins extends Model
{
    protected $hidden = ['password', 'salt'];

    protected $name = 'admins';

    public $statusText
    = [
        0 => '正常',
        1 => '禁用',
    ];

    public function roles()
    {
        return $this->belongsToMany(
            'AuthRole',
            'thans\layuiAdmin\model\AuthRoleAdmins',
            'role_id',
            'admins_id'
        );
    }

    public function hidden(array $array = [], $override = false)
    {
        parent::hidden(array_merge($this->hidden, $array), $override);

        return $this;
    }

    public function getLastLoginTimeAttr($value)
    {
        return $value ? date('Y-m-d H:i:s', $value) : '未登录过';
    }

    public function getStatusTextAttr($value, $data)
    {
        return $this->statusText[$data['status']];
    }

    public static function onBeforeInsert(Model $model)
    {
        self::existAdmins($model);
    }

    public static function onBeforeWrite(Model $model)
    {
        $changed = $model->getChangedData();
        if (isset($changed['password']) && $changed['password']) {
            $salt           = random_str(20);
            $model->password = encrypt_password(
                $changed['password'],
                $salt
            );
            $model->salt     = $salt;
        }else{
            unset($model['password']);
        }
        self::existAdmins($model);
    }

    public static function existAdmins($admins)
    {
        if (self::exist('name', $admins['name'], $admins['id'])) {
            abort(404, '管理员用户名已存在');
        }
        if (self::exist('nickname', $admins['nickname'],  $admins['id'])) {
            abort(404, '昵称已存在');
        }
        if (self::exist('mobile', $admins['mobile'],  $admins['id'])) {
            abort(404, '手机号已存在');
        }
        if (self::exist('email', $admins['email'],  $admins['id'])) {
            abort(404, '邮箱已存在');
        }
    }

    public static function exist($field, $value, $admins_id = '')
    {
        $where = [];
        if ($admins_id) {
            $where[] = ['id', '<>', $admins_id];
        }
        $model = self::where($where);
        if ($value && $model->where($field, $value)->find()) {
            return true;
        }

        return false;
    }
}
