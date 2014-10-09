<?php
/* *************************************************************************
 * File Name: index.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Fri 05 Sep 2014 03:02:38 PM
 * ************************************************************************/
define('WEBROOT', dirname(__FILE__));
include WEBROOT . "/../Zen/Common.php";
$router = new Uri_Router();
Bootstrap::run($router);

