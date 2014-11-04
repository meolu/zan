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

        try {
            if (!Zan::class2file($controller)) {
                Zan::display40x();
            }
            $instance = new $controller();
            if (!method_exists($instance, $action)) {
                Zan::display40x();
            }
            $instance->$action();
        } catch (ZException $e) {
            Zan::display50x($e->getMessage());
        }
            
    }

}
