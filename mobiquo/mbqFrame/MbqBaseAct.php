<?php

defined('MBQ_IN_IT') or exit;

/**
 * action base class
 * 
 * @since  2012-7-2
 * @author Wu ZeTao <578014287@qq.com>
 */
Abstract Class MbqBaseAct {
    
    public $data;   /* data need return.reference to MbqMain::$data */
    public $level;  /* supported level degree,default is level 3 */
    
    public function __construct() {
        $this->data = & MbqMain::$data;
        $this->level = 3;
    }
    
    /**
     * action implement
     */
    abstract public function actionImplement();
  
}

?>