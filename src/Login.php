<?php
/**
 * Created by PhpStorm.
 * User: Thans
 * Date: 2018/12/25
 * Time: 17:07
 */

namespace thans\layuiAdmin;

use thans\layuiAdmin\Traits\Compoents;

class Login extends Builder
{
    use Compoents;

    //登录ajax提交url
    public $url = '';

    public $tmpl = 'login';
    // 顶部导航 右侧按钮
    public $rightNav = '';
    //底部版权信息
    public $copy = '';
    // logo 信息 支持文字、图片
    public $logo = '';
    //页面标题
    public $title = '';
    //页面副标题
    public $sTitle = '';
    //忘记密码
    public $forget = '';
    //注册账号
    public $register = '';
    //记住用户名
    public $rember = '';
    //底部信息
    public $footer = '';
    //验证码链接
    public $captcha = '';
    //验证码表单name
    public $captchaName = '';
    //登录用户名 laceholder
    public $loginPlaceholder = '';
    //登录用户名 name
    public $loginName = '';
    //登录用户的验证规则名称，非常规需要自己添加正则
    public $loginVerify = 'account';

    //登录密码 laceholder
    public $pwdPlaceholder = '';
    //登录密码 name
    public $pwdName = '';

    //登录密码的验证规则名称，非常规需要自己添加正则
    public $pwdVerify = 'password';

    public $submit = '登录';

    public function render()
    {
        $this->module('form');
        $this->css['login'] = 'vendor/layui-admin/css/login.css';
        $this->loginScript();
        $this->view->assign('self', $this);
        $this->view->assign('builder', $this);
        return $this->fetch();
    }
    private function loginScript()
    {
        $url = $this->url;
        $this->script[] = <<<EOD
{$this->formVerify}
form.on('submit(login)', function(data){
  admin.ajax('{$url}',data.field);
  return false;
});
EOD;

    }
}
