<?php

defined('MBQ_IN_IT') or exit;

/**
 * entity base class
 * 
 * @since  2012-7-9
 * @author Wu ZeTao <578014287@qq.com>
 */
Abstract Class MbqBaseEntity {
    
    public $exttBind;   /* binded data var comes from application,array data type. */
    
    public function __construct() {
        $this->exttBind = array();
    }
  
}

?>