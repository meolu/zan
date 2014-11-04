<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>upload picture</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="/static/js/jquery.uploadify.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/static/css/uploadify.css">
<style type="text/css">
body {
	font: 13px Arial, Helvetica, Sans-serif;
}
</style>
</head>

<body>
	<h1>Uploadify Demo</h1>
	<form>
		<div id="queue"></div>
		<input id="file_upload" name="file_upload" type="file" multiple="true">
	</form>

	<script type="text/javascript">
		$(function() {
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
		            console.log('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
		        }
			});
		});

	</script>
</body>
</html>