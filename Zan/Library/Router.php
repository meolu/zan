<?php
/* *************************************************************************
 * File Name: Router.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Fri 05 Sep 2014 03:32:19 PM
 * ************************************************************************/
namespace Zan\Library;

class Router {

    private static $_instance = null;
    private $_app;
    private $_controller;
    private $_action;

    public function __construct() {
        self::$_instance = &$this;
    }
    
    /**
     * 初始化REQUEST_URI对应app,controller,action
     *
     */
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
    
    /**
     * 获取当前app
     *
     * @return string
     */
    public function app() {
        return $this->_app;
    }
    
    /**
     * 设置或获取当前controller
     *
     * @param $controller string
     * @return string
     */
    public function controller($controller = null) {
        if ($controller) {
            $this->_controller = $controller;
        }
        return $this->_controller;
    }
    
    /**
     * 设置或获取当前action
     *
     * @param
     * @return
     */
    public function action($action = null) {
        if ($action) {
            $this->_action = $action;
        }
        return $this->_action;
    }

}
