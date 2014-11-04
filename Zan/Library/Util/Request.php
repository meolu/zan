<?php
/* *************************************************************************
 * File Name: Request.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Tue 04 Nov 2014 04:33:13 PM
 * ************************************************************************/
namespace Util;

class Request {
    public function __construct() {
    }

    public static function post($key = null) {
        if ($key) {
            return isset($_POST[$key]) ? $_POST[$key] : null;
        }
        return $_POST;
    }

    public static function get($key = null) {
        if ($key) {
            return isset($_GET[$key]) ? $_GET[$key] : null;
        }
        return $_GET;
    }

    public static function request($key = null) {
        static $request = null;
        if (!$request) {
            $request = array_merge($_GET, $_POST);
        $request = self::merge();
        }
        if ($key) {
            return isset($request[$key]) ? $request[$key] : null;
        }
        return $request;
    }
}
