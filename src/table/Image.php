<?php
namespace thans\layuiAdmin\Table;

use thans\layuiAdmin\Traits\Column;

class Image
{
    use Column;

    public $tmpl = 'table/image';

    public $field = 'image';

    public $width = 20;

    public $height = 20;

    public function width($width = 20)
    {
        $this->width = $width;

        return $this;
    }

    public function height($height = 20)
    {
        $this->height = $height;

        return $this;
    }

    public function end()
    {
        $this->obj->script(
            'view_'.$this->id,
            <<<EOT
$(document).on('click','.view_{$this->id}',function(){
    layer.open({
      type: 1,
      title: false,
      closeBtn: 0,
      shadeClose: true,
      area: 'auto',
      content: '<img style="height:100%;width:100%;" src="'+$(this).attr('src')+'">'
    });
});
EOT
        );
    }
}
