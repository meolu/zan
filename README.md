## zan 简介
[zan 赞] 是一个免费开源的，快速，简单的面向对象的，轻量级PHP微框架。
之所以开发这个框架，不是因为它的性能比Yaf好，也不是因为比ci，tp功能强大，也不是模仿microMVC，lazyPHP用极为简洁的设计，仅仅是因为我想练习设计，它只是一个产出，如果你也喜欢它的设计，或者有优雅的方式，那就一起构建吧。

我对zan的期望是：它是一个只包含了路由分发，尽可能少的基本库（异常，）。始终相信在一个轻快的平台上，总能为有想法的技术人提供更多的可能和精彩。

## 能做什么？
* mvc支持
* 基本工具session,file,requst,
* composer

## 基本要求
* PHP5.3+
* composer(如需要引用其它packagist时)

# zan 实例
基于zan的个人站点 [花满树](http://www.huamanshu.com/)  http://www.huamanshu.com/

# zan 简明教程

使用zan是一件很轻松的事情，它体贴地根据uri(/app/controller/action?)转发到相应的app的controller::action中。你的开发只需要从控制器开始，剩下的交给你了，精彩看你如何自由发挥。

此例会展示在清晰的结构中，使用简单的基础库简洁优雅地实现app，相信你只需要花上5分钟了解这些东西，就能完全得掌握zan。

## 路由分发

当发起请求如：`http://great-compayn/demo/user/login?username=zan&pass=superzan`，先配置一项`nginx`的rewrite规则：

    location / {
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
        if ($request_filename !~* (.html|.js|.css|.swf|.txt|.jpg|.ico|.png|.gif|robots|.php|index.php.*)) {
            rewrite ^/(.*) /index.php/$1 last;
            break;
        }
    }
    
此时zan会找到`App/Demo/Controller/User.php`类，自动加载所需类和配置，并调用`loginAction`的方法。

    App
    └── Demo
        ├── Conf
        │   └── User.php
        ├── Controller
        │   └── User.php
        ├── Model
        │   └── User.php
        └── Template
            ├── signup.php
            └── userinfo.php

zan把这部分工作交由`Zan\Library\Bootstrap`去处理，在找寻`User.php`和确认是否存在`loginAction`的方法过程，如有其一不存在，则返回404；如在执行过程有自定义错误或异常，将返回50x系统错误。

## App 开发

实际上，编写应用的过程就是不断的添加Controller和Action并把它实现。

下边是一个Controller User的样子：

```php
use Zan\Library\Util;
use Zan\Library\Controller;
use Zan\Library\View;

class Demo_Controller_User extends Controller {
    public function __construct() {
        $this->view  = new View();
        $this->model = new Demo_Model_User();
    }
    
    public function loginAction() {
        if (Util\Request::isPost()) {
            $userName = Util\Request::post('user_name');
            $userPass = Util\Request::post('user_pass');
            $ret = $this->model->login($userName, $userPass);
            if ($ret) {
                Util\Http::redirect('/demo/user/info');
            } else {
                $this->view->set('error_msg', '登录失败，请检查用户名和密码');
            }
        }
        
        $this->view->render(array(
            'action' => '/demo/user/login',
            'tip'    => '登录'
        ), 'signup.php');
    }
}
```

在User中，使用了两种自动加载方式，一种是命名空间，另一种是下划线，前者是全局的，后者是在App工作空间内实现快速自动加载（另外个人审美原因）。

## Model

`Demo_Model_User`会自动加载App/Demo/Model/User.php，

```php
use Zan\Library\Util;
use Zan\Library\Model;

class Demo_Model_User extends Model {

    public function __construct() {
        parent::__construct('mysqli');
    }

    public function login($userName, $userPass) {
        if (!$userName || !$userPass) {
            return false;
        }
        $userPass = $this->getMd5Pass($userPass);
        $sql = "select * from user where name = '{$userName}' and pass = '{$userPass}'";
        return $this->db->getOne($sql);
    }
}
```

## view

模板渲染目前实现非常简单，100%原生，没有做任何正则替换。模板赋值有两种方式，`$this->view->set('error_msg', '登录失败，请检查用户名和密码');`；另外一种就是在最后渲染模板`$this->view->render($array, $tpl)`统一赋值。$tpl模板在当前App目前下Template下，即Demo/Template/signup.php

渲染方式：
```php
Zan\Library\View;
...
public function render($array = [], $tpl = null) {
    if (is_array($array) && $tpl) {
        $this->_tpl = APPPATH . APP . '/Template/' . $tpl;
    }
    $this->mset($array);

    if (!file_exists($this->_tpl)) {
        throw new \ZException("can not find tpl[{$this->_tpl}]", E_ERROR);
    }
    ob_start();
    extract($this->_extract);
    include($this->_tpl);
    ob_flush();
}
...
```

可以看到，render接受一个$array数组，然后将数组中的数据extract出来，这样一个原本是$array['tip']的数据在模板里边就能通过$tip访问了。而载入模板部分更简单，只是直接require。这是因为zan直接使用PHP来做模板的解释引擎。Template模板signup.php输出如下

```php
<?php if ($error_msg) : ?>
<label style="color:red"><?= $error_msg ?></label>
<?php endif; ?>
```
