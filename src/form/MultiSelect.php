<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/8
 * Time: 00:32
 */

namespace thans\layuiAdmin\form;

class MultiSelect extends Select
{
    public function end()
    {
        if (method_exists(parent::class, 'end')) {
            parent::end();
        }
        $this->obj->module('formSelects');
        $this->obj->css($this->id, 'vendor/layui-admin/layui/modules/css/formSelects.css');
        $this->attr('xm-select', 'xm-' . $this->id);
        $this->obj->module('jquery');
        $this->obj->script($this->id, "formSelects.render('xm-{$this->id}');");
        $val = isset($this->obj->data[$this->name]) ? $this->obj->data[$this->name] : '';
        $val = explode(',', $val);
        $val = json_encode($val);
        $this->obj->setValueScript($this->id, "formSelects.value('xm-{$this->id}',{$val});");
    }

    public function search($url = '')
    {
        $this->attr('xm-select-search', $url);
    }

    public function value($val = '')
    {
        $val = explode(',', $this->value);
        $val = json_encode($val);
        $this->obj->script($this->id, "formSelects.value('xm-{$this->id}',{$val};");
    }

    public function searchType($type = 'title')
    {
        $this->attr('xm-select-search-type', $type);
    }

    public function radio()
    {
        $this->attr('xm-select-radio');
    }
}
