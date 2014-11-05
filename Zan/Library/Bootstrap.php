<?php
/* *************************************************************************
 * File Name: Bootstrap.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Fri 05 Sep 2014 03:41:53 PM
 * ************************************************************************/
namespace Zan\Library;
use Zan;

class Bootstrap {

    public static function run(Uri\Router $router) {
        $router->init();
        $controller = $router->controller();
        $action     = $router->action();

        try {
            if (!Zan\Zan::class2file($controller)) {
                Zan\Zan::display40x();
            }
            $instance = new $controller();
            if (!method_exists($instance, $action)) {
                Zan\Zan::display40x();
            }
            $instance->$action();
        } catch (Exception $e) {
            Zan\Zan::display50x($e->getMessage());
        }
            
    }

}
