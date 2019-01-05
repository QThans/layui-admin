<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2019/1/4
 * Time: 16:07
 */

namespace thans\layuiAdmin;

use thans\layuiAdmin\Traits\Load;

class Table extends Builder
{
    use Load;
    public $tmpl = 'table';

    public $url = '';

    public $title = '';

    public $col = '12';

    public $id = '';

    public $refresh = true;

    public $search = true;

    public $classMap = [
        'status' => Table\Status::class,
    ];

    public $filter = [];

    public $action = [];

    public $fields = [];

    public $tools = [];

    public $toolWidth = 100;


    /**
     * 增加筛选条件。支持type类型：input\select。
     * @param string $title
     * @param string $name
     * @param string $type
     * @param array $options 如果select必须包含：title和value。
     * @return $this
     * @throws
     */
    public function filter($title, $name, $type = 'input', $options = [])
    {
        $this->createFilter($title, $name, $type, $options);
        return $this;
    }

    private function createFilter($title, $name, $type = 'input', $options = [])
    {
        $id = uniqid();
        $this->filter[] = [
            'title'=>$title,
            'name'=>$name,
            'type'=>$type,
            'id'=>$id,
            'options'=>$options
        ];
        return $id;
    }

    /**
     * 日期筛选。支持 type 类型：year，month，date，time，datetime。传入options
     * options支持参数：range 开启范围面板
     * @param $title
     * @param $name
     * @param array $options
     * @return void
     * @throws
     */
    public function timeFilter($title, $name, $options = [])
    {
        $id = $this->createFilter($title, $name);

        $options['elem'] = "#input-{$id}";

        $options = json_encode($options);

        $this->module('laydate');

        $this->script[] = <<<EOD
laydate.render({$options});
EOD;
    }
    public function action($title, $href)
    {
        $this->action[] = [
            'title'=>$title,
            'href'=>$href
        ];
        return $this;
    }

    public function __construct()
    {
        parent::__construct();
        $this->id = uniqid();
        $this->module('table');
        $this->module('jquery');
        $this->module('form');
    }

    public function column($field, $title, $width = 100, $tpl = '', $attr = [])
    {
        $column = ['field'=>$field,'title'=>$title,'width'=>$width,'templet'=>$tpl?'#'.$tpl:''];
        $this->fields[] = array_merge($column, $attr);
        return $this;
    }

    public function tool($title, $url,$type = 'primary', $method='get', $action = 'ajax')
    {
        $this->tools[] = [
          'title'=>$title,
          'action'=>$action,
          'method'=>$method,
          'url'=>$url,
          'type'=>$type,
        ];
        return $this;
    }


    private function toolParse()
    {
        if (!empty($this->tools)) {
            $html = '';
            foreach ($this->tools as $val) {
                if ($val['type']) {
                    $class = 'layui-btn-'.$val['type'];
                } else {
                    $class = '';
                }
                $html .= "<a href='javascript:;' admin-event='{$val['action']}' data-title='确定{$val['title']}吗？' data-href='{$val['url']}' method='{$val['method']}' class='layui-btn layui-btn-xs {$class}'>{$val['title']}</a>";
            }
            $this->html[] = <<<EOD
<script type="text/html" id="tools">
{$html}
</script>
EOD;
            $this->column('', '操作', $this->toolWidth, 'tools', ['fixed'=>'right']);
        }
    }

    public function render($component = false)
    {
        $id = $this->id;
        $url = $this->url;
        $this->toolParse();


        $fields = json_encode($this->fields);

        $this->script[] = <<<EOD
        var list_table_{$id} = admin.table(table, 'list-table-{$id}', '{$url}', {
            page: true
            , cols: [{$fields}]
        });
EOD;


        if ($this->refresh) {
            $this->script[] = <<<EOD
        $('#layui-icon-refresh-{$id}').click(function () {
            list_table_{$id}.reload();
        });
EOD;
        }


        if ($this->filter || $this->search) {
            $this->script[] = <<<EOD
        form.on('submit(search-{$id})', function(data){
              list_table_{$id}.reload({
                where: {
                   filter:data.field
                }
               });
              return false;
         });
EOD;
        }

        return $this->fetch($vars = [
            'builder'=> $this
        ], $component);
    }
}
