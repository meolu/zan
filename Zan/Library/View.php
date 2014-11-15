<?php
/* *************************************************************************
 * File Name: View.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Sun 09 Nov 2014 02:53:48 PM
 * ************************************************************************/
namespace Zan\Library;

class View {
    private $_tpl;
    protected $_extract = [];

    public function __construct($tpl = null) {
        if ($tpl) {
            $this->_tpl = APPPATH . APP . '/Template/' . $tpl;
        }
    }

    public function setTpl($tpl) {
        $this->_tpl = APPPATH . APP . '/Template/' . $tpl;
    }

    public function set($key, $val) {
        $this->_extract[$key] = $val;
    }

    public function mset($array = []) {
        if (!is_array($array) || empty($array)) {
            return;
        }
        foreach ($array as $key => $val) {
            $this->set($key, $val);
        }
    }

    public function render($array = [], $tpl = null) {
        if (is_array($array) && $tpl) {
            $this->_tpl = APPPATH . APP . '/Template/' . $tpl;
        }
        $this->mset($array);

        if (!file_exists($this->_tpl)) {
            throw new \ZException("can not find tpl[{$this->_tpl}]", E_ERROR);
        }
        ob_start();
        extract($this->_extract);
        include($this->_tpl);
        ob_flush();
    }

    public static function renderJSON($array) {
        if (!is_array($array)) {
            trigger_error('View::renderJSON param is not array', E_USER_ERROR);
        }
        header('content-type:application/json');
        echo json_encode($array, true);
    }
}

