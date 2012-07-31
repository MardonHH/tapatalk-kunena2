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
        $data = &MbqMain::$data;
        $data['sys_version'] = MbqMain::$oMbqConfig->getCfg('base.mbq_version')->oriValue;
        $data['api_level'] = MbqMain::$oMbqConfig->getCfg('base.api_level')->oriValue;
    }
  
}

?>