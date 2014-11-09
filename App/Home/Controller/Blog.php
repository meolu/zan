<?php
/* *************************************************************************
 * File Name: Blog.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Thu 06 Nov 2014 08:25:20 PM
 * ************************************************************************/
use Zan\Library\Util;
use Zan\Library\Util\Request;
use Zan\Library\Controller;

class Home_Controller_Blog extends Controller {

    public function __construct() {
        $this->modelService = new Home_Model_Service();
    }

    function getNextPrevAction() {
        $id = $this->modelService->getId();
        header('content-type:application/json');
        $infos = $this->modelService->getAllBlogTitle('infos');
        $nextPrev = array();
        foreach ($infos as $k => $v) {
            if ($id == $v['blog_id']) {
                $key = $k;
                break;
            }
        }
        $prevK = $key - 1;
        if (isset($infos[$prevK])) {
            $p = array(
                'title' => $infos[$prevK]['title_name'],
                'url' => sprintf('/blog/%s.html', $infos[$prevK]['blog_id']),
            );
            $nextPrev['p'] = $p;
        }
        $nextK = $key + 1;
        if (isset($infos[$nextK])) {
            $n = array(
                'title' => $infos[$nextK]['title_name'],
                'url' => sprintf('/blog/%s.html', $infos[$nextK]['blog_id']),
            );
            $nextPrev['n'] = $n;
        }
        echo json_encode($nextPrev);
    }

    function viewCountAction() {
        header("content-type:application/json");
        $views = $this->modelService->viewCount();
        echo json_encode(array('is_success' => !!$views,'time' => $this->modelService->getId(), 'view' => $views));

    }

    function addcommentAction() {
        header("content-type:application/json");
        $comments = $this->modelService->addComment();
        echo json_encode(array('is_success' => $comments));
    }

    function getcommentAction($id = 'index') {
        header("content-type:application/json");
        $comments = $this->modelService->getAllComments();
        echo json_encode(array('comments' => $comments));
    }

}
