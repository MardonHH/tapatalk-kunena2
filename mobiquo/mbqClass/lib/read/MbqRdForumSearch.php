<?php

defined('MBQ_IN_IT') or exit;

/**
 * forum search class
 * 
 * @since  2012-8-27
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqRdForumSearch {
    
    public function __construct() {
    }
    
    /**
     * forum advanced search
     *
     * @param  Array  $filter  search filter
     * @param  Object  $oMbqDataPage
     * @param  Array  $mbqOpt
     * $mbqOpt['case'] = 'advanced' means advanced search
     * $mbqOpt['participated'] = true means get participated data
     * $mbqOpt['unread'] = true means get unread data
     * @return  Object  $oMbqDataPage
     */
    public function forumAdvancedSearch($filter, $oMbqDataPage, $mbqOpt) {
        if ($mbqOpt['case'] == 'getParticipatedTopic' || $mbqOpt['case'] == 'getUnreadTopic' || $mbqOpt['case'] == 'getLatestTopic') {
            require_once(MBQ_APPEXTENTION_PATH.'ExttMbqKunenaForumTopicHelper.php');
            $oMbqRdEtForumTopic = MbqMain::$oClk->newObj('MbqRdEtForumTopic');
            if ($mbqOpt['participated']) {
                $params['posted'] = true;
                $params['user'] = MbqMain::$oCurMbqEtUser->userId->oriValue;
            }
            if ($mbqOpt['unread']) {
                $params['unread'] = true;
                $params['user'] = MbqMain::$oCurMbqEtUser->userId->oriValue;
            }
            $arr = ExttMbqKunenaForumTopicHelper::exttMbqGetLatestTopics(false, $oMbqDataPage->startNum, $oMbqDataPage->numPerPage, $params);
            $oMbqDataPage->totalNum = $arr[0];
            $objsKunenaForumTopic = $arr[1];
            $newMbqOpt['case'] = 'byObjsKunenaForumTopic';
            $newMbqOpt['oMbqDataPage'] = $oMbqDataPage;
            $oMbqDataPage = $oMbqRdEtForumTopic->getObjsMbqEtForumTopic($objsKunenaForumTopic, $newMbqOpt);
            return $oMbqDataPage;
        } elseif ($mbqOpt['case'] == 'advanced') {
            /* dummy */
            $oMbqDataPage->totalNum = 0;
            return $oMbqDataPage;
        }
        MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_CASE);
    }
  
}

?>