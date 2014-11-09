<?php
/* *************************************************************************
 * File Name: File.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Thu 06 Nov 2014 01:46:43 PM
 * ************************************************************************/
namespace Zan\Library\Util;

class FileInfo {
    public function __construct($file) {
        parent::__construct($file);
    }

    public static function getInstance($file) {
        static $_load = [];
        if (!isset($_load[$file])) {
            $_load[$file] = new \SplFileInfo($file);
        }
        return $_load[$file];
    }

    public static function getFiles($source_dir, $include_path = FALSE, $_recursion = FALSE) {
        static $_filedata = array();
        if ($fp = @opendir($source_dir)) {
            // reset the array and make sure $source_dir has a trailing slash on the initial call
            if ($_recursion === FALSE) {
                $_filedata = array();
                $source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
            }
            while (FALSE !== ($file = readdir($fp))) {
                if (is_dir($source_dir.$file) && $file[0] !== '.') {
                    self::getFiles($source_dir.$file.DIRECTORY_SEPARATOR, $include_path, TRUE);
                } elseif ($file[0] !== '.') {
                    $_filedata[] = ($include_path === TRUE) ? $source_dir.$file : $file;
                }
            }
            closedir($fp);
            return $_filedata;
        }
        return FALSE;
    }

    public static function __callStatic($method, $params) {
        if (count($params) < 1) {
            trigger_error("class FileInfo $method params error", E_USER_ERROR);
        }
        $instance = self::getInstance($params[0]);
        if (method_exists($instance, $method)) {
            return $instance->$method();
        }
        trigger_error("class FileInfo $method not exists", E_USER_ERROR);
    }
}
