<?php
/* *************************************************************************
 * File Name: Model.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Sun 02 Nov 2014 06:24:26 PM
 * ************************************************************************/

class Model {
    protected $db;
    protected $table;
    public function __construct($type = 'mongo') {
        $this->db = new Model_Mysqli();
    }

    public static function getInstance($type = 'mysqli') {
        $model = "Model_" . ucwords($type);
        return $model::getInstance();
    }



    public function __call($func, $params) {
        if (method_exists($this->db, $func)) {
            call_user_func_array(array($this->db, $func), $params);
        }
        // trigger_error('')
    }

}
