<?php
/* *************************************************************************
 * File Name: Log.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Tue 07 Oct 2014 10:57:31 AM
 * ************************************************************************/
namespace Zan\Library;
// use Zan;

class Log {
    const DEFAULT_FORMAT = "%s msg:%s [%s:%d] errno[%d] uri[%s] refer[%s] trace[%s]\n";
    static $ERR_LEVEL = array(
        E_ERROR   => 'error',
        E_WARNING => 'warning',
    );

    public static function warning($msg, $errno = 0, $method = NULL, $param = NULL, $depth = 0) {
        $message = self::format($msg, $errno, $method, $param, $depth);
        self::_log(self::$ERR_LEVEL[E_ERROR], $message);
    }

    public static function error($msg, $errno = 0, $method = NULL, $param = NULL, $depth = 0) {
        $message = self::format($msg, $errno, $method, $param, $depth);
        self::_log(self::$ERR_LEVEL[E_ERROR], $message);
    }

    private static function format($msg, $errno = 0, $method = NULL, $param = NULL, $depth = 0) {
        // for exception
        if ($msg instanceof Exception || !is_string($msg)) {
            $trace = $msg->getTraceAsString();
            $file = $msg->getFile();
            $line = $msg->getLine();
            $msg  = $msg->getMessage();
        } else {
        // normal write log
            $bt = debug_backtrace();
            $file = $bt[$depth+1]['file'];
            $line = $bt[$depth+1]['line'];
            $trace = '';
        }
        $uri  = $_SERVER['REQUEST_URI'];
        $refer = $_SERVER['HTTP_REFERER'];
        return sprintf(self::DEFAULT_FORMAT, 
            date("Y-m-d H:i:s", time()), $msg, $file, $line, $error, $uri, $refer, $trace);
    }

    private static function _log($level, $message) {
        $file = sprintf("%s/log/%s%s.%s", ROOT, APP, date("YmdH", time()), $level);
        file_put_contents($file, $message, FILE_APPEND);
    }
}
