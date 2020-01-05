<?php


namespace thans\layuiAdmin;

class Service extends \think\Service
{
    public function boot()
    {
        $this->commands([
            \thans\layuiAdmin\command\Admin::class,
            \thans\layuiAdmin\command\tools\Repwd::class
        ]);
        $this->app->middleware->add(\think\middleware\SessionInit::class);
        $this->loadRoutesFrom(__DIR__.DIRECTORY_SEPARATOR.'route'.DIRECTORY_SEPARATOR.'Route.php');
    }
}
