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
        $this->clearCache();
        return $user;
    }

    public function clearCache()
    {
        Cache::rm('user_' . session('user_id'));
    }

    public function user()
    {
        $user = Cache::get('user_' . session('user_id'));
        if (!$user) {
            $user = User::get(session('user_id'), 'meta');
            Cache::set('user_' . session('user_id'), $user, 3600);
        }
        return $user;
    }

    public function userId()
    {
        return session('user_id');
    }

    public function menu()
    {
        $roles = $this->isAdmin();
        if (!$roles) {
            return false;
        }
        $menus = [];
        $menu = Menu::where('status', 0)->order('order asc');
        foreach ($roles as $role) {
            if ($role['id'] == 1) {
                return \thans\layuiAdmin\facade\Utils::buildTree($menu->select()->toArray(), true);
            }
            $menus = array_merge($menus, $role->menus->toArray());
            $menus = array_merge($menus, $role->menus->toArray());
        }
        $menus = assoc_unique($menus, 'id');
        return \thans\layuiAdmin\facade\Utils::buildTree($menus, true);
    }

    public function isAdmin()
    {
        $user = $this->user();
        if (!$user || !$user->admin) {
            return false;
        }
        return $user->roles;
    }

    public function check($path, $method = 'GET')
    {
        $path = parse_url($path)['path'];
        $path = trim($path, '/');
        $path = trim($path, '.html');
        $roles = $this->isAdmin();
        if (!$roles) {
            return false;
        }
        foreach ($roles as $role) {
            if ($role->status !== 0) {
                continue;
            }
            //查找所有权限
            $permissions = $role->permissions()->select();
            if (!$permissions) {
                //本次权限组无权限，跳出本次循环
                continue;
            }
            foreach ($permissions as $val) {
                if ($val['alias'] == $path) {
                    return $this->chekMethod($val['http_method'], $method);
                }
                foreach (explode("\r\n", $val['path']) as $v) {
                    if ($v == $path) {
                        return $this->chekMethod($val['http_method'], $method);
                    }
                    $pattern = trim($v, '/');
                    $pattern = trim($pattern, '.html');
                    $pattern = preg_quote($pattern, '#');
                    $pattern = str_replace('\*', '.*', $pattern);
                    if (preg_match('#^' . $pattern . '\z#u', $path) === 1) {
                        return $this->chekMethod($val['http_method'], $method);
                    }
                }
            }
        }
        return false;
    }

    private function chekMethod($http_method, $method)
    {
        if (strpos($http_method, $method) !== false || $http_method == "") {
            return true;
        }
    }
}
