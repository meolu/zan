<?php
/* *************************************************************************
 * File Name: Log.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Tue 07 Oct 2014 10:57:31 AM
 * ************************************************************************/
namespace Zan\Library;

class Log {
    const DEFAULT_FORMAT = "%s: %s msg:%s [%s:%d] errno[%d] uri[%s] refer[%s] trace[%s]\n";

    static $ERR_LEVEL = array(
        E_NOTICE  => 'log',
        E_WARNING => 'wf',
        E_ERROR   => 'wf',
    );

    public static function notice($msg, $errno = 0, $method = NULL, $param = NULL, $depth = 0) {
        $message = self::format('NOTICE', $msg, $errno, $method, $param, $depth);
        self::_log(E_NOTICE, $message);
    }

    public static function warning($msg, $errno = 0, $method = NULL, $param = NULL, $depth = 0) {
        $message = self::format('WARNING', $msg, $errno, $method, $param, $depth);
        self::_log(E_WARNING, $message);
    }

    public static function error($msg, $errno = 0, $method = NULL, $param = NULL, $depth = 0) {
        $message = self::format('ERROR', $msg, $errno, $method, $param, $depth);
        self::_log(E_ERROR, $message);
    }

    private static function format($errType, $msg, $errno = 0, $method = NULL, $param = NULL, $depth = 0) {
        // for exception
        if (is_a($msg, 'Exception')) {
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
            $errType, date("Y-m-d H:i:s", time()), $msg, $file, $line, $error, $uri, $refer, $trace);
    }

    private static function _log($errLevel, $message) {
        $level = self::$ERR_LEVEL[$errLevel];
        $logDir = sprintf("%s/log/%s", ROOT, APP);
        if (!is_dir($logDir)) {
            if (!mkdir($logDir, 0777, true)) return;
        }
        $logFile = sprintf("%s%s.%s", $logDir, date("YmdH", time()), $level);
        if (!file_exists($logFile) || is_writable($logFile)) {
            file_put_contents($logFile, $message, FILE_APPEND);
        }
    }
}
