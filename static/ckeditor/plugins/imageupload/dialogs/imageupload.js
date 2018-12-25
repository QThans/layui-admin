(function() {
    CKEDITOR.dialog.add("imageupload",
        function(a) {
            var timestamp = (new Date()).getTime();
            return {
                title: "图片上传",
                minWidth: "1000px",
                minHeight: "1000px",
                contents: [{
                    id: "tab1",
                    label: "",
                    title: "",
                    expand: true,
                    width: "1000px",
                    height: "1000px",
                    padding: 0,
                    elements: [{
                        type: "html",
                        style: "width:800px;height:400px",
                        html: "<iframe id='imageupload-ckeditor-" + timestamp + "' width='100%' height='100%' src='" + "/admin/uploadImage?nobtn=1&full=1" + "'></iframe>"
                    }]
                }],
                onOk: function() {
                    //点击确定按钮后的操作
                    var choose = document.getElementById('imageupload-ckeditor-' + timestamp).contentDocument.get_all_choose();
                    for (var i = 0; i < choose.length; i++) {
                        a.insertHtml("<img src='" + choose[i] + "' />");
                    }
                },
                onHide: function() {
                    document.getElementById('imageupload-ckeditor-' + timestamp).contentDocument.location.reload();
                },
            }
        })

})();