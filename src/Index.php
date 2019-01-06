<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin;

use thans\layuiAdmin\Traits\Compoents;

class Index extends Builder
{
    use Compoents;

    public $topMenu = [];

    public $menu = [];

    public $userName = '';

    public $userMenu = [];// title  href  attr

    public $tmpl = 'index';

    public $firstTabName = '';

    public $firstTabUrl = '';

    public $logo = '';

    public $sLogo = '';

    public $child = 0;

    public function userMenu($title, $href = '', $attr = [])
    {
        $this->userMenu[] = [
            'title'=>$title,
            'href'=>$href,
            'attr'=>$attr
        ];
        return $this;
    }

    public function menu($menu)
    {
        $this->menu = $menu;
        return $this;
    }

    public function child($title, $href = '', $icon = '', $attr = [])
    {
        $this->menu[$this->child]['child'] = [
            'title'=>$title,
            'icon'=>$icon,
            'href'=>$href,
            'attr'=>$attr
        ];
        return $this;
    }

    public function render()
    {
        $this->module('element');
        $this->script('admin', [
            'element.render();',
            'admin.changeAdminTab(element);',
            'admin.prevAdminTab();',
            'admin.nextAdminTab();',
            'admin.bindCloseTab();',
        ]);
        $this->view->assign('self', $this);
        $this->view->assign('builder', $this);
        return $this->fetch();
    }
}
