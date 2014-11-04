<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>login</title>
    <link rel="stylesheet" href="/static/css/bootstrap.css">
    <link rel="stylesheet" href="/static/css/blog.css">
    <style>
    .login {margin: 70px auto;width: 700px;    }
    form {width: 250px;    }
    .input-group {margin-bottom: 10px;}
    </style>
</head>
<body>
    <div class="navbar navbar-fixed-top">
      <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
            <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav ml90">
              <li data-slide="1" class="col-xs-4"><a href="/service/login/"  id="menu-link-1"><span class="glyphicon glyphicon-home"></span>博客后台</a></li>
              <li data-slide="2" class="col-xs-4 active"><a href="/vivian/login/" id="menu-link-2"><span class="glyphicon glyphicon-book"></span>vivian后台</a></li>
              <li data-slide="3" class="col-xs-4"><a href="/team/" id="menu-link-3" target="_blank"><span class="glyphicon glyphicon-user"></span>团队</a></li>
            </ul>
          <div class="row">
            <div class="col-xs-4 active-menu"></div>
          </div>
              
          </div>
        </div>
    </div>

    <div class="container login">
      <form class="form-signin" role="form" action="" method="POST">
        <?php if ($err) { ?>
        <div class="alert alert-warning">
          <span href="#" class="alert-link">用户名或密码错误</span>
        </div>
        <?php } ?>
        <h2 class="form-signin-heading"></h2>
        <div class="input-group">
          <span class="input-group-addon">用户名</span>
          <input type="text" name="uname" class="form-control" placeholder="wushuiyong">
        </div>

        <div class="input-group">
          <span class="input-group-addon">密&nbsp;&nbsp;&nbsp;码</span>
          <input type="password" name="passwd" class="form-control" placeholder="******">
        </div>
<!--         <label class="checkbox">
          <input type="checkbox" value="remember-me">记住我
        </label> -->
        <input class="btn btn-lg btn-primary btn-block" type="submit" value="登录">
      </form>
    </div> 
<script src="/static/js/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="/static/js/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="/static/js/script.js" type="text/javascript"></script>
<script>
$(document).ready(function(e) {
  var list = $('.nav > li');
  var url  = location.href;
  var keys = {'service':0, 'vivian':1};
  var k    = 0;
  for (key in keys) {
    if (url.indexOf(key) > 0) {
      k = keys[key];
    }
  }
  menu_focus( list[k], 1 );
});
</script>
</body>
</html>