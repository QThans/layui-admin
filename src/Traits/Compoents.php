<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/7
 * Time: 15:52
 */

namespace thans\layuiAdmin\Traits;

trait Compoents
{
    public $disabled = '';

    public $renderHtml = [];

    public $obj = [];

    public function load($arguments = [])
    {
        if ($arguments && is_array($arguments)) {
            foreach ($arguments as $key => $val) {
                if (isset($this->$key)) {
                    $this->$key = $val;
                }
            }
        }
    }

    public function __construct($arguments = [],&$obj = '')
    {
        parent::__construct();
        $this->load($arguments);
        $this->obj = &$obj;
        $this->renderHtml = &$obj->html;
        return $this;
    }

    public function __destruct()
    {
        $this->render();
    }
    public function disabled($disabled)
    {
        $this->disabled = $disabled ? 'disabled' : '';
        return $this;
    }
    public function render()
    {
        $render = $this->fetch([
            'self' => $this
        ], true);
        $this->renderHtml[] = $render;
        return $this;
    }
    public function __call($name, $value)
    {
        if (is_array($value[0])) {
            return $this;
        }
        if (isset($this->$name)) {
            $this->$name = $value[0]??'';
        }
        return $this;
    }

    public function __toString()
    {
        return $this;
    }
}
