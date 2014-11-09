<?php
/* *************************************************************************
 * File Name: Request.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Tue 04 Nov 2014 04:33:13 PM
 * ************************************************************************/
namespace Zan\Library\Util;

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

    public static function isPost($key = null) {
        return 'POST' === $_SERVER['REQUEST_METHOD'];
    }

    public static function server($key = null) {
        if ($key) {
            return isset($_SERVER[$key]) ? $_SERVER[$key] : null;
        }
        return $_SERVER;
    }

    public static function request($key = null) {
        static $request = null;
        if (!$request) {
            $request = array_merge($_GET, $_POST);
        }
        if ($key) {
            return isset($request[$key]) ? $request[$key] : null;
        }
        return $request;
    }
}
