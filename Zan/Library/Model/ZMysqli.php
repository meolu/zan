<?php
/* *************************************************************************
 * File Name: Model.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Sun 02 Nov 2014 06:24:26 PM
 * ************************************************************************/
namespace Zan\Library\Model;

class ZMysqli {
    const DB_ACTIVE = 'default';
    protected $db;
    protected $table;
    public function __construct() {
        include ROOT . '/Zan/Conf/database.php';
        $dbConf = $db[self::DB_ACTIVE];
        $this->db = new \mysqli($dbConf['host'], $dbConf['user'], $dbConf['passwd'], $dbConf['database']);
    }
    
    public static function getInstance() {
        static $instance = null;
        if (null == $instance) {
            $instance = new self();
        }
        return $instance;
    }

    public function getArray($sql) {
        $result = [];
        $query = $this->db->query($sql);
        while ($result[] = $query->fetch_assoc());
        return $result;
    }

    public function getCount(array $query = []) {
        $sql = "select count(*) as num from $table where " . join(" AND ", $query);
        if ($result = $this->db->query($sql)) {
            return $result->fetch_assoc()['num'];
        }
        return;
    }

    public function __call($func, $params) {
        if (method_exists($this->db, $func)) {
            call_user_func_array(array($this->db, $func), $params);
        }
    }

}
