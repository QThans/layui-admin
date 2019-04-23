<?php


namespace thans\layuiAdmin\form;

use thans\layuiAdmin\Traits\Field;

class Icon
{
    use Field;

    public $tmpl = 'form/input';

    public $type = 'hidden';

    public $search = true;

    public $page = true;

    public $limit = 12;

    public function end()
    {
        $this->id = uniqid();
        $this->hide();
        $this->obj->module('iconPicker');
        $this->obj->script(
            'authtree' . $this->id,
            <<<EOD
            iconPicker.render({
                elem: '#{$this->id}',
                type: 'fontClass',
                // 是否开启搜索：true/false，默认true
                search: {$this->search},
                // 是否开启分页：true/false，默认true
                page: {$this->page},
                // 每页显示数量，默认12
                limit: {$this->limit},
                // 点击回调
                click: function (data) {
                },
                // 渲染成功后的回调
                success: function(d) {
                }
            });
EOD
        );
        $this->attr('lay-filter',$this->id);
        $val = $this->obj->data[$this->name];
        $setValueScript = $this->name ? ";iconPicker.checkIcon('{$this->id}', '{$val}');" : "";
        $this->obj->setValueScript('icon_' . $this->id, $setValueScript);
    }
}
