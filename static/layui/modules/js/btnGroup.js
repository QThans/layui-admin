/*
 * @Author: Thans
 * @Date:   2018-09-15 15:28:30
 * @Last Modified by:   Thans
 * @Last Modified time: 2018-09-15 22:33:50
 */
/**
 * plupload上传封装
 * 整理自：ITCCP.CN 龚申展
 * Date：2018年8月13日21:28:33
 * Date:
 */
layui.define([], function (exports) {
    var $ = layui.jquery;
    var obj = {
        //options 参数
        loader: function (options, callback) {
            var browse_button = options.browse_button || 'downpanel';
            var name = $("#" + browse_button).attr('data-name');
            $("#" + browse_button).css('padding', '0');
            $("#" + browse_button).addClass('layui-unselect layui-form-select');
            $("#" + browse_button).html('<div class="layui-select-title" style="padding-right: 30px;padding-left: 10px;">' + name + ' <i style="border-top-color: #fff;" class="layui-edge"></i>' + '</div><dl class="layui-anim layui-anim-upbit ' + browse_button + 'btnGroupDl"></dl>');
            $.each(options.btn, function (key, val) {
                $('.' + browse_button + 'btnGroupDl').append('<dd class="' + browse_button + 'dd" style="color: #000;top: 30px;font-size: 14px;" data-id="' + val.id + '" ><i class="layui-icon ' + val.icon + '"></i> ' + val.name + '</dd>');
            })
            $("#" + browse_button).on("click", ".layui-select-title", function (e) {
                $(".layui-form-select").not($(this).parents(".layui-form-select")).removeClass("layui-form-selected");
                $(this).parents(".layui-form-select").toggleClass("layui-form-selected");
                e.stopPropagation();
            });
            $('.' + browse_button + 'btnGroupDl').on("click", '.' + browse_button + 'dd', function (e) {
                callback($(this).attr('data-id'));
                $(".layui-form-select").not($(this).parents(".layui-form-select")).removeClass("layui-form-selected");
                $(this).parents(".layui-form-select").toggleClass("layui-form-selected");
            });
            $('.' + browse_button + 'btnGroupDl').css('max-height', document.body.offsetHeight - 82);
        },
        add: function (options, val) {
            var browse_button = options.browse_button || 'downpanel';
            val.icon = val.icon || '';
            $('.' + browse_button + 'btnGroupDl').append('<dd class="' + browse_button + 'dd" style="color: #000;top: 30px;font-size: 14px;" data-id="' + val.id + '" ><i class="layui-icon ' + val.icon + '"></i> ' + val.name + '</dd>');
        },
        del: function (options, id) {
            var browse_button = options.browse_button || 'downpanel';
            $('.' + browse_button + 'dd[data-id="' + id + '"]').remove();
        },
        edit: function (options, val) {

        }
    };
    exports('btnGroup', obj);
});