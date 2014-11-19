<?php
/* *************************************************************************
 * File Name: Mongo.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Mon 03 Nov 2014 11:00:03 AM
 * ************************************************************************/
namespace Zan\Library\Model;

class Mongo {
    const DB_ACTIVE = 'mongo';
    public function __construct() {
        include ROOT . '/Zan/Conf/database.php';
        if (!isset($db[self::DB_ACTIVE])) {
            exit('can not find db conf');
        }
        $conf = $db[self::DB_ACTIVE];
        $host = 'mongodb://'
              . $conf['user'] ? $conf['user'] : ''
              . $conf['passwd'] ? (':' . $conf['user']) : ''
              . '@' . $conf['host']
              . $conf['database'] ? '/' . $conf['database'] : '';
        $this->db = new \MongoClient($host);
    }

    public function __call($method, $params) {
        if (method_exists($this->db, $method)) {
            call_user_func_array(array($this->db, $method), $params);
        }
    }
}
