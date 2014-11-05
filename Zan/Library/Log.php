<?php
/* *************************************************************************
 * File Name: Log.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Tue 07 Oct 2014 10:57:31 AM
 * ************************************************************************/
namespace Zan\Library;

class Log {

    public static function warning($message) {
        var_dump('writing Log::warning: '. $message);
    }

    public static function error($message) {
        var_dump('writing Log::error: '. $message);
    }

    public static function logger($level, $message) {
        var_dump('writing Log::warning: '. $message);
    }
}
