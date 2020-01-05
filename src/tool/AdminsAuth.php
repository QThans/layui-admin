<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin\tool;

use thans\layuiAdmin\model\Menu;
use thans\layuiAdmin\model\Admins;
use think\facade\Cache;
use think\facade\Request;
use think\facade\Validate;

class AdminsAuth
{
    public function login($account, $password)
    {
        $field  = Validate::isEmail($account) ? 'email'
            : (Validate::regex($account, '/^1\d{10}$/') ? 'mobile' : 'name');
        $admins = Admins::where($field, $account)->find();
        if (! $admins) {
            throw new \think\exception\HttpException(401, '账户不存在');
        }
        if ($admins->status !== 0) {
            throw new \think\exception\HttpException(401, '账户被锁定');
        }
        if ($admins->password != encrypt_password($password, $admins->salt)) {
            throw new \think\exception\HttpException(401, '密码错误');
        }
        $admins->last_login_ip   = Request::ip();
        $admins->last_login_time = time();
        $admins->save();

        return $admins;
    }

    public function info()
    {
        $info = Cache::get('admins_'.session('admins_id'));
        if (! $info) {
            $info = Admins::find(session('admins_id'));
            Cache::set('admins_'.session('admins_id'), $info, 3600);
        }

        return $info;
    }

    public function clearCache()
    {
        return Cache::delete('admins_'.session('admins_id'));
    }

    public function id()
    {
        return session('admins_id');
    }

    public function menu()
    {
        $menus = [];
        $menu  = Menu::where('status', 0)->order('order asc');
        foreach ($this->info()->roles as $role) {
            if ($role->status !== 0) {
                continue;
            }
            if ($role['id'] == 1) {
                return \thans\layuiAdmin\facade\Utils::buildTree($menu->select()
                    ->toArray(), true);
            }
            $menus = array_merge($menus, $role->menus->toArray());
        }
        $menus = assoc_unique($menus, 'id');

        return \thans\layuiAdmin\facade\Utils::buildTree($menus, true);
    }

    public function check($path, $method = 'GET')
    {
        $path = parse_url($path)['path'];
        $path = trim($path, '/');
        $path = rtrim($path, 'html');
        $path = rtrim($path, '.');
        foreach ($this->info()->roles as $role) {
            if ($role->status !== 0) {
                continue;
            }
            //查找所有权限
            $permissions = $role->permissions()->select();
            if (! $permissions) {
                //本次权限组无权限，跳出本次循环
                continue;
            }
            foreach ($permissions as $val) {
                if ($val['alias'] == $path) {
                    return $this->checkMethod($val['http_method'], $method);
                }
                foreach (explode(PHP_EOL, $val['path']) as $v) {
                    if ($v == $path) {
                        return $this->checkMethod($val['http_method'], $method);
                    }
                    $pattern = trim($v, '/');
                    $pattern = trim($pattern, 'html');
                    $pattern = trim($pattern, '.');
                    $pattern = preg_quote($pattern, '#');
                    $pattern = str_replace('\*', '.*', $pattern);
                    if (preg_match('#^'.$pattern.'\z#u', $path) === 1) {
                        return $this->checkMethod($val['http_method'], $method);
                    }
                }
            }
        }

        return false;
    }

    private function checkMethod($http_method, $method)
    {
        if (strpos($http_method, strtoupper($method)) !== false || $http_method == '') {
            return true;
        }
    }
}
