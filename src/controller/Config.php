<?php

namespace thans\layuiAdmin\controller;

use thans\layuiAdmin\Table;
use thans\layuiAdmin\Traits\FormActions;
use think\Request;

class Menu
{
    use FormActions;

    public function index(Request $request)
    {
        if ($request->isAjax()) {
            
        }
        $tb = new Table();
        $tb->url(url('thans\layuiAdmin\controller\Menu/index'));
        
        $tb->title('菜单管理');

        return $tb->render();
    }

    private function buildForm()
    {

    }
}
