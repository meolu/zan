<?php
/* *************************************************************************
 * File Name: Library/Hooks/Loader.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Fri 05 Sep 2014 03:21:20 PM
 * ************************************************************************/


class Zan {
    private static $_includePath = [];
    private static $_instance = [];
    private static $_loaded = [];

    function __construct() {
    }

    public static function load($class, $lib = '', $param = []) {
        self::autoload($class, $lib, $param);
        return self::$_loaded[$class];
    }

    public static function autoload($class, $lib = '', $param = []) {
        #debug_print_backtrace();
        if (isset($_loaded[$class])) {
            return $_loaded[$class];
        }
        self::$_includePath = [LIBPATH, APPPATH];
        if (!class_exists($class)) {
            foreach (self::$_includePath as $path) {
                $file = $path . str_replace('_', DIRECTORY_SEPARATOR, $class) . EXT;
     #               echo $file," $class<BR>";
                if (file_exists($file)) {
     #               echo $file," $class<BR>";
                    include($file);
                    self::$_loaded[$class] = new $class();
                    break;
                }
            }
        }
    }
}
