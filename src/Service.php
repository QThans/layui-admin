<?php


namespace thans\layuiAdmin;


class Service extends \think\Serive
{
    public function boot()
    {
        $this->commands(\thans\layuiAdmin\Command::class);
        $this->loadRoutesFrom('route'.DIRECTORY_SEPARATOR.'Route.php');
    }
}