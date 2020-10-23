
<h1><p align="center">layui-admin</p></h1>
<p align="center"> 【thinkphp6.0】基于thinkphp的后台管理系统。</p>

<p align="center">
<a target="_blank" href="https://www.kancloud.cn/sanshinet/layui-admin/">开发文档</a>
<a target="_blank" href="http://demo.layuiadmin.com/admin/login.html">DEMO[备案中]</a>
</p>

## 特性

1. 基于tp6.0
2. 基于layui前端框架
3. 内置用户和权限管理
4. Form类快速构建表单
5. 包含多种表单组件
6. Table类快速构建列表
7. 轻松管理配置项

## Requirement

1. php >= 7.1
2. thinkphp >=6.0.0
3. Linux

## Installation
第一步：安装TP
```shell
$ composer create-project topthink/think tp && cd tp

```
第二步：安装本框架
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

## Commands

将密码重置为123456

```shell
$ php think layuiAdmin:repwd -p 123456
```

将密码随机重置

```shell
$ php think layuiAdmin:repwd
```
## Compoents

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

## Demo

> 界面预览
![login](https://uinge.oss-cn-beijing.aliyuncs.com/Screen%20Shot%202019-08-01%20at%2010.49.20.png)
![form](https://uinge.oss-cn-beijing.aliyuncs.com/Screen%20Shot%202019-08-01%20at%2010.48.01.png)
![list](https://uinge.oss-cn-beijing.aliyuncs.com/Screen%20Shot%202019-08-01%20at%2010.47.48.png)
![console](https://uinge.oss-cn-beijing.aliyuncs.com/Screen%20Shot%202019-08-01%20at%2010.47.39.png)
## License

MIT
