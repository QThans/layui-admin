<h1 align="center"> layui-admin </h1>

<p align="center"> 针对tp5.1开发的，layui的后台模板。便捷的使用方式，快捷的开发方式，希望能够对你有帮助.</p>

## 版本:1.0 beta

## 说明

测试版，未正式上线。请慎重使用。

文档未完善，readme简单看下，或者看代码。

## 安装方式

```shell
$ composer require thans/layui-admin -vvv
```

## 安装完成后初始化

```php
php think layuiAdmin:install
```

## 使用方式



 - 登录页面：
 
  ![登录页面](https://images.gitee.com/uploads/images/2018/1225/200501_74760169_543050.jpeg "1545739084891.jpg")


    
    use thans\layuiAdmin\Login;

    class IndexController
    {
       public function index()
       {

           $login = new Login();

           return $login->render();
       }
    }
 
 参数：
 
     //模板地址
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
 
     //登录密码 laceholder
     public static $pwdPlaceholder = '';
     //登录密码 name
     public static $pwdName = '';
 
     public static $submit = '登录';
    
 设置方式：
 
    $index->pwdNmae='user_pass';
 等效于：
 
    $index::$pwdName='user_pass';
    
 
 - 后台主页面：

![后台主页面](https://images.gitee.com/uploads/images/2018/1225/215518_c7a9650e_543050.jpeg "11111545746099044.jpg")

    use thans\layuiAdmin\Index;

    class IndexController
    {
       public function index()
       {

           $index = new Index();

           return $index->render();
       }
    }
 
 - 表单
 
 ![表单](https://images.gitee.com/uploads/images/2018/1225/201135_bc4378b6_543050.jpeg "1545739046518.jpg")

        $form = new \thans\layuiAdmin\Form();

        $form->number([
            'name'=>'t'
        ])->label('123')->value('2')->rules('required|phone');
        $form->select([
            'label' => 1,
            'value' => '231',
            'name'=>'t',
            'tips'  => '测试'
        ])->rules('required|phone|pass', [
            'pass'=>['/(.+){6,12}$/', '密码必须6到12位']
        ])->attr('r12', '12jlk')->option('12', '测试')->option('231', '123123213')->relation('/sle/s');
        $form->onoff(['label'=>12])->disabled(true);
        return $form->render();
        
  - 表格
  
    开发中
  
## License

Apache2.0