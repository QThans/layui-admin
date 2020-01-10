<?php

namespace thans\layuiAdmin\controller\system;

use thans\layuiAdmin\facade\AdminsAuth;
use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\facade\Utils;
use thans\layuiAdmin\Form;
use thans\layuiAdmin\model\SystemConfig;
use thans\layuiAdmin\model\SystemConfigTab;
use thans\layuiAdmin\Table;
use thans\layuiAdmin\Traits\FormActions;
use thans\layuiAdmin\validate\SystemConfig as ValidateSystemConfig;
use think\Request;

class Config
{
    use FormActions;
    public $saveUrl;
    public function __construct(Request $request)
    {
        $this->saveUrl = url('thans\layuiAdmin\controller\system\Config/save', ['config_tab_id' => $request->param('config_tab_id')]);
        $this->updateUrl = url('thans\layuiAdmin\controller\system\Config/update', ['config_tab_id' => $request->param('config_tab_id'), 'id' => $request->param('id')]);
    }
    public function index($configTabId, Request $request)
    {
        $configTab = SystemConfigTab::find($configTabId);
        if ($request->isAjax()) {
            list($where, $order, $page, $limit) = Utils::buildParams('name|alias|tips');
            $where[] = ['config_tab_id', '=', $configTabId];
            $model = SystemConfig::where($where);
            $total = $model->count();
            $list = $model->order('weight asc')->page($page)->limit($limit)->select();
            Json::success('获取成功', $list, ['total' => $total]);
        }
        $tb = new Table();
        $tb->url(url('thans\layuiAdmin\controller\system\Config/index', ['config_tab_id' => $configTabId]));
        $tb->action('新增配置项', url('thans\layuiAdmin\controller\system\Config/create', ['config_tab_id' => $configTabId]));
        $tb->title($configTab['name']);

        $tb->column('id', 'ID', 60);
        $tb->column('name', '配置项名称');
        $tb->column('alias', '别名');
        $tb->status()
            ->option('text', '单行文本框')
            ->option('textarea', '多行文本框')
            ->option('select', '单选下拉框')
            ->option('upload', '文件上传')
            ->column('type', '配置类型', 120, ['align' => 'center']);
        $tb->column('value', '配置值', 320);

        $tb->status()->option(0, '正常')->option(
            1,
            '禁用',
            'danger'
        )->column('status', '状态', 100, ['align' => 'center']);

        $url = url('thans\layuiAdmin\controller\system\Config/edit', ['config_tab_id' => $configTabId, 'id' => '{{d.id}}']);
        if (AdminsAuth::check($url)) {
            $tb->tool('编辑', $url);
        }
        $url = url('thans\layuiAdmin\controller\system\Config/delete', ['config_tab_id' => $configTabId, 'id' => '{{d.id}}']);
        if (AdminsAuth::check($url)) {
            $tb->tool(
                '删除',
                $url,
                'confirmAjax',
                'danger',
                'DELETE'
            );
        }
        return $tb->render();
    }

    private function buildForm($request = null)
    {
        $form = new Form(new SystemConfig(), new ValidateSystemConfig);
        $form->text()->name('name')->label('配置项名称')->rules('required', true, 1, 100)->placeholder('请输入配置项名称');
        $form->text()->name('alias')->label('别名')->rules('required', true, 1, 100)->placeholder('请输入别名');
        $form->textarea()->name('tips')->label('说明')->placeholder('请输入说明');
        $form->text()->name('rule')->label('验证规则')->placeholder('请输入验证规则');
        $form->number()->name('weight')->label('排序')->placeholder('请输入排序权重值')->value(1000);
        $form->radio()->name('type')->label('配置类型')->options([
            ['title' => '单行文本框', 'val' => 'text'],
            ['title' => '单选下拉框', 'val' => 'select'],
            ['title' => '多行文本框', 'val' => 'textarea'],
            ['title' => '文件上传', 'val' => 'upload'],
        ])->value('text')->attr('lay-filter','config_type');
        $form->textarea()->name('parameter')->label('参数');
        $form->textarea()->name('value')->label('配置值');
        $form->onoff()->name('status')->label('是否禁用')->text('禁用|启用');
        $form->module('jquery');
        $form->builder->script('config_type',<<<EOD
        form.on('radio(config_type)', function(data){
            $('textarea[name="parameter"]').val('');
            if(data.value == 'upload'){
                var tips = "url=>上传地址\\nfield=>image\\nuploadType=>image\\number=>1";
                $('textarea[name="parameter"]').val(tips);
            }
            if(data.value == 'select'){
                $('textarea[name="parameter"]').val('选项值=>选项文本');
            }
        });  
EOD);
        return $form;
    }
}
