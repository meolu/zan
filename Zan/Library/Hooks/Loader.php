<?php
/* *************************************************************************
 * File Name: Library/Hooks/Loader.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Fri 05 Sep 2014 03:21:20 PM
 * ************************************************************************/

#namespace Library\Hooks;

class Loader {
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
        if ('Loader' === $class) {
            return;
            self::$_loaded[$class] = new $class;
            return self::$_loaded[$class];
        }
        if (isset($_loaded[$class])) {
            return $_loaded[$class];
        }
        self::$_includePath = [LIBPATH, LIBHOOKS, LIBURI, APPPATH];
        if (!class_exists($class)) {
            foreach (self::$_includePath as $path) {
                $file = $path . $class . EXT;
                    var_dump($file);
                if (file_exists($file)) {
                    include($file);
                    self::$_loaded[$class] = new $class;
                    break;
                }
            }
        }
    }
}
