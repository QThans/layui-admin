
<h1><p align="center">layui-admin</p></h1>
<p align="center"> 基于thinkphp的后台管理系统。</p>

<p align="center">
<a target="_blank" href="https://www.kancloud.cn/sanshinet/layui-admin">开发文档[拟写中]</a>
<a target="_blank" href="http://demo.layuiadmin.com/admin/login.html">DEMO[备案中]</a>
</p>

## 特性

1. 基于tp5.1
2. 基于layui前端框架
3. 内置用户和权限管理
4. Form类快速构建表单
5. 包含多种表单组件
6. Table类快速构建列表

## 安装方式
第一步：
```shell
$ composer create-project topthink/think tp5 && cd tp5

```
第二步：
```shell
$ composer require thans/layui-admin
```
第三步：

```shell
$ php think layuiAdmin:install
```
第四步：

> 先配置好数据库
```shell
$ php think migrate:run
```

安装完成。访问：http://hostname/admin/login.html

## 包含组件：

* 富文本编辑框【ckeditor4】
* 文本输入框
* 数字输入框
* TextArea输入框
* 单[多]文件[图片]上传
* 开关
* 下拉单选
* 下拉多选
* checkbox
* 权限树
* ICON选择器
* 日期选择，支持多种格式。支持范围。

## 界面预览

> 登录界面
![login](http://files.git.oschina.net/group1/M00/07/9B/PaAvDFzSe7CAG2EaAALjwC3zdtE362.png?token=ec0705afbe71e1f57b4c1120ca3a26b7&ts=1557298098&attname=%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-05-08%2014.47.20.png&disposition=inline)

> 菜单管理
![menu](http://files.git.oschina.net/group1/M00/07/9B/PaAvDFzSe56AU3vKAAZmKPfufgg295.png?token=3d5d24669df98ec624af121fcdaf5fb0&ts=1557298098&attname=%E5%B1%8F%E5%B9%95%E5%BF%AB%E7%85%A7%202019-05-08%2014.47.03.png&disposition=inline)

## License

Apache2.0
