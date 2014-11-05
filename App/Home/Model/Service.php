<?php
/* *************************************************************************
 * File Name: Model/User.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Thu 23 Oct 2014 03:47:58 PM
 * ************************************************************************/
use Zan\Library\Model;

class Home_Model_Service extends Model {

    public static $BLOG_DIR;

    public function __construct() {
        parent::__construct();
        self::$BLOG_DIR =  ROOT . '/static/markdown/';
        $this->dbMysqli = self::getInstance('mysqli');
    }

    /**
     *
     * @param type
     *      - ids
     *      - infos
     *
     */
    function getAllBlogTitle($type = 'ids', $limit = array()) {
        if (!empty($limit) && 2 == count($limit)) {
            $limit = sprintf("limit %d, %d", (int)$limit[0], (int)$limit[1]);
        } else {
            $limit = '';
        }
        $sql    = sprintf("select * from blog_title order by id desc %s", $limit);
        $result = $this->dbMysqli->getArray($sql);
        if ('ids' == $type) {
            $titles = array();
            foreach ($result as $row) {
                $titles[] = $row['blog_id'];
            }
        }
        return 'ids' == $type ? $titles : $result;
    }

    function getFileNameById($id) {
        if (strpos($id, '..') !== false) return false;
        $file = self::$BLOG_DIR . $id . '.md';
        return file_exists($file) ? $file : false;
    }
}
