<?php

defined('MBQ_IN_IT') or exit;

/**
 * input/output base class
 * 
 * @since  2012-7-8
 * @author Wu ZeTao <578014287@qq.com>
 */
Abstract Class MbqBaseIo {
    
    protected $protocol;    /* xmlrpc/json */
    protected $module;  /* module name */
    protected $cmd;   /* action command name,must unique in all action. */
    protected $input;   /* input params array */
    
    public function __construct() {
        $this->input = array();
    }
    
    /**
     * input data
     */
    public function input() {
        MbqMain::$protocol = &$this->protocol;
        MbqMain::$module = &$this->module;
        MbqMain::$cmd = &$this->cmd;
        MbqMain::$input = &$this->input;
    }
    
    /**
     * output data
     */
    public function output() {
        $data = &MbqMain::$data;
    }
  
}

?>