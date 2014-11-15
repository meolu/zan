<?php
/* *************************************************************************
 * File Name: Http.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Sun 09 Nov 2014 03:48:10 PM
 * ************************************************************************/
namespace Zan\Library\Util;

class Http {

    public static function redirect($uri, $code = 302) {
        header("HTTP/1.1 {$code} Moved Temporarily");
        header("Location:{$uri}");
    }

    public static function getCurrentUrl() {
        $url = 'http';
        if ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] == 'on') {
            $url .= 's';
        }
        $url .= '://' . $_SERVER['HTTP_HOST'];
        if ($_SERVER['SERVER_PORT'] != 80) {
            $url .= ':' . $_SERVER['SERVER_PORT'];
        }
        $url .= $_SERVER['SCRIPT_NAME'];
        return $url;
    }
}
