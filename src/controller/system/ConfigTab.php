<?php

namespace thans\layuiAdmin\controller\system;

use thans\layuiAdmin\facade\AdminsAuth;
use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\facade\Jump;
use thans\layuiAdmin\facade\Utils;
use thans\layuiAdmin\Form;
use thans\layuiAdmin\model\SystemConfig;
use thans\layuiAdmin\model\SystemConfigTab;
use thans\layuiAdmin\Table;
use thans\layuiAdmin\Traits\FormActions;
use thans\layuiAdmin\validate\SystemConfigTab as ValidateSystemConfigTab;
use think\Request;

class ConfigTab
{
    use FormActions;

    public function index(Request $request)
    {
        if ($request->isAjax()) {
            list($where, $order, $page, $limit) = Utils::buildParams('name|alias');
            $model = SystemConfigTab::where($where);
            $total = $model->count();
            $list = $model->order($order)->limit($limit)->page($page)->select();
            Json::success('获取成功', $list, ['total' => $total]);
        }
        $tb = new Table();
        $tb->url(url('thans\layuiAdmin\controller\system\ConfigTab/index'));
        $tb->title('配置分类');
        $tb->action('新增配置分类', url('thans\layuiAdmin\controller\system\ConfigTab/create'));
        $tb->column('id', 'ID', 100);
        $tb->column('name', '配置分类名称');
        $tb->column('alias', '配置分类别名');
        $tb->status()->option(0, '系统配置')
            ->option(1, '应用配置')
            ->option(2, '支付配置')
            ->option(3, '其他')
            ->column('status', '配置类型', 100, ['align' => 'center']);

        $tb->status()->option(0, '正常')->option(
            1,
            '禁用',
            'danger'
        )->column('status', '状态', 100, ['align' => 'center']);

        $tb->column('create_time', '创建时间');
        $tb->column('update_time', '更新时间');
        $url = url(
            'thans\layuiAdmin\controller\system\Config/index',
            ['config_tab_id' => '{{ d.id }}']
        );
        if (AdminsAuth::check($url)) {
            $tb->tool('配置项管理', $url);
        }
        $url = url(
            'thans\layuiAdmin\controller\system\ConfigTab/edit',
            ['id' => '{{ d.id }}']
        );
        if (AdminsAuth::check($url)) {
            $tb->tool('编辑', $url);
        }
        $url = url(
            'thans\layuiAdmin\controller\system\ConfigTab/delete',
            ['id' => '{{ d.id }}']
        );
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

    private function buildForm()
    {
        $form = new Form(new SystemConfigTab, new ValidateSystemConfigTab);
        $form->text()->name('name')->label('配置分类名称')->rules('required', true, 1, 20);;
        $form->text()->name('alias')->label('配置分类别名')->tips('用于系统获取等操作')->rules('required', true, 1, 20);;
        $form->onoff()->name('status')->label('是否禁用')->text('禁用|启用');
        $form->radio()->name('type')->label('配置类型')->options([
            ['title' => '系统配置', 'val' => 0],
            ['title' => '应用配置', 'val' => 1],
            ['title' => '支付配置', 'val' => 2],
            ['title' => '其他', 'val' => 3],
        ]);
        $form->beforeDestroy(function (Form $form, $model) {
            $config = SystemConfig::where('config_tab_id', $model['id'])->find();
            if ($config) {
                Json::error('存在配置项无法删除');
            }
        });
        return $form;
    }
    public function setting($type, $tabId = 0, Request $request)
    {
        if ($request->isAjax()) {
            foreach ($request->param() as $key => $val) {
                SystemConfig::where('config_tab_id', $tabId)
                    ->where('status', 0)->where('alias', $key)->update(['value' => $val]);
            }
            Json::success('更新配置成功');
        }
        $form = new Form();
        $configTab = SystemConfigTab::where('type', $type)
            ->where('status', 0)->select();
        if(!$configTab->count()){
            Jump::error('该配置分类下无可配置参数','close');
        }
        $title = '';
        foreach ($configTab as $tab) {
            $title .= '<a href="' . url('thans\layuiAdmin\controller\system\ConfigTab@setting', ['tab_id' => $tab['id'], 'type' => $type]) . '"><button type="button" class="layui-btn layui-btn-normal layui-btn-sm">' . $tab['name'] . '</button></a>';
        }
        $tabId = $tabId ? $tabId : $configTab[0]['id'];
        $config = SystemConfig::where('config_tab_id', $tabId)
            ->where('status', 0)
            ->select();
        $form->title($title);
        foreach ($config as $val) {
            $type = $val['type'];
            switch ($type) {
                case 'image':
                    $component = $form->upload()->label($val['name'])->name($val['alias'])->field('image')
                        ->url(url('thans\layuiAdmin\controller\Upload@image'))->tips($val['tips'])->rules($val['rule'])->value($val['value']);
                    break;
                default:
                    $component = $form->$type()->label($val['name'])->name($val['alias'])->tips($val['tips'])->value($val['value'])->rules($val['rule']);
                    break;
            }
            $parameter = explode(PHP_EOL, $val['parameter']);
            if ($val['parameter'] && $parameter) {
                foreach ($parameter as $option) {
                    $option = explode('=>', $option);
                    $component->option($option[0], $option[1], isset($option[2]) ? $option[2] : false);
                }
            }
        }
        $url = url('thans\layuiAdmin\controller\system\ConfigTab@setting', ['tab_id' => $tabId, 'type' => $type]);
        if (AdminsAuth::check($url)) {
            $form->url($url);
        } else {
            $form->hiddenSubmit(true);
        }
        return $form->render();
    }
}
