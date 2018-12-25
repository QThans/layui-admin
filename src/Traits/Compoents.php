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
    public static $disabled = '';

    public function load($arguments = [])
    {
        if ($arguments && is_array($arguments)) {
            foreach ($arguments as $key => $val) {
                if (isset(self::$$key)) {
                    self::$$key = $val;
                }
            }
        }
    }

    public function __construct($arguments = [])
    {
        parent::__construct();
        $this->load($arguments);
        return $this;
    }

    public function __destruct()
    {
        $this->render();
    }
    public function disabled($disabled)
    {
        self::$disabled = $disabled ? 'disabled' : '';
        return $this;
    }
    public function render()
    {
        $this->push($this->fetch([
            'self' => $this
        ], true));
    }

}
