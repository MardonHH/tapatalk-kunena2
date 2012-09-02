<?php

defined('MBQ_IN_IT') or exit;

/**
 * get_inbox_stat action
 * 
 * @since  2012-8-16
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqActGetInboxStat extends MbqBaseAct {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * action implement
     */
    public function actionImplement() {
        /* TODO */
        if (MbqMain::$oMbqConfig->moduleIsEnable('pc') && (MbqMain::$oMbqConfig->getCfg('pc.conversation')->oriValue == MbqBaseFdt::getFdt('MbqFdtConfig.pc.conversation.range.support'))) {
            $this->data['inbox_unread_count'] = (int) 0;
        } elseif (MbqMain::$oMbqConfig->moduleIsEnable('pm')) {
            $this->data['inbox_unread_count'] = (int) 0;
        } else {
            $this->data['inbox_unread_count'] = (int) 0;
        }
        if (MbqMain::$oMbqConfig->moduleIsEnable('subscribe')) {
            $this->data['subscribed_topic_unread_count'] = (int) 0;
        } else {
            $this->data['subscribed_topic_unread_count'] = (int) 0;
        }
    }
  
}

?>