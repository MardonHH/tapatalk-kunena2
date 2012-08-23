<?php

defined('MBQ_IN_IT') or exit;

/**
 * get_subscribed_forum action
 * 
 * @since  2012-8-16
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqActGetSubscribedForum extends MbqBaseAct {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * action implement
     */
    public function actionImplement() {
        if (!MbqMain::$oMbqConfig->moduleIsEnable('forum')) {
            MbqError::alert('', "Not support module forum!", '', MBQ_ERR_NOT_SUPPORT);
        }
        $oMbqAclEtForum = MbqMain::$oClk->newObj('MbqAclEtForum');
        if ($oMbqAclEtForum->canAclGetSubscribedForum()) {
            $oMbqRdEtForum = MbqMain::$oClk->newObj('MbqRdEtForum');
            $objsMbqEtForum = $oMbqRdEtForum->getObjsMbqEtForum(MbqMain::$oCurMbqEtUser->userId->oriValue, array('case' => 'subscribed'));
            $this->data['total_forums_num'] = count($objsMbqEtForum);
            $this->data['forums'] = $oMbqRdEtForum->returnApiTreeDataForum($objsMbqEtForum);
        } else {
            MbqError::alert('', '', '', MBQ_ERR_APP);
        }
    }
  
}

?>