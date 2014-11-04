<?php
/* *************************************************************************
 * File Name: Model/User.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Thu 23 Oct 2014 03:47:58 PM
 * ************************************************************************/

class Home_Model_User extends Model {

    public function __construct() {
        parent::__construct();
        
        // $this->dbUser = $this->db->selectTable('user');
    }

    function getUserCount() {
        $table = 'user';
        $query = array(
            'userId > 110',
            'gender = 1',
        );
        $intdb = $this->db->getCount($table, $query);
        // $intuser = $this->dbUser->getCount($query);
        var_dump($intdb);
        return $intdb;
    }

}
