<?php
/* *************************************************************************
 * File Name: Bootstrap.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Fri 05 Sep 2014 03:41:53 PM
 * ************************************************************************/

class Bootstrap {

    public static function run(Uri_Router $router) {
        $router->init();
        $controller = $router->controller();
        $action     = $router->action();
        $controller::$action();
        $controller = Zen::load($router->controller());
        $action = $router->action();
        try {
            #$controller->$action();
            #$objController = new ReflectionClass($router->controller());
            #var_dump($objController->getMethod());
        } catch (Exception $e) {
            #var_dump($e);
        }
    }
}
