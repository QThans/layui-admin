<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin;

use think\View;

class Builder
{
    public static $html;

    public static $script;

    public static $style;

    public static $module = [
        'admin'
    ];

    public $view;

    public static $css = [
        'layui' => 'vendor/layui-admin/layui/css/layui.css',
        'iconfont' => 'vendor/layui-admin/layui/modules/css/layui-icon-extend/iconfont.css',
        'admin' => 'vendor/layui-admin/css/admin.css',
    ];

    public static $js = [
        'layui' => 'vendor/layui-admin/layui/layui.js',
    ];

    private $engineConfig = [];

    public function __construct($init = false)
    {
        if ($init) {
            self::$html = [];
        }
        $this->view = new View();
        $this->engineConfig['view_path'] = view_path();
        $this->engineConfig['layout_on'] = true;
        $this->engineConfig['layout_name'] = 'layout';
        $this->view->init($this->engineConfig);
    }

    final public function css($key, $css)
    {
        self::$css[$key] = $css;
        return $this;
    }

    final public function js($key, $js)
    {
        self::$js[$key] = $js;
        return $this;
    }

    final public function html($key, $html)
    {
        self::$html[$key] = $html;
        return $this;
    }

    final public function script($key, $script)
    {
        self::$script[$key] = $script;
        return $this;
    }
    
    final public function module($module)
    {
        if ($module == 'element') {
            $module = self::$module[0];
            self::$module[0] = 'element';
        }
        self::$module[] = $module;
        self::$module = array_unique(self::$module);
        return $this;
    }

    final public function style($key, $style)
    {
        self::$style[$key] = $style;
        return $this;
    }

    final public function push($html)
    {
        self::$html[] = $html;
        return $this;
    }

    public function fetch($vars = [], $component = false)
    {
        if ($component) {
            $this->engineConfig['layout_on'] = false;
            unset($this->engineConfig['layout_name']);
        }
        $class = get_called_class();
        return $this->view->fetch('/'.$class::$tmpl, $vars, $this->engineConfig);
    }

    public function __call($name, $value)
    {
        if (is_array($value[0])) {
            return $this;
        }
        if (isset(self::$$name)) {
            self::$$name = $value[0]??'';
            return $this;
        }
    }
}
