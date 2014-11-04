<?php
/* *************************************************************************
 * File Name: Library/Hooks/Loader.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Fri 05 Sep 2014 03:21:20 PM
 * ************************************************************************/


class Zan {
    private static $_includePath = [APPPATH, APPPATH, LIBPATH];
    private static $_class2file = [];
    private static $_loaded = [];

    function __construct() {
    }

    public static function load($class, $lib = '', $param = []) {
        self::autoload($class, $lib, $param);
        return self::$_loaded[$class];
    }

    public static function autoload($class, $lib = '', $param = []) {
        $file = isset(self::$_class2file[$class])
              ? self::$_class2file[$class]
              : self::class2file($class);
        if (!$file) {
            $bt = debug_backtrace();
            throw new ZException("can not find class[{$class}], in {$bt[1]['file']}:{$bt[1]['line']}", ZException::NOT_FOUND_CLASS);
        }
        include($file);
    }

    public static function class2file($class) {
        if (isset(self::$_class2file[$class])) {
            return self::$_class2file[$class];
        }
        if (!class_exists($class, false)) {
            $class = str_replace(array('\\', '_'), array(DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR), $class);
            foreach (self::$_includePath as $path) {
                $file = $path . $class . EXT;
                // echo $file," $class<BR>";
                if (file_exists($file)) {
                    // echo $file," $class<BR>";
                    self::$_class2file[$class] = $file;
                    return self::$_class2file[$class];
                }
            }
        }
        return;  
    }

    public static function display50x($message = "服务器君崩溃了:(...") {
        var_dump($message);
        exit(0);
    }

    public static function display40x($message = "你要找的页面君迷路了:(...") {
        var_dump($message);
        exit(0);
    }

}
