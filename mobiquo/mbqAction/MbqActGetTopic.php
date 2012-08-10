<?php

defined('MBQ_IN_IT') or exit;

/**
 * get_topic action
 * 
 * @since  2012-8-7
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqActGetTopic extends MbqBaseAct {
    
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
        $data = & MbqMain::$data;
        $forumId = MbqMain::$input[0];
        $startNum = (int) MbqMain::$input[1];
        $lastNum = (int) MbqMain::$input[2];
        $mode = MbqMain::$input[3];
        $oMbqDataPage = MbqMain::$oClk->newObj('MbqDataPage');
        $oMbqDataPage->initByStartAndLast($startNum, $lastNum);
        $oMbqRdEtForum = MbqMain::$oClk->newObj('MbqRdEtForum');
        $objsMbqEtForum = $oMbqRdEtForum->getObjsMbqEtForum(array($forumId), array('case' => 'byForumIds'));
        if ($objsMbqEtForum && ($oMbqEtForum = $objsMbqEtForum[0])) {
            $oMbqAclEtForumTopic = MbqMain::$oClk->newObj('MbqAclEtForumTopic');
            if ($oMbqAclEtForumTopic->canAclGetTopic($oMbqEtForum)) {    //acl judge
                switch ($mode) {
                    case 'TOP':     /* returns sticky topics */
                    MbqError::alert('', "Not support return sticky topics!", '', MBQ_ERR_NOT_SUPPORT);  /* TODO */
                    break;
                    case 'ANN':     /* returns "Announcement" topics */
                    MbqError::alert('', "Not support return Announcement topics!", '', MBQ_ERR_NOT_SUPPORT);  /* TODO */
                    break;
                    default:        /* returns standard topics */
                    $oMbqRdEtForumTopic = MbqMain::$oClk->newObj('MbqRdEtForumTopic');
                    $oMbqDataPage = $oMbqRdEtForumTopic->getObjsMbqEtForumTopic($oMbqEtForum, array('case' => 'byForum', 'oMbqDataPage' => $oMbqDataPage));
                    $data = $oMbqRdEtForum->returnApiDataForum($oMbqEtForum);
                    $data['topics'] = $oMbqRdEtForumTopic->returnApiArrDataForumTopic($oMbqDataPage->datas);
                    break;
                }
            } else {
                MbqError::alert('', '', '', MBQ_ERR_APP);
            }
        } else {
            MbqError::alert('', "Need valid forum id!", '', MBQ_ERR_APP);
        }
    }
  
}

?>