<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin;

use Closure;
use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\Traits\Load;
use think\Exception;
use think\facade\Request;

class Form
{
    use Load;

    public $tmpl = 'form';

    public $url = '';

    public $id = '';

    public $model;

    public $validate;

    public $validateScene = false;

    private $relations = [];

    private $beforeRead = [];

    private $beforeUpdate = [];

    private $afterSave = [];

    private $afterUpdate = [];

    private $beforeSave = [];

    private $beforeDestroy = [];

    public $method = 'post';

    public $data = [];

    public $dataUrl = '';

    public $dataMethod = 'get';

    public $rules = [];

    public $submitBtn = '保存';

    public $hiddenSubmit = false;

    public $setValueScript = [];

    //请求成功状态码
    public $successStatusCode = 0;

    //请求成功后脚本  null 或  continue 或 msg 或者 refresh
    public $successEndScript = 'continue';

    //提交前脚本
    public $submitStartSctipt = [];

    //提交结束后脚本
    public $submitEndSctipt = [];

    public $classMap
        = [
            'input'       => form\Input::class,
            'text'        => form\Text::class,
            'textarea'    => form\Textarea::class,
            'number'      => form\Number::class,
            'select'      => form\Select::class,
            'multiSelect' => form\MultiSelect::class,
            'onoff'       => form\Onoff::class,
            'checkbox'    => form\Checkbox::class,
            'authtree'    => form\Authtree::class,
            'richtext'    => form\Richtext::class,
            'upload'      => form\Upload::class,
            'icon'        => form\Icon::class,
            'date'        => form\Date::class,
        ];

    public $formVerify
        = [
            'account'  => [
                'reg'  => '/^[a-zA-Z\u4e00-\u9fa5][a-zA-Z0-9_\u4e00-\u9fa5]{4,50}$/',
                'tips' => '管理员名必须5到50位，不能以数字开头',
            ],
            'password' => [
                'reg'  => '/^[\S]{6,24}$/',
                'tips' => '密码必须6到24位，且不能出现空格',
            ],
            'mobile'   => [
                'reg'  => '/^1\d{10}$/',
                'tips' => '请输入正确的手机号',
            ],
            'email'    => [
                'reg'  => '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
                'tips' => '请输入正确的邮箱',
            ],
            'required' => [
                'reg'  => '/[\S]+/',
                'tips' => '必填项不能为空',
            ],
            'url'      => [
                'reg'  => '/(^#)|(^http(s*):\/\/[^\s]+\.[^\s]+)/',
                'tips' => '网址格式不正确',
            ],
            'date'     => [
                'reg'  => '/^(\d{4})[-\/](\d{1}|0\d{1}|1[0-2])([-\/](\d{1}|0\d{1}|[1-2][0-9]|3[0-1]))*$/',
                'tips' => '日期格式不正确',
            ],
            'number'   => [
                'reg'  => '/^[0-9]+.?[0-9]*$/',
                'tips' => '请输入数字',
            ],
            'identity' => [
                'reg'  => '/(^\d{15}$)|(^\d{17}(x|X|\d)$)/',
                'tips' => '请输入正确的身份证号',
            ],
        ];

    final public function setValueScript($key, $value)
    {
        $this->setValueScript[$key] = $value;
    }

    final public function submitStartSctipt($key, $value)
    {
        $this->submitStartSctipt[$key] = $value;
    }

    final public function submitEndSctipt($key, $value)
    {
        $this->submitEndSctipt[$key] = $value;
    }

    public function data($data = [])
    {
        $this->data = $data;

        return $this;
    }

    public function edit($id, $method = 'PUT')
    {
        $model        = $this->model->with($this->relations)->find($id);
        $this->data   = $model;
        $this->method = $method;
        $this->callReading();

        return $this;
    }

    public function relation($relation)
    {
        $this->relations[] = $relation;
    }

    public function beforeRead(Closure $callback = null)
    {
        $this->beforeRead[] = $callback;
    }

    protected function callReading()
    {
        foreach ($this->beforeRead as $func) {
            if ($func instanceof Closure) {
                return call_user_func($func, $this);
            }
        }
    }

    public function beforeUpdate(Closure $callback = null)
    {
        $this->beforeUpdate[] = $callback;
    }

    protected function callUpdating($model, $data)
    {
        foreach ($this->beforeUpdate as $func) {
            if ($func instanceof Closure) {
                return call_user_func($func, $this, $model, $data);
            }
        }
    }

    public function beforeSave(Closure $callback = null)
    {
        $this->beforeSave[] = $callback;
    }

    protected function callSaving($data)
    {
        foreach ($this->beforeSave as $func) {
            if ($func instanceof Closure) {
                return call_user_func($func, $this, $data);
            }
        }
    }

    public function afterSave(Closure $callback = null)
    {
        $this->afterSave[] = $callback;
    }

    protected function callSaved($data)
    {
        foreach ($this->afterSave as $func) {
            if ($func instanceof Closure) {
                return call_user_func($func, $this, $data);
            }
        }
    }

    public function afterUpdate(Closure $callback = null)
    {
        $this->afterUpdate[] = $callback;
    }

    protected function callUpdated($model, $data)
    {
        foreach ($this->afterUpdate as $func) {
            if ($func instanceof Closure) {
                return call_user_func($func, $this, $model, $data);
            }
        }
    }

    public function beforeDestroy(Closure $callback = null)
    {
        $this->beforeDestroy[] = $callback;
    }

    protected function callDestroying($model)
    {
        foreach ($this->beforeDestroy as $func) {
            if ($func instanceof Closure) {
                return call_user_func($func, $this, $model);
            }
        }
    }

    public function destroy($id)
    {
        $model = $this->model->find($id);
        $this->callDestroying($model);
        if ($model->delete()) {
            Json::success('删除成功');
        } else {
            Json::error('删除失败');
        }
    }

    public function update($id, $data = null)
    {
        $data = $data ?? Request::param();

        try {
            if ($this->validate) {
                $this->validateScene ? $this->validate = $this->validate->scene('update') : null;
                if (! $this->validate->check($data)) {
                    Json::error($this->validate->getError());
                }
            }
            $model = $this->model->find($id);
            $this->callUpdating($model, $data);
            $model->save($data);
            $this->callUpdated($model, $data);
            Json::success('更新成功');
        } catch (Exception $e) {
            Json::error($e->getMessage(), 500);
        }
    }

    public function save($data = null)
    {
        $data = $data ?? Request::param();

        try {
            if ($this->validate) {
                $this->validateScene ? $this->validate = $this->validate->scene('save') : null;
                if (! $this->validate->check($data)) {
                    Json::error($this->validate->getError());
                }
            }
            $this->callSaving($data);
            $this->model->save($data);
            $this->callSaved($data);
            Json::success('保存成功');
        } catch (Exception $e) {
            Json::error($e->getMessage(), 500);
        }
    }

    public function end()
    {
        $code = $this->display(
            __DIR__.DIRECTORY_SEPARATOR.'form'
            .DIRECTORY_SEPARATOR.'stub'.DIRECTORY_SEPARATOR
            .'form.js.stub'
        );
        $this->builder->script('form'.$this->id, $code);
    }

    public function __construct(
        $model = '',
        $validate = '',
        $validateScene = false
    ) {
        $this->model         = $model;
        $this->validate      = $validate;
        $this->validateScene = $validateScene;
        $this->builder       = new Builder(DIRECTORY_SEPARATOR.$this->tmpl);
        $this->id            = uniqid();
        $this->builder->module('form');
        $this->builder->module('jquery');
    }
}
