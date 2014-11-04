<?php
/* *************************************************************************
 * File Name: Controller.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Tue 07 Oct 2014 09:44:23 PM
 * ************************************************************************/

class Controller {


    public static function init() {
    }

    public function render(array $field, $template) {
        $tpl = APPPATH . APP . '/Template/' . $template;
        if (!file_exists($tpl)) {
            throw new ZException('can not find tpl[{$tpl}]', E_ERROR);
        }
        ob_start();
        extract($field);
        include(APPPATH . APP . '/Template/' . $template);
        ob_flush();
    }

}
