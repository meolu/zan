<?php
/* *************************************************************************
 * File Name: Mongo.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Mon 03 Nov 2014 11:00:03 AM
 * ************************************************************************/
namespace Zan\Library\Model;

class ZMongo {
    const DB_ACTIVE = 'mongo';
    public function __construct() {
        include ROOT . '/Zan/Conf/database.php';
        $conf = $db[self::DB_ACTIVE];
        if (!isset($conf['host'])) {
            exit('can not find db conf');
        }
        $host = 'mongodb://'
              . $conf['user'] ? $conf['user'] : ''
              . $conf['passwd'] ? (':' . $conf['user']) : ''
              . '@' . $conf['host']
              . $conf['database'] ? '/' . $conf['database'] : '';
        var_dump($host);
        $this->db = new \MongoClient($host);
    }

    public function __call($method, $params) {
        if (method_exists($this->db, $method)) {
            call_user_func_array(array($this->db, $method), $params);
        }
    }
}
