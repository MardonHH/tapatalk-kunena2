<?php

defined('MBQ_IN_IT') or exit;

/**
 * user module field definition class
 * 
 * @since  2012-7-18
 * @author Wu ZeTao <578014287@qq.com>
 */
Abstract Class MbqFdtUser extends MbqBaseFdt {
    
    public static $df = array(
        
    );
  
}
MbqBaseFdt::$df['MbqFdtUser'] = &MbqFdtUser::$df;

?>