<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin;

use think\App;
use think\View;

class Builder
{
    public $html = [];

    public $script = [];

    public $style = [];

    public $tmpl = '';

    public $module
        = [
            'admin',
        ];

    public $view;

    public $css
        = [
            'layui'       => 'vendor/layui-admin/layui/css/layui.css',
            'fa-iconfont' => 'vendor/layui-admin/font-awesome/css/font-awesome.min.css',
            'admin'       => 'vendor/layui-admin/css/admin.css',
        ];

    public $js
        = [
            'layui' => 'vendor/layui-admin/layui/layui.js',
        ];

    public $compoents = [];

    private $engineConfig = [];

    public function __construct($tmpl = '', $init = false)
    {
        if ($init) {
            $this->html = [];
        }
        $this->view                      = new View(\think\facade\App::getInstance());
        $this->engineConfig['view_path'] = view_path();
        $this->tmpl                      = $tmpl;
        $this->view->engine('Think')->config($this->engineConfig);
    }

    final public function css($key, $css)
    {
        $this->css[$key] = $css;

        return $this;
    }

    final public function js($key, $js)
    {
        $this->js[$key] = $js;

        return $this;
    }

    final public function html($key, $html)
    {
        $this->html[$key] = $html;

        return $this;
    }

    final public function script($key, $script)
    {
        $this->script[$key] = $script;

        return $this;
    }

    final public function compoents($key, $html)
    {
        $this->compoents[$key] = $html;

        return $this;
    }

    final public function module($module)
    {
        if ($module == 'element') {
            $module          = $this->module[0];
            $this->module[0] = 'element';
        }
        $this->module[] = $module;
        $this->module   = array_unique($this->module);

        return $this;
    }

    final public function style($key, $style)
    {
        $this->style[$key] = $style;

        return $this;
    }

    public function fetch($vars = [], $component = false)
    {
        $this->engineConfig['layout_on'] = true;
        if ($component) {
            $this->engineConfig['layout_on'] = false;
            unset($this->engineConfig['layout_name']);
        }
        $this->engineConfig['view_path'] = view_path();
        $tmpl                            = $this->tmpl;
        $this->view->engine('Think')->config($this->engineConfig);

        $this->view->assign($vars);

        return $this->view->fetch($tmpl);
    }

    public function display($tmpl, $vars = [])
    {
        $this->view->engine('Think')->layout(false);
        $this->view->assign($vars);

        return $this->view->fetch($tmpl);
    }

    //加载其他组件
    public function load($obj)
    {
        $this->html[] = $obj->render(true);
        $vars         = get_object_vars($this);
        foreach ($vars as $key => $val) {
            if (is_array($this->$key)) {
                $this->$key = array_merge($this->$key, $obj->builder->$key);
            }
        }
    }
}
