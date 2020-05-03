<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2019/1/4
 * Time: 16:07.
 */

namespace thans\layuiAdmin;

use thans\layuiAdmin\Traits\Load;

class Table
{
    use Load;

    public $tmpl = 'table';

    public $url = '';

    public $title = '';

    public $col = '12';

    public $id = '';

    public $refresh = true;

    public $search = true;

    public $classMap
        = [
            'status' => table\Status::class,
            'icon'   => table\Icon::class,
            'image'   => table\Image::class,
            'onoff'   => table\Onoff::class,
        ];

    public $filter = [];

    public $action = [];

    public $page = true;

    public $fields = [];

    public $tools = [];

    public $toolWidth = 'auto';

    public $toolTitleWidth = 0;

    protected $soulTableConfig;

    public $options = '';

    /**
     * 增加筛选条件。支持type类型：input\select。
     *
     * @param  string  $title
     * @param  string  $name
     * @param  string  $type
     * @param  array   $options  如果select必须包含：title和value。
     *
     * @return $this
     * @throws
     *
     */
    public function filter($title, $name, $type = 'input', $options = [])
    {
        $this->createFilter($title, $name, $type, $options);

        return $this;
    }

    private function createFilter($title, $name, $type = 'input', $options = [])
    {
        $id             = rand_uniqid();
        $this->filter[] = [
            'title'   => $title,
            'name'    => $name,
            'type'    => $type,
            'id'      => $id,
            'options' => $options,
        ];

        return $id;
    }

    /**
     * 日期筛选。支持 type 类型：year，month，date，time，datetime。传入options
     * options支持参数：range 开启范围面板
     *
     * @param         $title
     * @param         $name
     * @param  array  $options
     *
     * @return void
     * @throws
     *
     */
    public function timeFilter($title, $name, $options = [])
    {
        $id = $this->createFilter($title, $name);

        $options['elem'] = "#input-{$id}";

        $options = json_encode($options);

        $this->builder->module('laydate');

        $this->script[] = <<<EOD
laydate.render({$options});
EOD;
    }

    public function action($title, $href)
    {
        $this->action[] = [
            'title' => $title,
            'href'  => $href,
        ];

        return $this;
    }

    public function init()
    {
        $this->id = uniqid();
        $this->builder->module('table');
        $this->builder->module('jquery');
        $this->builder->module('form');
    }

    public function end()
    {
        $this->toolParse();
        $code = $this->display(__DIR__.DIRECTORY_SEPARATOR.'table'.DIRECTORY_SEPARATOR.'stub'.DIRECTORY_SEPARATOR
            .'table.js.stub');
        $this->builder->script('table', $code);
    }

    public function column($field, $title, $width = 200, $attr = [])
    {
        $column = ['field' => $field, 'title' => $title, 'width' => $width];

        $this->fields[] = array_merge($column, $attr);

        return $this;
    }

    public function tool(
        $title,
        $url,
        $action = 'formLayer',
        $type = 'primary',
        $method = 'get',
        $condition = '',
        $tips = ''
    ) {
        $this->tools[] = [
            'title'     => $title,
            'action'    => $action,
            'method'    => $method,
            'url'       => urldecode($url),
            'type'      => $type,
            'condition' => $condition,
            'tips'      => $tips,
        ];

        return $this;
    }

    public function htmlTool($html = '')
    {
        $this->tools[] = [
            'html' => $html,
        ];
        return $this;
    }

    public function soulTable($id = 'id', $field = 'sort', $url = 'edit', $options = [])
    {
        $url = urldecode($url);
        $this->builder->module('soulTable');
        $this->builder->css('soulTable', 'vendor/layui-admin/layui/modules/css/soulTable.css');
        if (isset($options['column']) || isset($options['columnTool'])) {
            $drag = [];
            if (isset($options['column']) && $options['column'] === 'simple') {
                $drag[] = "type:'simple'";
            }
            if (isset($options['columnTool']) && $options['columnTool'] == true) {
                $drag[] = "toolbar: true";
            }
            $this->option('drag', '{'.implode(',', $drag).'}');
        }
        if (isset($options['column']) && $options['column'] == false) {
            $this->option('drag', 'false');
        }
        if (isset($options['row']) && $options['row'] == true) {
            $rowDrag = <<<EOD
{trigger: 'row', done: function(obj) {
    var sorts = [],idArr = [],sortArr = [],before,after;
    if(obj.oldIndex < obj.newIndex){
        before = obj.newIndex;
        after = obj.oldIndex;
    }else{
        before = obj.oldIndex;
        after = obj.newIndex;
    }
    var idxs = (before - after) + 1;
    for(var i= 0;i < idxs; i++){
        idArr[i] = {
            id:obj.cache[after+i].id,
        }
        sortArr[i] = {
            sort:obj.cache[after+i].sort,
        }
    }
    var NewsortArr = JSON.parse(JSON.stringify(sortArr));
    function sortNumber(a,b) {
        return a.sort - b.sort;
    }
    NewsortArr.sort(sortNumber);
    sorts = idArr.map((item,index) => {
        return {...item, ...NewsortArr[index]};
    });
    admin.ajax('{$url}',{sorts:sorts})
    location.reload();
}}
EOD;
            $this->option('rowDrag', $rowDrag);
        }
        $this->option('done', <<<EOD
function () {
  soulTable.render(this)
}
EOD);
    }
    public function option($key, $value)
    {
        $this->options .= "\n, {$key}:{$value}";

        return $this;
    }
    private function toolParse()
    {
        if (! empty($this->tools)) {
            $html = '';
            foreach ($this->tools as $val) {
                $this->toolTitleWidth += strlen($val['title']);
                if (isset($val['html'])) {
                    $html .= $val['html'];
                    continue;
                }
                if ($val['type']) {
                    $class = 'layui-btn-'.$val['type'];
                } else {
                    $class = '';
                }
                if ($val['action'] == 'confirmAjax') {
                    $val['title-tips'] = $val['tips'] ? $val['tips'] : '确定'.$val['title'].'吗？';
                } else {
                    $val['title-tips'] = $val['tips'] ? $val['tips'] : $val['title'];
                }
                $tmp
                    = "<a href='javascript:;' refresh='{$this->id}' admin-event='{$val['action']}' data-title='{$val['title-tips']}' data-href='{$val['url']}' method='{$val['method']}' class='layui-btn layui-btn-xs {$class}'>{$val['title']}</a>";
                if ($val['condition']) {
                    $tmp = '{{#  if('.$val['condition'].'){ }}'.$tmp.'{{#  } }}'; //条件
                }
                $html .= $tmp;
            }
            $this->builder->html[] = <<<EOD
<script type="text/html" id="tools">
{$html}
</script>
EOD;
            if ($this->toolWidth == 'auto') {
                $this->toolWidth = ($this->toolTitleWidth / 3) * 27.5;
                $this->toolWidth = $this->toolWidth > 70 ? $this->toolWidth : 70;
            }
            $this->column('', '操作', $this->toolWidth, ['fixed' => 'right', 'templet' => '#tools']);
        }
    }
}
