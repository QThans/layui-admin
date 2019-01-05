<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/7
 * Time: 00:33
 */

namespace thans\layuiAdmin\Traits;

trait Load
{
    public function addClassMap($name, $class)
    {
        $this->classMap[$name] = $class;
    }

    public function __call($name, $arguments)
    {
        if (isset($this->$name)) {
            $this->$name = $arguments[0]??'';
            return $this;
        }
        if (!isset($this->classMap[$name])) {
            throw new \think\Exception('组件方法不存在:'.$name);
        }
        if (class_exists($this->classMap[$name])) {
            $class = new $this->classMap[$name](isset($arguments[0])?$arguments[0]:'',$this->html);
            return $class;
        }
        throw new \think\Exception('组件类或变量不存在:'.$this->classMap[$name]);
    }

    public function render($component = false)
    {
        return $this->fetch($vars = [
            'builder'=> $this
        ], $component);
    }
}
