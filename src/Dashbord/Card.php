<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/6
 * Time: 15:37
 */

namespace thans\layuiAdmin\Dashbord;

use thans\layuiAdmin\Builder;
use thans\layuiAdmin\Render;
use thans\layuiAdmin\Traits\Compoents;

class Card extends Builder implements Render
{
    use Compoents;

    public $tmpl = 'dashbord/card';

    public $title = '';

    public $datas = [];

    public $col = 6;


    public function title($title = '')
    {
        $this->title = $title;
        return $this;
    }

    public function datas($datas = [])
    {
        $this->datas = $datas;
        return $this;
    }

    public function col($col = 6)
    {
        if ($col<0 || $col >12 || !is_int($col)) {
            throw new \think\Exception('col,必须：>=0 && <=12 且为整数');
        }
        $this->col = $col;
        return $this;
    }
}
