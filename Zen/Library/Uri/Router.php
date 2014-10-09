<?php
/* *************************************************************************
 * File Name: Router.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Fri 05 Sep 2014 03:32:19 PM
 * ************************************************************************/

class Uri_Router {

    private static $_instance = null;
    private $_controller;
    private $_action;
    function __construct() {
        self::$_instance = &$this;
        $this->module = "test";
    }
    public function init() {
        $uri = getenv('REQUEST_URI');
        if (false !== strpos($uri, '?')) {
            $uri = strstr($uri, '?', true);
        }
        $uriInfo = explode('/', trim($uri, '/'));
        array_map('strtolower', $uriInfo);
        list($this->_controller, $this->_action) = $uriInfo;
        $this->_controller = 'Controller_' . ucwords($uriInfo[0]);
        $this->_action = $uriInfo[1] . 'Action';
    }


    public function controller($controller = null) {
        if ($controller) {
            $this->_controller = $controller;
        }
        return $this->_controller;
    }

    public function action($action = null) {
        if ($action) {
            $this->_action = $action;
        }
        return $this->_action;
    }
}
