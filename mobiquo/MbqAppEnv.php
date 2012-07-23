<?php

defined('MBQ_IN_IT') or exit;

/**
 * application environment class
 * 
 * @since  2012-7-2
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqAppEnv extends MbqBaseAppEnv {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * application environment init
     * this class fully rely the application,so you can define the properties you need come from the application.
     */
    public function init() {
    }
    
}

?>