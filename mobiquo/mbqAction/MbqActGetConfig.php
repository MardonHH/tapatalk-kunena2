<?php

defined('MBQ_IN_IT') or exit;

/**
 * get_config action
 * 
 * @since  2012-7-30
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqActGetConfig extends MbqBaseAct {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * action implement
     */
    public function actionImplement() {
        /* will output by MbqMain::$oMbqConfig */
    }
  
}

?>