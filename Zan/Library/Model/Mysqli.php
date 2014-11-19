<?php
/* *************************************************************************
 * File Name: Model.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Sun 02 Nov 2014 06:24:26 PM
 * ************************************************************************/
namespace Zan\Library\Model;


class Mysqli {
    const DB_ACTIVE = 'default';
    protected $db;
    protected $table;
    protected $pdo;

    /**
     * 使用PDO，更为简洁安全之余，对数据操作抽象也更方便
     * 先配置数据库连接信息，并确认开启PDO
     */
    public function __construct() {
        include ROOT . '/Zan/Conf/database.php';
        if (!isset($db[self::DB_ACTIVE])) {
            exit('can not find db conf');
        }
        $dbConf = $db[self::DB_ACTIVE];
        $dns = sprintf('mysql:host=%s;port=%d;dbname=%s', $dbConf['host'], $dbConf['port'], $dbConf['database']);
        $this->pdo = new \PDO($dns, $dbConf['user'], $dbConf['passwd']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * 单例模式
     */
    public static function getInstance() {
        static $instance = null;
        if (null == $instance) {
            $instance = new self();
        }
        return $instance;
    }

    public function query($sql, array $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * 查询一条记录
     * @param $sql string
     * @param $params array bind_params
     * @return array
     */
    public function fetchOne($sql, array $params = []) {
        if (! $stmt = $this->query($sql, $params)) return;
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * 查询所有记录
     * @param $sql string
     * @param $params array bind_params
     * @return array
     */
    public function fetch($sql, array $params = []) {
        if (! $stmt = $this->query($sql, $params)) return;
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 查询记录数
     * @param $table string
     * @param $where array
     * @return array
     */
    public function getCount($table, array $where = []) {
        list($whereStr, $whereParams) = $this->where($where);
        $sql = sprintf("select count(*) as num from `%s` where %s", $table, $whereStr);
        if (! $stmt = $this->query($sql, $whereParams)) return 0;
        $ret = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $ret['num'];
    }

    /**
     * insert data
     * @param $table string
     * @param $data array
     * @return int 影响行数
     */
    public function insert($table, array $data) {
        $insert = $this->getInsert($table, $data);
        return $this->query($insert, array_values($data)) ? $this->pdo->lastInsertId() : false;
    }

    /**
     * update data
     * @param $table string
     * @param $data array
     * @param $where array
     * @return int 影响行数
     */
    public function update($table, array $data, array $where = []) {
        list($whereStr, $whereParams) = $this->where($where);
        $update = $this->getUpdate($table, array_keys($data), $whereStr);
        if (! $stmt = $this->query($update, array_merge(array_values($data), $whereParams))) return;
        return $stmt->rowCount();
    }

    /**
     * delete data
     * @param $table string
     * @param $where array
     * @return int 影响行数
     */
    public function delete($table, array $where) {
        list($whereStr, $whereParams) = $this->where($where);
        $delete = $this->getDelete($table, $whereStr);
        if (! $stmt = $this->query($delete, $whereParams)) return;
        return $stmt->rowCount();
    }

    public function getDelete($table, $where) {
        return sprintf('DELETE FROM %s WHERE %s', $table, $where);
    }

    public function getInsert($table, array $data) {
        return sprintf('INSERT INTO `%s` (`%s`) VALUES (%s)',
            $table, join('`, `', array_keys($data)), rtrim(str_repeat("?, ", count($data)), ', '));
    }

    public function getUpdate($table, $field, $where) {
        $set  = rtrim(join('=?, ', $field), ', ');
        $set .= '=?';
        return sprintf('UPDATE %s SET %s WHERE %s', $table, $set, $where);
    }

    public function where(array $where) {
        return array(join(' AND ', array_keys($where)), array_values($where));
    }

    public function __call($func, $params) {
        if (method_exists($this->pdo, $func)) {
            return call_user_func_array(array($this->pdo, $func), $params);
        }
    }

}
