<?php


namespace thans\layuiAdmin\model;


use think\Model;
use think\model\concern\SoftDelete;

class Menu extends Model
{
    use SoftDelete;
    protected $name = 'menu';

    public $list = [];
    public $title = [];

    public function tree($pid = 0, $deep = 0, $where = [], $label = '└―')
    {
        $list = $this->where('parent_id', $pid)->where($where)->order(['order' => 'asc', 'id' => 'asc'])->select();
        foreach ($list as $key => &$val) {
            $val['label'] = str_repeat($label, $deep) . $val['name'];
            $val['deep'] = $deep;
            $this->list[] = $val->toArray();
            $this->tree($val['id'], $deep + 1);
        }
        return $this->list;
    }
}