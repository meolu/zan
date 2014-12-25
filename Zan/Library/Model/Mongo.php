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
    

    public function __construct($db = 'ugc') {
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
        /*
        // to do 副本集
        $this->db  = $db;
        $mongoConf = Bd_Conf::getConf('/lbsugc/mongo');
        $mongoConf = $mongoConf['servers'];
        foreach ($mongoConf as $v) {
            $hosts .= "{$v['server']}:{$v['port']},";
        }
        $uri = sprintf("mongodb://%s/?readPreference=nearest", rtrim($hosts, ','));
        $this->mongod = new MongoClient($uri);
        */
    }

    public function getCollection($collection, $master = false) {
        if (is_object($this->connections[$collection])) {
            return $this->connections[$collection];
        }

        $this->connections[$collection] = $this->mongod->selectCollection($this->db, $collection);
        return $this->connections[$collection];
    }

    /**
     * 返回查询结果的游标，是find的基础方法
     *
     * Pass the query and options as array objects (this is more convenient than the standard
     * Mongo API especially when caching)
     *
     * $options may contain:
     *   fields - the fields to retrieve
     *   sort - the criteria to sort by
     *   limit - the number of objects to return
     *   skip - the number of objects to skip
     *
     * @param string $collection
     * @param array $query
     * @param array $options
     * @return MongoCursor
     **/
    public function query($collection, $query = array(), $options = array()) {
        $col = $this->getCollection($collection, true);
        $fields = isset($options['fields']) ? $options['fields'] : array();
        $result = $col->find($query, $fields);
        if (isset($options['sort']) && $options['sort'] !== null) {
            $result->sort($options['sort']);
        }
        if (isset($options['limit']) && $options['limit'] !== null) {
            $result->limit($options['limit']);
        }
        if (isset($options['skip']) && $options['skip'] !== null) {
            $result->skip($options['skip']);
        }
        return $result;
    }

    /**
     * 数组形式返回
     *
     * @param string $collection
     * @param array $query
     * @param array $options
     * @return array
     **/
    public function find($collection, $query = array(), $options = array()) {
        $result = $this->query($collection, $query, $options);
        $array = array();
        foreach ($result as $val) {
            $array[] = $val;
        }
        return $array;
    }

    /**
     * 返回只含一列的数组
     *
     * @param string $collection
     * @param string $field
     * @param array $query
     * @param array $options
     * @return array
     **/
    public function findField($collection, $field, $query = array(), $options = array()) {
        $options['fields'] = array($field => 1);
        $result = $this->query($collection, $query, $options);
        $array = array();
        foreach ($result as $val) {
            $array[] = $val[$field];
        }
        return $array;
    }

    /**
     * 返回关联数组
     *
     * @param string $collection
     * @param string $key_field
     * @param string $value_field
     * @param array $query
     * @param array $options
     * @return array
     **/
    public function findAssoc($collection, $key_field, $value_field, $query = array(), $options = array()) {
        $options['fields'] = array($key_field => 1, $value_field => 1);
        $result = $this->query($collection, $query, $options);
        $array = array();
        foreach ($result as $val) {
            $array[$val[$key_field]] = $val[$value_field];
        }
        return $array;
    }
    
    /**
     * 返回一个一行记录的对象
     *
     * @param string $collection
     * @param mixed $id
     * @return array
     **/
    public function findOne($collection, $id) {
        $col = $this->getCollection($collection, true);
        if (!is_array($id)) {
            $id = array('_id' => self::id($id));
        }
        return $col->findOne($id);
    }

    /**
     * 查询记录数
     *
     * @param string $collection
     * @param array $query
     * @return integer
     **/
    public function count($collection, $query = array()) {
        $col = $this->getCollection($collection, true);
        if ($query) {
            $res = $col->find($query);
            return $res->count();
        } else {
            return $col->count();
        }
    }

    /**
     * Save a Mongo object -- just a simple shortcut for MongoCollection's save()
     *
     * @param string $collection
     * @param array $data
     * @return boolean
     **/
    public function save($collection, $data) {
        $col = $this->getCollection($collection);
        return $col->save($data);
    }
    
    /**
     * 插入
     *
     * @param string $collection
     * @param array $array
     * @return boolean
     **/
    public function insert($collection, $data) {
        $col = $this->getCollection($collection);
        return $col->insert($data);
    }

    /**
     * 批量插入
     *
     * @param string $collection
     * @param array $array
     * @return boolean
     **/
    public function batchInsert($collection, $array) {
        $col = $this->getCollection($collection);
        return $col->batchInsert($array);
    }

    /**
     * 最近错误
     *
     **/
    public function lastError() {
        $db = $this->mongod->selectDB($this->db);
        return $db->lastError();
    }    

    /**
     * 更新数据
     *
     * @param string $collection
     * @param array $criteria
     * @param array $newobj
     * @param boolean $upsert
     * @return boolean
     **/
    public function update($collection, $criteria, $newobj, $options = array()) {
        $col = $this->getCollection($collection);
        if ($options === true) {
            $options = array('upsert' => true);
        }
        if (!isset($options['multiple'])) {
            $options['multiple'] = false;
        }
        return $col->update($criteria, $newobj, $options);
    }
    
    public function updateConcurrent($collection, $criteria, $newobj, $options = array()) {
        $col = $this->getCollection($collection);
        if (!isset($options['multiple'])) {
            $options['multiple'] = false;
        }
        $i = 0;
        foreach ($col->find($criteria, array('fields' => array('_id' => 1))) as $obj) {
            $col->update(array('_id' => $obj['_id']), $newobj);
            if (empty($options['multiple'])) {
                return;
            }
            if (!empty($options['count_mod']) && $i % $options['count_mod'] == 0) {
                if (!empty($options['count_callback'])) {
                    call_user_func($options['count_callback'], $i);
                } else {
                    echo '.';
                }
            }
            $i++;
        }
    }

    /**
     * update + upsert = true的组合版本
     *
     * @param string $collection
     * @param array $criteria
     * @param array $newobj
     * @return boolean
     **/
    public function upsert($collection, $criteria, $newobj) {
        return $this->update($collection, $criteria, $newobj, true);
    }

    /**
     * Shortcut for MongoCollection's remove() method, with the option of passing an id string
     *
     * @param string $collection
     * @param array $criteria
     * @param boolean $just_one
     * @return boolean
     **/
    public function remove($collection, $criteria, $options = ['justOne' => true]) {
        $col = $this->getCollection($collection);
        if (!is_array($criteria)) {
            $criteria = array('_id' => self::id($criteria));
        }
        return $col->remove($criteria, $options);
    }

    /**
     * 如果线上业务要直接group才可以的话，说明你是个笨蛋
     * 聚合计算请转移到后台脚本操作
     *
     **/
    public function group($collection, array $keys, array $initial, $reduce, array $condition = array()) {
        $col = $this->getCollection($collection, true);
        return $col->group($keys, $initial, $reduce, $condition);
    }

    /**
     * 返回一个神奇的东西，当然得看你传啥进来了，可字符串，可数字，可对象
     * a MongoId from a string, MongoId, array, or Dbo object
     *
     * @param mixed $obj
     * @return MongoId
     **/
     public static function id($obj) {
        if ($obj instanceof MongoId) {
            return $obj;
        }
        if (is_string($obj)) {
            return new MongoId($obj);
        }
        if (is_array($obj)) {
            return $obj['_id'];
        }
        return new MongoId($obj->_id);
    }

    public function __call($method, $params) {
        if (method_exists($this->db, $method)) {
            call_user_func_array(array($this->db, $method), $params);
        }
    }
}