<?php

defined('MBQ_IN_IT') or exit;

/**
 * get_subscribed_topic action
 * 
 * @since  2012-8-16
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqActGetSubscribedTopic extends MbqBaseAct {
    
    public function __construct() {
        parent::__construct();
        $this->level = 4;
    }
    
    /**
     * action implement
     */
    public function actionImplement() {
        if (!MbqMain::$oMbqConfig->moduleIsEnable('forum')) {
            MbqError::alert('', "Not support module forum!", '', MBQ_ERR_NOT_SUPPORT);
        }
        $startNum = (int) MbqMain::$input[0];
        $lastNum = (int) MbqMain::$input[1];
        $oMbqDataPage = MbqMain::$oClk->newObj('MbqDataPage');
        $oMbqDataPage->initByStartAndLast($startNum, $lastNum);
        $oMbqAclEtForumTopic = MbqMain::$oClk->newObj('MbqAclEtForumTopic');
        if ($oMbqAclEtForumTopic->canAclGetSubscribedTopic()) {     //acl judge
            $oMbqRdEtForumTopic = MbqMain::$oClk->newObj('MbqRdEtForumTopic');
            $oMbqDataPage = $oMbqRdEtForumTopic->getObjsMbqEtForumTopic(MbqMain::$oCurMbqEtUser->userId->oriValue, array('case' => 'subscribed', 'oMbqDataPage' => $oMbqDataPage));
            $this->data['total_topic_num'] = $oMbqDataPage->totalNum;
            $this->data['topics'] = $oMbqRdEtForumTopic->returnApiArrDataForumTopic($oMbqDataPage->datas);
        } else {
            MbqError::alert('', '', '', MBQ_ERR_APP);
        }
    }
  
}

?>