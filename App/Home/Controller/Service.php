<?php
/* *************************************************************************
 * File Name: Controller/User.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Sun 14 Sep 2014 07:48:36 PM
 * ************************************************************************/

class Home_Controller_Service extends Controller {
    public $model;
    const PERPAGE = 12;
    public function __construct() {
        $this->modelSerice = new Home_Model_Service();
    }

    public function editorAction() {

        self::render(array(
            'timestamp' => $time,
            'token'     => md5('unique_salt' . $time),
            'uploader'  => '/service/uploadPicProccess/',
        ), 'editor.php');
    }

    public function loadblogAction() {
        // header('content-type:application/json');
        $blogId = Util\Request::get('blog_id');
        $file = $this->modelSerice->getFileNameById($blogId);
        if (false === $file) {
            echo json_encode(array('is_success' => false));
        } else {
            $md = file_get_contents($file, 'r');
            echo json_encode(array('is_success' => true, 'blog' => $md));
        }
    }
    public function getblogsAction() {
        // header('content-type:application/json');
        // $page = (int)$this->input->GET('page');
        $page = 0;
        $limit = array($page * self::PERPAGE, self::PERPAGE);
        $list = $this->modelSerice->getAllBlogTitle('all', $limit);
        echo json_encode(array('is_success' => true, 'blogs' => $list));
    }
}
