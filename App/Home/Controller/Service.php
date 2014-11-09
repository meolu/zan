<?php
/* *************************************************************************
 * File Name: Controller/User.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Sun 14 Sep 2014 07:48:36 PM
 * ************************************************************************/
use Zan\Library\Util;
use Zan\Library\Util\Request;
use Zan\Library\Controller;

class Home_Controller_Service extends Controller {
    const PERPAGE = 12;
    public $model;

    public function __construct() {
        $this->modelService = new Home_Model_Service();
    }

    function login() {
        if (Request::isPost()) {
            $uname  = Request::post('uname');
            $passwd = Request::post('passwd');
            if (!empty($uname) && !empty($passwd)) {
                $sql   = sprintf("select count(*) from blog_admin where name = '%s' and passwd = '%s'", $uname, md5($passwd));
                $query = $this->modelService->getArray($sql);
                if (empty($query)) {
                    Util\Session::mset(array('uname' => $uname, 'passwd' => $passwd));
                    header('location:/home/service/editor');
                    exit(0);
                }
            }
            $err = true;
        }
        self::render(array(
            'err' => $err,
        ), 'login.php');
    }

    public function editorAction() {
        $ret = $this->_checkUserLogin();
        if (false === $ret) return false;
        self::render(array(
            'timestamp' => $time,
            'token'     => md5('unique_salt' . $time),
            'uploader'  => '/home/service/UPLOADPICPROCCESS/',
        ), 'editor.php');
    }

    public function loadblogAction() {
        // header('content-type:application/json');
        $blogId = Request::get('blog_id');
        $file = $this->modelService->getFileNameById($blogId);
        if (false === $file) {
            echo json_encode(array('is_success' => false));
        } else {
            $md = file_get_contents($file, 'r');
            echo json_encode(array('is_success' => true, 'blog' => $md));
        }
    }

    function syncblogAction() {
        // header('content-type:application/json');
        $ret = $this->_checkUserLogin();
        if (false === $ret) return false;
        $blogId = Request::post('blog_id');
        $file = $this->modelService->getFileNameById($blogId);
        if (false === $file) {
            echo json_encode(array('is_success' => false));
        } else {
            $blogContent = Util\Request::post('blog_content');
            $ret = file_put_contents($file, $blogContent);
            echo json_encode(array('is_success' => $ret !== false));
        }
    }

    /**
     * @author wushuiyong
     * @todo ko client create blog
     */
    function createblogAction() {
        $ret = $this->_checkUserLogin();
        if (false === $ret) return false;

        // header('content-type:application/json');
        $blogId = $this->createTitle();
        // var_dump($blogId);
        $this->modelService->initBlogTitle();

        $ret = array(
            'is_success' => !!$blogId,
            'blog_id' => $blogId,
        );

        echo json_encode($ret);

    }

    /**
     * @author wushuiyong
     * @todo  create title for file name
     *
     */
    function createTitle($suffix = 0) {
        $ret = $this->_checkUserLogin();
        if (false === $ret) return false;

        $blogId = sprintf("%s%s", date("Y-m-d", time()), $suffix ? $suffix : '');
        $file = $this->modelService->getFileNameById($blogId, true);
        $fileExsit = Util\FileInfo::isFile($file);

        if (!$fileExsit) {
            $success = file_put_contents($file, '');
            return false !== $success ? $blogId : $success;
        } else {
            if (($blogId = $this->createTitle(++$suffix))) {
                return $blogId;
            }
        }
    }

    function uploadPic() {
        $ret = $this->_checkUserLogin();
        if (false === $ret) return false;

        $time = time();
        self::render(array(
            'timestamp' => $time,
            'token'     => md5('unique_salt' . $time),
            'uploader'  => '/home/service/uploadpicproccess/',
        ), 'upload_pic.php');
    }


    function uploadpicproccessAction() {
        // Define a destination
        $targetFolder = '/static/images/upload'; // Relative to the root
        $verifyToken = md5('unique_salt' . Util\Request::post('timestamp'));

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            
            if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
                $tempFile   = $_FILES['Filedata']['tmp_name'];
                $newFile    = sprintf("%s-%d.%s", date("YmdHis", time()), rand(10, 99), $fileParts['extension']);
                $previewUrl = rtrim($targetFolder, '/') . '/' . $newFile;
                $targetFile = ROOT . $previewUrl;
                move_uploaded_file($tempFile, $targetFile);
                echo $previewUrl;
            } else {
                echo 'Invalid file type.';
            }
        }
    }

    public function getblogsAction() {
        // header('content-type:application/json');
        // $page = (int)$this->input->GET('page');
        $page = 0;
        $limit = array($page * self::PERPAGE, self::PERPAGE);
        $list = $this->modelService->getAllBlogTitle('all', $limit);
        echo json_encode(array('is_success' => true, 'blogs' => $list));
    }

    function compileAction() {
        $ret = $this->_checkUserLogin();
        if (false === $ret) return false;
        
        header('content-type:application/json');
        $shellMd2Html = sprintf("sh %s/static/markdown/markdown2html/md2html.sh", ROOT);
        exec($shellMd2Html, $out);
        $shellGit = sprintf("sh %s/static/markdown/markdown2html/gitCommit.sh", ROOT);
        // exec($shellGit, $out);
        $this->modelService->initBlogTitle();
        echo json_encode(array('is_success' => true));
    }

    private function _checkUserLogin() {
        $name = Util\Session::get('uname');
        if (empty($name)) {
            $this->login();
            return false;
        }
        return true;
    }
}
