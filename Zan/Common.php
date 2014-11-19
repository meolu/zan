<?php
/* *************************************************************************
 * File Name: Common.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Fri 05 Sep 2014 03:16:50 PM
 * ************************************************************************/
namespace Zan;

error_reporting(E_ALL & ~E_NOTICE);
define('DS', DIRECTORY_SEPARATOR);
define('EXT', '.php');
!defined('ROOT') && define('ROOT', dirname(dirname(__FILE__)));
define('APPPATH',  ROOT . '/App/');
define('LIBPATH',  ROOT . '/Zan/Library/');
define('LIBHOOKS', ROOT . '/Zan/Library/Hooks/');
define('LIBURI',   ROOT . '/Zan/Library/Uri/');

date_default_timezone_set('Asia/Shanghai');
session_start();
include ROOT . '/Zan/Zan.php';
spl_autoload_register('Zan\Zan::autoload');

