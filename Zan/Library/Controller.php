<?php
/* *************************************************************************
 * File Name: Controller.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Tue 07 Oct 2014 09:44:23 PM
 * ************************************************************************/

class Controller {

    protected static $TPL;

    public static function init($app) {
        self::$TPL = APPPATH . $app . '/Template/';
    }
    public static function render(array $field, $template) {
        ob_start();
        extract($field);
        include(self::$TPL . $template);
        ob_flush();
    }

}
