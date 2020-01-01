/**
 * plupload上传封装
 * 整理：ITCCP.CN 龚申展
 * Date：2018年8月13日21:28:33
 * Date:
 */
layui.define('layer', function (exports) {
    var $ = layui.jquery;
    var upload;
    var obj = {
        //options 参数
        loader: function (options, callback) {
            //引用下载js
            $.getScript(layui.cache.base + "plupload/plupload.full.min.js", function () {
                if (!options.url) {
                    layer.msg('初始化参数：上传地址不能为空.', {icon: 2});
                    return;
                }
                upload = new plupload.Uploader({
                    runtimes: 'html5,flash,silverlight,html4', //设置运行环境，会按设置的顺序，可以选择的值有html5,gears,flash,silverlight,browserplus,html
                    flash_swf_url: layui.cache.base + 'plupload/Moxie.swf',
                    silverlight_xap_url: layui.cache.base + 'plupload/Moxie.xap',
                    url: options.url, //上传文件路径
                    max_file_size: options.max_file_size || '1tb', //100b, 10kb, 10mb, 1gb, 1tb
                    chunk_size: options.chunk_size || '1000mb', //分块大小，小于这个大小的不分块
                    unique_names: options.unique_names || true, //生成唯一文件名
                    browse_button: options.browse_button || 'plupload',
                    multi_selection: options.multi_selection || true, //是否可以选择多个，true为可以
                    multipart_params: options.multipart_params || {}, //参数
                    filters: options.filters || [],
                    init: {
                        FilesAdded: function (uploader, files) {
                            if (typeof options.FilesAdded === 'function') {
                                options.FilesAdded(uploader, files);
                            } else {
                                uploader.start();
                            }
                            return false;
                        },
                        FileUploaded: function (uploader, file, info) {
                            //文件上传完毕触发
                            if (typeof options.FileUploaded === 'function') {
                                options.FileUploaded(uploader, file, info);
                            }
                        },
                        UploadComplete: function (uploader, files) {
                            //console.log("所有文件上传完毕");
                            if (typeof options.UploadComplete === 'function') {
                                options.UploadComplete(uploader, files);
                            }
                        },
                        UploadProgress: function (uploader, file) {
                            // console.log("上传进度为：" + file.percent + "%");
                            // console.log(file);
                            if (typeof options.UploadProgress === 'function') {
                                options.UploadProgress(uploader, file);
                            }
                        },
                        //当发生错误时触发监听函数
                        Error: function (up, err) {
                            if (typeof options.Error === 'function') {
                                options.Error(up, err);
                            } else if (err.code == -600) {
                                layer.open({
                                    title: '上传错误',
                                    content: '选择的文件太大了，最大不能超过' + (options.max_file_size || '1tb'),
                                    icon: 2
                                });
                            } else if (err.code == -601) {
                                layer.open({
                                    title: '上传错误',
                                    content: '选择的文件后缀不对',
                                    icon: 2
                                });
                            } else if (err.code == -602) {
                                layer.open({
                                    title: '上传错误',
                                    content: '请勿重复上传同一个文件',
                                    icon: 2
                                });
                            } else {
                                alert("\nError xml:" + err.response, "");
                            }
                        }
                    }
                });
                $.getScript(layui.cache.base + "plupload/i18n/zh_CN.js");

                if (options.container) {
                    //container用来指定Plupload所创建的html结构的父容器，默认为前面指定的browse_button的父元素。该参数的值可以是一个元素的id,也可以是DOM元素本身。
                    upload.setOption("container", options.container); //按钮容器，可以为ID或者DOM(document.getElementById)
                }
                if (options.drop_element) {
                    //指定了使用拖拽方式来选择上传文件时的拖拽区域，即可以把文件拖拽到这个区域的方式来选择文件。该参数的值可以为一个DOM元素的id,也可是 DOM元素本身，还可以是一个包括多个DOM元素的数组。如果不设置该参数则拖拽上传功能不可用。目前只有html5上传方式才支持拖拽上传。
                    upload.setOption("drop_element", options.drop_element); //拖拽容器，可以为ID或者DOM(document.getElementById)
                }
                if (typeof callback === 'function') {
                    callback(upload)
                } else {
                    upload.init();
                }
            });
        },
        setOption: function (key, val) {
            upload.setOption(key, val);
        },
        previewImage: function (file, callback) {
            if (!file || !/image\//.test(file.type)) return; //确保文件是图片
            if (file.type == 'image/gif') { //gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
                var gif = new moxie.file.FileReader();
                gif.onload = function () {
                    callback(gif.result);
                    gif.destroy();
                    gif = null;
                };
                gif.readAsDataURL(file.getSource());
            } else {
                var image = new moxie.image.Image();
                image.onload = function () {
                    image.downsize(150, 150); //先压缩一下要预览的图片,宽300，高300
                    var imgsrc = image.type == 'image/jpeg' ? image.getAsDataURL('image/jpeg', 80) : image.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                    console.log(imgsrc);
                    callback && callback(imgsrc); //callback传入的参数为预览图片的url
                    image.destroy();
                    image = null;
                };
                image.load(file.getSource());
            }
        }
    };
    exports('plupload', obj);
});