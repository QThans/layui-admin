<?php

namespace thans\layuiAdmin\controller;

use thans\layuiAdmin\Dashbord;
use thans\layuiAdmin\facade\Auth;
use thans\layuiAdmin\Index as Home;
use think\Db;
use think\facade\App;

class Index
{
    public function index()
    {
        $home = new Home();
        $userInfo = session('user_info');
        $home->userName($userInfo->nickname ? $userInfo->nickname : $userInfo->name);
        $menu = Auth::menu();
        $home->menu($menu);
        $home->firstTabUrl(url('thans\layuiAdmin\controller\Index@dashboard'));
        $home->firstTabName("控制台");
        $home->logo('LayuiAdmin-TP');
        $home->userMenu('个人设置', url('thans\layuiAdmin\controller\Personal@setting'));
        $home->userMenu('退出登录', '', ['target' => '_top', 'href' => url('thans\layuiAdmin\controller\Login@logout')]);
        return $home->render();
    }

    public function dashboard()
    {
        $dashboard = new Dashbord();
        $mysql = Db::query("select VERSION() as version");
        $mysql = $mysql[0]['version'];
        $mysql = empty($mysql) ? lang('UNKNOWN') : $mysql;
        $dashboard->card()->title('系统信息')->datas([
            'Thinkphp版本' => App::version(),
            '服务器版本' => $_SERVER['SERVER_SOFTWARE'],
            '系统' => PHP_OS,
            'PHP版本' => phpversion(),
            'MySql版本' => $mysql,
            '剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
        ]);
        $dashboard->card()->title('联系信息')->datas([
            '官网' => '<a href=\'https://layuiadmin.com\' target="_blank">LayuiAdmin-TP</a></a>',
            '商务联系' => '<img src="http://cdn.inge.vip/thans.jpeg">',
            '为我点赞' => '<a target="_blank" href=\'https://gitee.com/thans/layuiAdmin/stargazers\'><img src=\'https://gitee.com/thans/layuiAdmin/badge/star.svg?theme=white\' alt=\'star\'></img></a>',
        ]);
        return $dashboard->render();
    }
}