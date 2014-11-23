<?php
/* *************************************************************************
 * File Name: index.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Fri 05 Sep 2014 03:02:38 PM
 * ************************************************************************/

define('ROOT', dirname(__FILE__));
include ROOT . "/Zan/Common.php";
// 初始化路由分发
$router = new \Zan\Library\Router();
Zan\Library\Bootstrap::run($router);
