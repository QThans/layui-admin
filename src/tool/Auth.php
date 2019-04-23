<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin\tool;

use thans\layuiAdmin\model\User;
use think\facade\Cache;
use think\facade\Request;
use think\facade\Validate;

class Auth
{
    public function login($account, $password)
    {
        $field = Validate::isEmail($account) ? 'email' : Validate::regex($account, '/^1\d{10}$/') ? 'mobile' : 'name';
        $user = User::where($field, $account)->find();
        if (!$user) {
            throw new \think\exception\HttpException(401, '账户不存在');
        }
        if ($user->status !== 0) {
            throw new \think\exception\HttpException(401, '账户被锁定');
        }
        if ($user->password != encrypt_password($password, $user->salt)) {
            throw new \think\exception\HttpException(401, '密码错误');
        }
        $user->last_login_ip = Request::ip();
        $user->last_login_time = time();
        $user->save();
        session('user_id', $user->id);
        session('user_info', $user);
        session('user_meta', $user->meta);
        Cache::rm('user_' . $user->id);
        return $user;
    }

    public function user()
    {
        $user = Cache::get('user_' . session('user_id'));
        if (!$user) {
            $user = User::get(session('user_id'), 'meta');
            foreach ($user->meta as $key => $value) {
                $user->meta[$value['key']] = $value['value'];
            }
            Cache::set('user_' . session('user_id'), $user, 3600);
        }
        return $user;
    }
}
