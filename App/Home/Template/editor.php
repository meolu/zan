<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Editor</title>
    <link href="/static/css/editor.css" rel="stylesheet" type="text/css" />
    <link href="/static/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/static/css/uploadify.css">
</head>
<body>

<div id="main">

    <div id="preview" >
    <!-- <div id="preview" data-bind="visible: show_preview"> -->
        <!-- <a target="_blank" data-bind="attr: {href: preview_url}, event:{mouseover: sync}"><i class="icon-eye-open"></i> 浏览</a> -->
    </div>
    <div id="controls">
        <div class="cmds">
            <a href="#" title="上一页" data-bind="click: prev">
                <i class="icon-arrow-left"></i>
            </a>
            <a href="#" title="在线编译" data-bind="click: compile">
                <i class="icon-cloud"></i>
            </a>

            <a href="#" title="新增文件" data-bind="click: create">
                <i class="icon-plus"></i>
            </a>
            <a href="#" title="下一页" data-bind="click: next">
                <i class="icon-arrow-right"></i>
            </a>
        </div>

        <ul id="posts" data-bind="foreach: blogs" class="posts">
            <li>
            <a href="#" data-bind="click: $parent.load">
                <span data-bind="text: title"></span>
                <span data-bind="text: blog_id" style="display:none"></span>
            </a>

            </li>
        </ul>
    </div>

    <div id="editor">
      <textarea  id="textarea" data-bind="text: editor, event:{keyup: sync}, enable: true"></textarea>
      <form>
        <div id="queue"></div>
        <input id="file_upload" class="upload" name="file_upload" type="file" multiple="true">
      </form>
    </div>

</div>
<script type="text/javascript" src="http://resource.farbox.com/lib/jquery/1.8.1-jquery.min.js"></script>
<script type="text/javascript" src="/static/js/knockout-2.2.1.js"></script>
<script src="/static/js/jquery.uploadify.js" type="text/javascript"></script>
<script type="text/javascript" src="/static/js/editor-v2.js"></script>
<script>
function initPicUpload() {
    $('#file_upload').uploadify({
        'formData'     : {
            'timestamp' : '<?= $timestamp; ?>',
            'token'     : '<?= $token ?>'
        },
        'swf'      : '/static/images/uploadify.swf',
        'uploader' : '<?= $uploader ?>',
        'onSelect': function(file) {  
            console.log(file.name+"---"+file.id);  
        },// 选择文件时触发的方法 
        
        'onUploadError' : function(file, errorCode, errorMsg, errorString) {
            console.log('The file ' + file.name + ' could not be uploaded: ' + errorString);
        },//上传出错后的方法
        
        'onUploadSuccess' : function(file, data, response) {
            console.log(file.name + response + ':' + data);
            var append = sprintf("![](%s)", data)
            var editor = $("#textarea");
            editor.val(editor.val() + "\n" + append);
        }
    });
}
$(function() {
    initPicUpload();
});
</script>
</body>
</html>
