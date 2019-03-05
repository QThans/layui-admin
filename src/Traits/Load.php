<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/7
 * Time: 00:33
 */

namespace thans\layuiAdmin\Traits;

use thans\layuiAdmin\Builder;

trait Load
{
    public $builder;

    public function addClassMap($name, $class)
    {
        $this->classMap[$name] = $class;
    }

    public function __call($name, $arguments)
    {
        if (isset($this->$name)) {
            if (is_array($this->$name)) {
                $this->$name[$arguments[0]] = $arguments[1]??'';
            } else {
                $this->$name = $arguments[0]??'';
            }
            return $this;
        }
        //判断是否builder类存在对应变量
        if (isset($this->builder->$name)) {
            if (is_array($this->builder->$name)) {
                if(count($arguments) == 1){
                    $this->builder->$name[] = $arguments[0]??'';                    
                }else{
                    $this->builder->$name[$arguments[0]] = $arguments[1]??'';
                }
            } else {
                $this->builder->$name = $arguments[0]??'';
            }
            return $this;
        }
        if (isset($this->classMap) && isset($this->classMap[$name]) && class_exists($this->classMap[$name])) {
            $class = new $this->classMap[$name](isset($arguments[0])?$arguments[0]:'', $this);
            return $class;
        }
    }

    public function render($component = false)
    {
        if (method_exists($this, 'end')) {
            $this->end();
        }
        return $this->builder->fetch($vars = [
            'self'=> $this
        ], $component);
    }
    
    public function display($tmpl)
    {
        return $this->builder->display($tmpl, $vars = [
            'self'=> $this
        ]);
    }

    public function __construct()
    {
        $this->builder = new Builder($this->tmpl);
        if (method_exists($this, 'init')) {
            $this->init();
        }
    }
}
