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
        self::$classMap[$name] = $class;
    }

    public function __call($name, $arguments)
    {
        if (isset(self::$$name)) {
            self::$$name = $arguments[0]??'';
            return $this;
        }
        if (!isset(self::$classMap[$name])) {
            throw new \think\Exception('组件方法不存在:'.$name);
        }
        if (class_exists(self::$classMap[$name])) {
            $class = new self::$classMap[$name](isset($arguments[0])?$arguments[0]:'');
            return $class;
        }
        throw new \think\Exception('组件类或方法不存在:'.self::$classMap[$name]);
    }

    public function render($component = false)
    {
        return $this->fetch($vars = [
            'builder'=> $this
        ], $component);
    }
}
