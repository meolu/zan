<?php
/* *************************************************************************
 * File Name: Demo/Controller/User.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Sun 14 Sep 2014 07:48:36 PM
 * ************************************************************************/
use Zan\Library\Util;
use Zan\Library;


class Demo_Controller_User extends Library\Controller {
    public $model;
    public function __construct() {
        $this->view = new Library\View();
        $this->model = new Demo_Model_User();
    }

    public function signupAction() {
        if (Util\Request::isPost()) {
            $exists = $this->model->userExists(Util\Request::post('user_name'));
            if ($exists) {
                $this->view->set('error_msg', '用户名已经存在，请更换');
            } else {
                $userName = Util\Request::post('user_name');
                $userPass = Util\Request::post('user_pass');
                $ret = $this->model->signUp($userName, $userPass);
                if ($ret) {
                    $this->model->login($userName, $userPass);
                    Util\Http::redirect('/demo/user/info');
                } else {
                    $this->view->set('error_msg', '注册失败');
                }
            }
        }

        $this->view->render(array(
            'action' => '/demo/user/signup',
            'tip'    => '注册',
        ), 'signup.php');
    }

    public function loginAction() {
        if (Util\Request::isPost()) {
            $userName = Util\Request::post('user_name');
            $userPass = Util\Request::post('user_pass');
            $ret = $this->model->login($userName, $userPass);
            if ($ret) {
                Util\Http::redirect('/demo/user/info');
            } else {
                $this->view->set('error_msg', '登录失败，请检查用户名和密码');
            }
        }

        $this->view->render(array(
            'action' => '/demo/user/login',
            'tip'    => '登录'
        ), 'signup.php');
    }

    public function infoAction() {
        $uid = $this->model->getUid();
        if (!$uid) {
            Util\Http::redirect('/demo/user/login');
        }
        $userInfo = $this->model->getUserInfo($uid);
        if (false === $userInfo) {
            $this->view->set('error_msg', '获取用户失败');

        }
        Library\Log::error('xxx');
        Library\Log::warning('xxx');
        Library\Log::notice('notice');
        $this->view->render(array(
            'username' => $userInfo['name'],
        ), 'userinfo.php');
    }
    
}
