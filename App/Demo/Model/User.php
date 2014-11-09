<?php
/* *************************************************************************
 * File Name: Demo/Model/User.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Thu 23 Oct 2014 03:47:58 PM
 * ************************************************************************/
use Zan\Library\Util;
use Zan\Library\Model;

class Demo_Model_User extends Model {

    public function __construct() {
        parent::__construct('mysqli');
    }

    public function signUp() {
        $userName = Util\Request::post('user_name');
        $userPass = Util\Request::post('user_pass');
        if (!$userName || !$userPass) {
            return false;
        }
        $userPass = $this->getMd5Pass($userPass);
        $sql = "insert into user(name, pass) values ('{$userName}', '{$userPass}')";
        return $this->db->query($sql);
    }

    public function login() {
        $userName = Util\Request::post('user_name');
        $userPass = Util\Request::post('user_pass');
        if (!$userName || !$userPass) {
            return false;
        }
        $userPass = $this->getMd5Pass($userPass);
        $sql = "select * from user where name = '{$userName}' and pass = '{$userPass}'";
        return $this->db->getOne($sql);
    }

    public function getUserInfo($uid) {
        $sql = "select * from user where uid = {$uid}";
        return $this->db->getOne($sql);

    }

    public function setUid($userName) {
        $sql = "select uid from user where name = '{$userName}'";
        $ret = $this->db->getOne($sql);
        if ($ret) {
            $uid = $ret['uid'];  
            Util\Session::set('login_uid', $uid);
            return true;
        }
        return false;
    }

    public function getUid() {
        return Util\Session::get('login_uid');
    }
    public function userExists($userName) {
        $sql = "select uid from user where name = '{$userName}'";
        return $this->db->getOne($sql);
    }

    public function getMd5Pass($pass) {
        return md5(Demo_Conf_User::PASS_PREFIX . $pass);
    }

}
