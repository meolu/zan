<?php
/* *************************************************************************
 * File Name: Common.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Fri 05 Sep 2014 03:16:50 PM
 * ************************************************************************/
define('DS', DIRECTORY_SEPARATOR);
define('EXT', '.php');
define('APPPATH',  ROOT . '/App/');
define('LIBPATH',  ROOT . '/Zan/Library/');
define('LIBHOOKS', ROOT . '/Zan/Library/Hooks/');
define('LIBURI',   ROOT . '/Zan/Library/Uri/');

include ROOT . '/Zan/Zan.php';
spl_autoload_register('Zan::autoload');

