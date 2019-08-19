<?php

namespace thans\layuiAdmin\controller;

use thans\layuiAdmin\facade\AdminsAuth;
use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\facade\Jump;
use thans\layuiAdmin\Login as LoginView;
use think\Exception;
use think\exception\HttpException;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Session;
use think\Loader;
use think\Request;

class Login
{
    public function index()
    {
        $login = new LoginView();

        try {
            foreach (Config::get('admin.login') as $key => $val) {
                $key = Loader::parseName($key, 1, false);
                $login->$key($val);
            }
        } catch (Exception $e) {
            abort(404, '参数错误，请先执行layuiAdmin安装命令');
        }
        $login->url(url('thans\layuiAdmin\controller\Login@doLogin'));

        return $login->render();
    }

    public function doLogin(Request $request)
    {
        $account = $request->param('account');
        $password = $request->param('password');
        $redirect = $request->param('redirect', '');

        try {
            $admins = AdminsAuth::login($account, $password);
            session('admins_id', $admins->id);
            session('admins_info', $admins);
            Cache::rm('admins_'.$admins->id);
            Json::success('登录成功...', [], [], $redirect ? $redirect : url('thans\layuiAdmin\controller\Index@index'), 2);
        } catch (HttpException $e) {
            Json::error($e->getMessage(), 400);
        }
    }

    public function logout(Request $request)
    {
        Cache::rm('admins_'.session('admins_id'));
        Session::clear();
        if ($request->isAjax()) {
            Json::success('退出成功');
        }
        Jump::success('退出成功', url('thans\layuiAdmin\controller\Login@index'));
    }
}
