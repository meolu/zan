<?php
/* *************************************************************************
 * File Name: Common.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Fri 05 Sep 2014 03:16:50 PM
 * ************************************************************************/
define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', dirname(__DIR__));
define('APPPATH', BASEPATH . '/App/');
define('TEMPLATEPATH', BASEPATH . '/App/Template/');
define('LIBPATH', BASEPATH . '/Zen/Library/');
define('LIBHOOKS', LIBPATH . 'Hooks/');
define('LIBURI', LIBPATH . 'Uri/');
define('EXT', '.php');

include __DIR__ . '/Zen.php';
spl_autoload_register('Zen::autoload');
