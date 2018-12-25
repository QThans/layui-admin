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

    public static $topMenu = [];

    public static $userNmae = '';

    public static $userMenu = [];// title  href  attr

    public static $tmpl = 'index';

    public static $firstTabName = '';

    public static $firstTabUrl = '';

    public static $logo = '';

    public static $sLogo = '';

    public function userMenu($title, $href, $attr = [])
    {
        self::$userMenu[] = [
            'title'=>$title,
            'href'=>$href,
            'attr'=>$attr
        ];
        return $this;
    }
    
    public function render()
    {
        $this->module('element');
        $this->script('admin', [
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
