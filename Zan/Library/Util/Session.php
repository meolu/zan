<?php
/* *************************************************************************
 * File Name: Session.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Thu 06 Nov 2014 09:53:41 AM
 * ************************************************************************/
namespace Zan\Library\Util;

class Session {

    public static function get($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public static function mset(array $array) {
        if (empty($array)) {
            return false;
        }
        foreach ($array as $key => $val) {
            $_SESSION[$key] = $val;
        }
    }

    public static function delete($name) {
        if (!isset($_SESSION[$name])) {
            return true;
        }
        unset($_SESSION[$name]);
        return true;
    }
    public static function set($name, $value) {
        if (empty($name)) return;
        $_SESSION[$name] = $value;
    }
}
