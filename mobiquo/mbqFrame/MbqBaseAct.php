<?php

defined('MBQ_IN_IT') or exit;

/**
 * action base class
 * 
 * @since  2012-7-2
 * @author Wu ZeTao <578014287@qq.com>
 */
Abstract Class MbqBaseAct {
    
    public function __construct() {
    }
    
    /**
     * action implement
     */
    abstract public function actionImplement();
  
}

?>