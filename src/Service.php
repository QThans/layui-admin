<?php


namespace thans\layuiAdmin;


class Service extends \think\Service
{
    public function boot()
    {
        $this->commands(\thans\layuiAdmin\Command::class);
        $this->loadRoutesFrom(__DIR__.DIRECTORY_SEPARATOR.'route'.DIRECTORY_SEPARATOR.'Route.php');
    }
}