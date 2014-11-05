<?php
/* *************************************************************************
 * File Name: Router.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Fri 05 Sep 2014 03:32:19 PM
 * ************************************************************************/
namespace Zan\Library\Uri;

class Router {

    private static $_instance = null;
    private $_app;
    private $_controller;
    private $_action;
    
    public function __construct() {
        self::$_instance = &$this;
    }

    public function init() {
        $uri = getenv('REQUEST_URI');
        if (false !== strpos($uri, '?')) {
            $uri = strstr($uri, '?', true);
        }
        $uriInfo = explode('/', trim($uri, '/'));
        array_map('strtolower', $uriInfo);
        $this->_app        = ucwords($uriInfo[0]);
        $this->_controller = $this->_app . '_Controller_' . ucwords($uriInfo[1]);
        $this->_action     = ucwords($uriInfo[2]) . 'Action';
        define('APP', $this->_app . '/');
    }

    public function app() {
        return $this->_app;
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

    public function request(array $params = array()) {

    }
}
