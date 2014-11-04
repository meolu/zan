<?php
/* *************************************************************************
 * File Name: Controller/User.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Sun 14 Sep 2014 07:48:36 PM
 * ************************************************************************/

class Home_Controller_User extends Controller {
    public $model;
    public function __construct() {
    }

    public function InfoAction() {
        $this->model = new Home_Model_User();
        var_dump("App_Controller_User infoAction");

        self::render(array(
            'username' => 'wushuiyong',
            'db'       => $this->model->getUserCount(),
        ), 'userinfo.php');
    }
}
