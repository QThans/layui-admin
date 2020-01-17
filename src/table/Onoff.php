<?php
namespace thans\layuiAdmin\table;

use thans\layuiAdmin\Traits\Column;

class Onoff
{
    use Column;

    public $tmpl = 'table/onoff';

    public $field = 'status';

    public $url = '';

    public $text = '启用|禁用';

    public $reload = false;

    public function url($url)
    {
        $this->url = urldecode($url);

        return $this;
    }

    public function text($text = '启用|禁用')
    {
        $this->text = $text;

        return $this;
    }
    public function reload($reload = false)
    {
        $this->reload = $reload;

        return $this;
    }

    public function end()
    {
        $this->obj->script('onoff_'.$this->id, <<<EOT
form.on('switch(switch)', function(data){
    var reload = true,url = $(this).prev('input').context.dataset.href;
    $.ajax({
        url:url,
        data:{'{$this->field}':this.checked ? '0' : '1'},
        type:"Post",
        dataType:"json",
        success:function(data){
          layer.msg(data.message);
          if(reload == '{$this->reload}') location.reload(); 
        },
        error:function(data){
          $.messager.alert('错误',data.message);
        }
    });
});
EOT
        );
    }
}
