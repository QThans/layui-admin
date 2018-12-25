(function () {
    CKEDITOR.plugins.add('imageupload', {
        init: function (editor) {
            editor.addCommand("imageupload", new CKEDITOR.dialogCommand("imageupload"));
            editor.ui.addButton('simpleupload', {
                label: '添加图片',  //鼠标悬停在插件上时显示的名字
                command: 'imageupload',
                toolbar: 'basicstyles,1',
                icon:'plugins/imageupload/images/upload.png',
            });
            CKEDITOR.dialog.add("imageupload", this.path + "dialogs/imageupload.js")
        }
    });
})();