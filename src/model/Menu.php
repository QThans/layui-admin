<?php


namespace thans\layuiAdmin\model;


use think\Model;
use think\model\concern\SoftDelete;

class Menu extends Model
{
    use SoftDelete;
    protected $name = 'menu';

    public function setUriAttr($value)
    {
        return trim($value, '/');
    }

}