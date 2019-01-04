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
    public static $url = '';

    public static $tmpl = 'login';
    // 顶部导航 右侧按钮
    public static $rightNav = '';
    //底部版权信息
    public static $copy = '';
    // logo 信息 支持文字、图片
    public static $logo = '';
    //页面标题
    public static $title = '';
    //页面副标题
    public static $sTitle = '';
    //忘记密码
    public static $forget = '';
    //注册账号
    public static $register = '';
    //记住用户名
    public static $rember = '';
    //底部信息
    public static $footer = '';
    //验证码链接
    public static $captcha = '';
    //验证码表单name
    public static $captchaName = '';
    //登录用户名 laceholder
    public static $loginPlaceholder = '';
    //登录用户名 name
    public static $loginName = '';
    //登录用户的验证规则名称，非常规需要自己添加正则
    public static $loginVerify = 'account';

    //登录密码 laceholder
    public static $pwdPlaceholder = '';
    //登录密码 name
    public static $pwdName = '';

    //登录密码的验证规则名称，非常规需要自己添加正则
    public static $pwdVerify = 'password';

    public static $submit = '登录';

    public function render()
    {
        $this->module('form');
        self::$css['login'] = 'vendor/layui-admin/css/login.css';
        $this->loginScript();
        $this->view->assign('self', $this);
        $this->view->assign('builder', $this);
        return $this->fetch();
    }
    private function loginScript()
    {
        $url = self::$url;
        self::$script[] = <<<EOD
{$this->formVerify}
form.on('submit(login)', function(data){
  admin.ajax('{$url}',data.field);
  return false;
});
EOD;

    }
}
