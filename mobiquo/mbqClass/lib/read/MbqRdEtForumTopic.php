<?php

defined('MBQ_IN_IT') or exit;

MbqMain::$oClk->includeClass('MbqBaseRdEtForumTopic');

/**
 * forum topic read class
 * 
 * @since  2012-8-8
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqRdEtForumTopic extends MbqBaseRdEtForumTopic {
    
    public function __construct() {
    }
    
    protected function makeProperty(&$oMbqEtForumTopic, $pName, $mbqOpt = array()) {
        switch ($pName) {
            case 'oAuthorMbqEtUser':
            $oMbqRdEtUser = MbqMain::$oClk->newObj('MbqRdEtUser');
            if ($oMbqEtUser = $oMbqRdEtUser->initOMbqEtUser($oMbqEtForumTopic->topicAuthorId->oriValue, array('case' => 'byUserId'))) {
                $oMbqEtForumTopic->oAuthorMbqEtUser = $oMbqEtUser;
            }
            break;
            case 'byOAuthorMbqEtUser':   /* make properties by oAuthorMbqEtUser */
            if ($oMbqEtForumTopic->oAuthorMbqEtUser) {
                if ($oMbqEtForumTopic->oAuthorMbqEtUser->iconUrl->hasSetOriValue()) {
                    $oMbqEtForumTopic->authorIconUrl->setOriValue($oMbqEtForumTopic->oAuthorMbqEtUser->iconUrl->oriValue);
                }
            }
            break;
            case 'oFirstMbqEtForumPost':
            if ($oMbqEtForumTopic->firstPostId->hasSetOriValue()) {
                $oMbqRdEtForumPost = MbqMain::$oClk->newObj('MbqRdEtForumPost');
                if ($oMbqEtForumPost = $oMbqRdEtForumPost->initOMbqEtForumPost($oMbqEtForumTopic->firstPostId->oriValue, array('case' => 'byPostId'))) {
                    $oMbqEtForumTopic->oFirstMbqEtForumPost = $oMbqEtForumPost;
                }
            }
            break;
            case 'oMbqEtForum':
            if ($oMbqEtForumTopic->forumId->hasSetOriValue()) {
                $oMbqRdEtForum = MbqMain::$oClk->newObj('MbqRdEtForum');
                if ($objsMbqEtForum = $oMbqRdEtForum->getObjsMbqEtForum(array($oMbqEtForumTopic->forumId->oriValue), array('case' => 'byForumIds'))) {
                    $oMbqRdEtForum->oMbqEtForum = $objsMbqEtForum[0];
                }
            }
            break;
            default:
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_PNAME . ':' . $pName . '.');
            break;
        }
    }
    
    /**
     * get forum topic objs
     *
     * @param  Mixed  $var
     * @param  Array  $mbqOpt
     * $mbqOpt['case'] = 'byForum' means get data by forum obj.$var is the forum obj.
     * $mbqOpt['case'] = 'subscribed' means get subscribed data.$var is the user id.
     * $mbqOpt['case'] = 'byObjsKunenaForumTopic' means get data by objsKunenaForumTopic.$var is the objsKunenaForumTopic.
     * $mbqOpt['case'] = 'byTopicIds' means get data by topic ids.$var is the ids.
     * $mbqOpt['top'] = true means get sticky data.
     * @return  Mixed
     */
    public function getObjsMbqEtForumTopic($var, $mbqOpt) {
        if ($mbqOpt['case'] == 'byForum') {
            $oMbqEtForum = $var;
            if ($mbqOpt['oMbqDataPage']) {
                $oMbqDataPage = $mbqOpt['oMbqDataPage'];
                if ($mbqOpt['top']) {
                    require_once(MBQ_APPEXTENTION_PATH.'ExttMbqKunenaModelTopics.php');
                    $oExttMbqKunenaModelTopics = new ExttMbqKunenaModelTopics();
                    $arr = $oExttMbqKunenaModelTopics->exttMbqGetRecentTopics(array('catId' => $oMbqEtForum->forumId->oriValue, 'start' => $oMbqDataPage->startNum, 'limit' => $oMbqDataPage->numPerPage, 'mode' => 'sticky'));
                    $objsKunenaForumTopic = $arr['topics'];
                    $oMbqDataPage->totalNum = $arr['total'];
                } else {
                    require_once(MBQ_APPEXTENTION_PATH.'ExttMbqKunenaModelCategory.php');
                    $oExttMbqKunenaModelCategory = new ExttMbqKunenaModelCategory();
                    //$oExttMbqKunenaModelCategory->setState('item.id', $oMbqEtForum->forumId->oriValue);
                    //$oExttMbqKunenaModelCategory->setState('list.start', $oMbqDataPage->startNum);
                    //$oExttMbqKunenaModelCategory->setState('list.limit', $oMbqDataPage->numPerPage);
                    $objsKunenaForumTopic = $oExttMbqKunenaModelCategory->exttMbqGetTopics(array('catId' => $oMbqEtForum->forumId->oriValue, 'start' => $oMbqDataPage->startNum, 'limit' => $oMbqDataPage->numPerPage));
                }
                /* common begin */
                $mbqOpt['case'] = 'byObjsKunenaForumTopic';
                $mbqOpt['oMbqDataPage'] = $oMbqDataPage;
                return $this->getObjsMbqEtForumTopic($objsKunenaForumTopic, $mbqOpt);
                /* common end */
            }
        } elseif ($mbqOpt['case'] == 'subscribed') {
            if ($mbqOpt['oMbqDataPage']) {
                $oMbqDataPage = $mbqOpt['oMbqDataPage'];
                $arr = KunenaForumTopicHelper::getLatestTopics(false, $oMbqDataPage->startNum, $oMbqDataPage->numPerPage, array('subscribed' => 1, 'user' => $var));
                $oMbqDataPage->totalNum = $arr[0];
                $objsKunenaForumTopic = $arr[1];
                /* common begin */
                $mbqOpt['case'] = 'byObjsKunenaForumTopic';
                $mbqOpt['oMbqDataPage'] = $oMbqDataPage;
                return $this->getObjsMbqEtForumTopic($objsKunenaForumTopic, $mbqOpt);
                /* common end */
            }
        } elseif ($mbqOpt['case'] == 'byTopicIds') {
            $objsKunenaForumTopic = KunenaForumTopicHelper::getTopics($var);
            /* common begin */
            $mbqOpt['case'] = 'byObjsKunenaForumTopic';
            return $this->getObjsMbqEtForumTopic($objsKunenaForumTopic, $mbqOpt);
            /* common end */
        } elseif ($mbqOpt['case'] == 'byObjsKunenaForumTopic') {
            $objsKunenaForumTopic = $var;
            /* common begin */
            $objsMbqEtForumTopic = array();
            $authorUserIds = array();
            $forumIds = array();
            foreach ($objsKunenaForumTopic as $oKunenaForumTopic) {
                $objsMbqEtForumTopic[] = $this->initOMbqEtForumTopic($oKunenaForumTopic, array('case' => 'oKunenaForumTopic', 'withAuthor' => false, 'oMbqEtForum' => false));
            }
            foreach ($objsMbqEtForumTopic as $oMbqEtForumTopic) {
                $authorUserIds[$oMbqEtForumTopic->topicAuthorId->oriValue] = $oMbqEtForumTopic->topicAuthorId->oriValue;
                $forumIds[$oMbqEtForumTopic->forumId->oriValue] = $oMbqEtForumTopic->forumId->oriValue;
            }
            /* load oMbqEtForum property */
            $oMbqRdEtForum = MbqMain::$oClk->newObj('MbqRdEtForum');
            $objsMbqEtForum = $oMbqRdEtForum->getObjsMbqEtForum($forumIds, array('case' => 'byForumIds'));
            foreach ($objsMbqEtForum as $oNewMbqEtForum) {
                foreach ($objsMbqEtForumTopic as &$oMbqEtForumTopic) {
                    if ($oNewMbqEtForum->forumId->oriValue == $oMbqEtForumTopic->forumId->oriValue) {
                        $oMbqEtForumTopic->oMbqEtForum = $oNewMbqEtForum;
                    }
                }
            }
            /* load topic author */
            $oMbqRdEtUser = MbqMain::$oClk->newObj('MbqRdEtUser');
            $objsAuthorMbqEtUser = $oMbqRdEtUser->getObjsMbqEtUser($authorUserIds, array('case' => 'byUserIds'));
            foreach ($objsMbqEtForumTopic as &$oMbqEtForumTopic) {
                foreach ($objsAuthorMbqEtUser as $oAuthorMbqEtUser) {
                    if ($oMbqEtForumTopic->topicAuthorId->oriValue == $oAuthorMbqEtUser->userId->oriValue) {
                        $oMbqEtForumTopic->oAuthorMbqEtUser = $oAuthorMbqEtUser;
                        break;
                    }
                }
            }
            foreach ($objsMbqEtForumTopic as &$oMbqEtForumTopic) {
                $this->makeProperty($oMbqEtForumTopic, 'byOAuthorMbqEtUser');
            }
            if ($mbqOpt['oMbqDataPage']) {
                $oMbqDataPage = $mbqOpt['oMbqDataPage'];
                $oMbqDataPage->datas = $objsMbqEtForumTopic;
                return $oMbqDataPage;
            } else {
                return $objsMbqEtForumTopic;
            }
            /* common end */
        }
        MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_CASE);
    }
    
    /**
     * init one forum topic by condition
     *
     * @param  Mixed  $var
     * @param  Array  $mbqOpt
     * $mbqOpt['case'] = 'oKunenaForumTopic' means init forum topic by KunenaForumCategory obj
     * $mbqOpt['case'] = 'byTopicId' means init forum topic by topic id
     * $mbqOpt['withAuthor'] = true means load topic author,default is true
     * $mbqOpt['oMbqEtForum'] = true means load oMbqEtForum property of this topic,default is true
     * $mbqOpt['oFirstMbqEtForumPost'] = true means load oFirstMbqEtForumPost property of this topic,default is true
     * @return  Mixed
     */
    public function initOMbqEtForumTopic($var, $mbqOpt) {
        $mbqOpt['withAuthor'] = isset($mbqOpt['withAuthor']) ? $mbqOpt['withAuthor'] : true;
        $mbqOpt['oMbqEtForum'] = isset($mbqOpt['oMbqEtForum']) ? $mbqOpt['oMbqEtForum'] : true;
        $mbqOpt['oFirstMbqEtForumPost'] = isset($mbqOpt['oFirstMbqEtForumPost']) ? $mbqOpt['oFirstMbqEtForumPost'] : true;
        if ($mbqOpt['case'] == 'oKunenaForumTopic') {
            $oMbqEtForumTopic = MbqMain::$oClk->newObj('MbqEtForumTopic');
            $oMbqEtForumTopic->totalPostNum->setOriValue($var->posts);
            $oMbqEtForumTopic->topicId->setOriValue($var->id);
            $oMbqEtForumTopic->forumId->setOriValue($var->category_id);
            $oMbqEtForumTopic->firstPostId->setOriValue($var->first_post_id);
            $oMbqEtForumTopic->topicTitle->setOriValue($var->subject);
            $oMbqEtForumTopic->topicContent->setOriValue($var->first_post_message);
            $oMbqEtForumTopic->shortContent->setOriValue(MbqMain::$oMbqCm->getShortContent($var->first_post_message));
            $oMbqEtForumTopic->topicAuthorId->setOriValue($var->first_post_userid);
            $oMbqEtForumTopic->lastReplyAuthorId->setOriValue($var->last_post_userid);
            $oMbqEtForumTopic->postTime->setOriValue($var->first_post_time);
            $oMbqEtForumTopic->lastReplyTime->setOriValue($var->last_post_time);
            $oMbqEtForumTopic->replyNumber->setOriValue(($var->posts > 0) ? ($var->posts - 1) : $var->posts);
            $oMbqEtForumTopic->newPost->setOriValue($var->unread ? MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.newPost.range.yes') : MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.newPost.range.no'));
            $oMbqEtForumTopic->viewNumber->setOriValue($var->hits);
            $oMbqEtForumTopic->mbqBind['oKunenaForumTopic'] = $var;
            if ($mbqOpt['oMbqEtForum']) {
                /* load oMbqEtForum property */
                $this->makeProperty($oMbqEtForumTopic, 'oMbqEtForum');
            }
            if ($mbqOpt['withAuthor']) {
                /* load topic author */
                $this->makeProperty($oMbqEtForumTopic, 'oAuthorMbqEtUser');
            }
            $this->makeProperty($oMbqEtForumTopic, 'byOAuthorMbqEtUser');
            if ($mbqOpt['oFirstMbqEtForumPost']) {
                /* load oFirstMbqEtForumPost author */
                $this->makeProperty($oMbqEtForumTopic, 'oFirstMbqEtForumPost');
            }
            if ($oMbqEtForumTopic->oFirstMbqEtForumPost && $oMbqEtForumTopic->oFirstMbqEtForumPost->mbqBind['oKunenaForumMessage'] && $oMbqEtForumTopic->oFirstMbqEtForumPost->mbqBind['oKunenaForumMessage']->authorise('reply')) {
                $oMbqEtForumTopic->canReply->setOriValue(MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.canReply.range.yes'));
            } else {
                $oMbqEtForumTopic->canReply->setOriValue(MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.canReply.range.no'));
            }
            return $oMbqEtForumTopic;
        } elseif ($mbqOpt['case'] == 'byTopicId') {
            $topicId = $var;
            require_once(MBQ_APPEXTENTION_PATH.'ExttMbqKunenaModelTopic.php');
            $oExttMbqKunenaModelTopic = new ExttMbqKunenaModelTopic();
            //$oExttMbqKunenaModelTopic->setState('item.id', $topicId);
            if (($oKunenaForumTopic = $oExttMbqKunenaModelTopic->exttMbqGetTopic(array('topicId' => $topicId))) && $oKunenaForumTopic->id) {
                $mbqOpt['case'] = 'oKunenaForumTopic';
                return $this->initOMbqEtForumTopic($oKunenaForumTopic, $mbqOpt);
            }
            return false;
        }
        MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_CASE);
    }
  
}

?>