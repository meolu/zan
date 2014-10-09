<?php
/* *************************************************************************
 * File Name: Controller/User.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Sun 14 Sep 2014 07:48:36 PM
 * ************************************************************************/

class Controller_User extends Controller {

    public static function infoAction() {
        var_dump("App_Controller_User infoAction");
        Log::warning('App_Controller_User infoAction');
        self::render(array(
            'username' => 'wushuiyong',
        ), 'userinfo.php');
    }
}
