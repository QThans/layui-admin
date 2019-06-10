<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2019/1/6
 * Time: 11:13.
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
    public $parentKey = 'parent_id';
    //作为父节点的pid，会先查找此pid对应的节点作为父节点
    public $startPid = 0;
    //节点标题对应的key
    public $nameKey = 'name';
    //节点值对应的key
    public $valueKey = 'id';

    public $checkedKey = 'checked';

    public $dataField = 'data';

    public $items = '';

    public function items($val = [])
    {
        $this->items = $val;

        return $this;
    }

    public function end()
    {
        $this->id = uniqid();
        $this->obj->module('authtree');
        if ($this->items) {
            if (isset($this->obj->data[$this->name]) && $this->obj->data[$this->name]) {
                $values = explode(',', $this->obj->data[$this->name]);
                $checked = array_combine($values, $values);
                foreach ($this->items as &$item) {
                    if (isset($checked[$item[$ths->valueKey]])) {
                        $item['checked'] = true;
                    }
                }
            }

            $items = json_encode($this->items, JSON_NUMERIC_CHECK);
            $this->obj->script(
                'authtree',
                <<<EOD
                var trees = authtree.listConvert({$items}, {
				    primaryKey: '{$this->primaryKey}'
					,startPid: {$this->startPid}
					,parentKey: '{$this->parentKey}'
					,nameKey: '{$this->nameKey}'
					,valueKey: '{$this->valueKey}'
					,checkedKey:'{$this->checkedKey}'
				});
				authtree.render('#LAY-auth-tree-index-{$this->id}', trees, {
					inputname: '{$this->name}[]', 
					layfilter: 'lay-check-convert-auth-{$this->id}', 
					autowidth: true,
					inputname:'{$this->name}[]'
				});
EOD
            );
        } elseif (isset($this->url) && $this->url) {
            $this->obj->script(
                'authtree',
                <<<EOD
        admin.ajax('{$this->url}', '', function (data) {
             if (data.code == 1) {
                var trees = authtree.listConvert(data.{$this->dataField}, {
				    primaryKey: '{$this->primaryKey}'
					,startPid: {$this->startPid}
					,parentKey: '{$this->parentKey}'
					,nameKey: '{$this->nameKey}'
					,valueKey: '{$this->valueKey}'
					,checkedKey:'{$this->checkedKey}'
				});
				authtree.render('#LAY-auth-tree-index-{$this->id}', trees, {
					inputname: '{$this->name}[]', 
					layfilter: 'lay-check-convert-auth-{$this->id}', 
					autowidth: true
				});
             } else {
                  layer.msg(data.msg);
             }
        },'','get');
EOD
            );
        }
    }
}
