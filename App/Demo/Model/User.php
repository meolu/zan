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

    public function signUp($userName, $userPass) {
        if (!$userName || !$userPass) {
            return false;
        }
        $exists = $this->userExists($userName);
        if ($exists) {
            return false;
        }
        $userPass = $this->getMd5Pass($userPass);
        $sql = "insert into user(name, pass) values ('{$userName}', '{$userPass}')";
        $table = "user";
        $data  = array('name' => $userName, 'pass' => $userPass);
        return $this->db->insert($table, $data);
    }

    public function login($userName, $userPass) {
        if (!$userName || !$userPass) {
            return false;
        }
        $userPass = $this->getMd5Pass($userPass);
        $sql = "select id from user "
             . "where name = '{$userName}' and pass = '{$userPass}' "
             . "limit 1";
        
        $ret = $this->db->fetchOne($sql);
        if ($ret) {
            $this->setUid($ret['id']);
            return true;
        } else {
            return false;
        }
    }

    public function getUserInfo($uid) {
        $sql = "select * from user where id = {$uid}";
        return $this->db->fetchOne($sql);
    }

    public function setUid($uid) {
        if ($uid) {
            Util\Session::set('login_uid', (int)$uid);
            return true;
        }
        return false;
    }

    public function getUid() {
        return Util\Session::get('login_uid');
    }

    public function userExists($userName) {
        return $this->db->getCount('user', array('name' => $userName));
    }

    public function getMd5Pass($pass) {
        return md5(Demo_Conf_User::PASS_PREFIX . $pass);
    }

}
