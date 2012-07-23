<?php

defined('MBQ_IN_IT') or exit;

/**
 * thank module field definition class
 * 
 * @since  2012-7-18
 * @author Wu ZeTao <578014287@qq.com>
 */
Abstract Class MbqFdtThank extends MbqBaseFdt {
    
    public static $df = array(
        
    );
  
}
MbqBaseFdt::$df['MbqFdtThank'] = &MbqFdtThank::$df;

?>