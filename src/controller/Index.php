<?php

namespace thans\layuiAdmin\controller;

use thans\layuiAdmin\Dashbord;
use thans\layuiAdmin\Index as Home;

class Index
{
    public function index()
    {
        $home = new Home();
        $userInfo = session('user_info');
        $home->userName($userInfo->nickname ? $userInfo->nickname : $userInfo->name);

        return $home->render();
    }

    public function dashbord()
    {
        $dashbord = new Dashbord();

        return $dashbord->render();
    }
}