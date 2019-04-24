<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2019/1/6
 * Time: 11:13
 */

namespace thans\layuiAdmin\form;

use thans\layuiAdmin\Traits\Field;

class Authtree
{
    use Field;

    public $tmpl = 'form/authtree';

    public $url = '';

    public $id = '';
    //主键
    public $primaryKey = 'id';
    //父级id对应键
    public $parentKey = 'pid';
    //作为父节点的pid，会先查找此pid对应的节点作为父节点
    public $startPid = 0;
    //节点标题对应的key
    public $nameKey = 'name';
    //节点值对应的key
    public $valueKey = 'id';
    //节点是否选中的字段（支持 String 和 Array）
    public $checked = [];

    public function end()
    {
        $this->id = uniqid();
        $this->obj->module('authtree');
        $this->obj->script(
            'authtree',
            <<<EOD
        admin.ajax('{$this->url}', '', function (data) {
             if (data.code == 1) {
                var trees = authtree.listConvert(data.data, {
				    primaryKey: '{$this->primaryKey}'
					,startPid: {$this->startPid}
					,parentKey: '{$this->parentKey}'
					,nameKey: '{$this->nameKey}'
					,valueKey: '{$this->valueKey}'
					,checkedKey:{$this->checked}
				});
				authtree.render('#LAY-auth-tree-index-{$this->id}', trees, {
					nputname: '{$this->name}[]', 
					layfilter: 'lay-check-convert-auth-{$this->id}', 
					autowidth: true,
					inputname:'{$this->name}[]'
				});
             } else {
                  layer.msg(data.msg);
             }
        },'','get');
EOD
);
    }
}
