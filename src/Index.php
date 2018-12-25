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

    public static $menu = [];

    public static $userNmae = '';

    public static $userMenu = [];// title  href  attr

    public static $tmpl = 'index';

    public static $firstTabName = '';

    public static $firstTabUrl = '';

    public static $logo = '';

    public static $sLogo = '';

    public static $child = 0;

    public function userMenu($title, $href = '', $attr = [])
    {
        self::$userMenu[] = [
            'title'=>$title,
            'href'=>$href,
            'attr'=>$attr
        ];
        return $this;
    }

    public function menu($title, $href = '', $icon = '', $attr = [])
    {
        $key = count(self::$menu)+1;
        self::$menu[$key] = [
            'title'=>$title,
            'icon'=>$icon,
            'href'=>$href,
            'attr'=>$attr,
            'child'=>[]
        ];
        self::$child = $key;
        return $this;
    }

    public function child($title, $href = '', $icon = '', $attr = [])
    {
        self::$menu[self::$child]['child'] = [
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
