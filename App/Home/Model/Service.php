<?php
/* *************************************************************************
 * File Name: Model/User.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Thu 23 Oct 2014 03:47:58 PM
 * ************************************************************************/
use Zan\Library\Util;
use Zan\Library\Model;

class Home_Model_Service extends Model {

    public static $BLOG_DIR;

    public function __construct() {
        parent::__construct();
        self::$BLOG_DIR =  ROOT . '/static/markdown/';
        $this->dbMysqli = self::getInstance('mysqli');
    }

    function getId() {
        $index = 'http://www.huamanshu.com/blog/';
        $index = 'http://mvc:8888/blog/';
        $id = Util\Request::request('id');
        $id = $index === $id ? $index . 'index.html' : $id;

        $ret = preg_match('/\/([^\/]*?)\.html/', $id, $match);
        return $ret ? $match[1] : false;
    }

    function getAllComments() {
        $id = self::getId();
        if ($id) {
            return $this->dbMysqli->getArray(sprintf("select * from comments where post_id ='%s'", $id));
        }
        return;
    }

    function addComment() {
        $id = self::getId();
        if ($id) {
            $data['post_id'] = $id;
            $data['name']    = $this->input->post('name') ? $this->input->post('name') : '游客';
            $data['comment'] = $this->input->post('comment');

            if (empty($data['comment'])) {
                echo 0; exit;
            }
            $query = $this->db->insert_string('comments', $data);
            echo $this->db->query($query);
            exit;
        }
        echo 0;
   
    }

    function viewCount() {
        $id = self::getId();
        if ($id) {
            $sql = sprintf("update %s set view = view + 1 where blog_id = '%s'", Home_Conf_Db::TABLE_BLOG_TITLE, $id);
            $this->dbMysqli->query($sql);
            $sql = sprintf("select view from %s where blog_id = '%s'", Home_Conf_Db::TABLE_BLOG_TITLE, $id);
            $ret = $this->dbMysqli->getArray($sql);
            return $ret[0]['view'];
        }
        return false;
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

    function getBlogTitleFromFileByTime($blogId) {
        $file  = fopen($this->getFileNameById($blogId), 'r');
        $line  = fgets($file);
        $title = preg_replace('/\<!---title:(.*)--\>/i', '\1', $line);
        fclose($file);
        return trim($title);
    }

    function getFileNameById($id, $create = false) {
        if (strpos($id, '..') !== false) return false;
        $file = self::$BLOG_DIR . $id . '.md';
        if ($create) {
            return $file;
        }
        return file_exists($file) ? $file : false;
    }


    function initBlogTitle() {
        $blogList = Util\FileInfo::getFiles(Home_Conf_Blog::MARKDOWN_DIR);

        foreach($blogList as $k => &$v) {
            if (strpos($v, '.md') === false || 'index.md' === $v) {
                unset($blogList[$k]);
            }
        }
        rsort($blogList);

        $db = $this->getAllBlogTitle();

        // 
        $pushInsert = array();
        $pushUpdate = array();
        foreach ($blogList as $k => $id) {
            $id    = substr($id, 0, strpos($id, '.md'));
            $title = $this->getBlogTitleFromFileByTime($id);
            if (in_array($id, $db)) {
                $pushUpdate[] = sprintf("update %s set title_name = %s where blog_id = %s", 
                    Home_Conf_Db::TABLE_BLOG_TITLE, $title, $id);
            } else {
                $pushInsert[] = sprintf("('%s', '%s')", $id, $title);
            }
        }
        // 
        $retIn = true;
        if (!empty($pushInsert)) {
            $values = implode(',', $pushInsert);
            $inSql  = sprintf("insert into blog_title(blog_id, title_name) values %s", $values);

            $retIn  = $this->dbMysqli->query($inSql);
        }

        // 
        $retUp = true;
        if (!empty($pushUpdate)) {
            foreach ($pushUpdate as $sql) {
                $retUp  = $this->dbMysqli->query($sql);
            }
        }

        //
    }
}
