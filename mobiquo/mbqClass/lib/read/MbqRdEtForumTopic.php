<?php

defined('MBQ_IN_IT') or exit;

/**
 * forum topic read class
 * 
 * @since  2012-8-8
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqRdEtForumTopic extends MbqBaseRd {
    
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
            default:
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_PNAME);
            break;
        }
    }
    
    /**
     * return forum topic api data
     *
     * @param  Object  $oMbqEtForumTopic
     * @return  Array
     */
    public function returnApiDataForumTopic($oMbqEtForumTopic) {
        $data = array();
        if ($oMbqEtForumTopic->totalPostNum->hasSetOriValue()) {
            $data['total_post_num'] = (int) $oMbqEtForumTopic->totalPostNum->oriValue;
        }
        if ($oMbqEtForumTopic->topicId->hasSetOriValue()) {
            $data['topic_id'] = (string) $oMbqEtForumTopic->topicId->oriValue;
        }
        if ($oMbqEtForumTopic->forumId->hasSetOriValue()) {
            $data['forum_id'] = (string) $oMbqEtForumTopic->forumId->oriValue;
        }
        if ($oMbqEtForumTopic->topicTitle->hasSetOriValue()) {
            $data['topic_title'] = (string) $oMbqEtForumTopic->topicTitle->oriValue;
        }
        $data['short_content'] = (string) MbqMain::$oMbqCm->getShortContent($oMbqEtForumTopic->topicContent->oriValue);
        if ($oMbqEtForumTopic->prefixId->hasSetOriValue()) {
            $data['prefix_id'] = (string) $oMbqEtForumTopic->prefixId->oriValue;
        }
        if ($oMbqEtForumTopic->prefixName->hasSetOriValue()) {
            $data['prefix'] = (string) $oMbqEtForumTopic->prefixName->oriValue;
        }
        if ($oMbqEtForumTopic->topicAuthorId->hasSetOriValue()) {
            $data['topic_author_id'] = (string) $oMbqEtForumTopic->topicAuthorId->oriValue;
        }
        if ($oMbqEtForumTopic->oAuthorMbqEtUser) {
            $data['topic_author_name'] = (string) $oMbqEtForumTopic->oAuthorMbqEtUser->getDisplayName();
        }
        if ($oMbqEtForumTopic->attachmentIdArray->hasSetOriValue()) {
            $data['attachment_id_array'] = (array) $oMbqEtForumTopic->attachmentIdArray->oriValue;
        }
        if ($oMbqEtForumTopic->groupId->hasSetOriValue()) {
            $data['group_id'] = (string) $oMbqEtForumTopic->groupId->oriValue;
        }
        if ($oMbqEtForumTopic->state->hasSetOriValue()) {
            $data['state'] = (int) $oMbqEtForumTopic->state->oriValue;
        }
        if ($oMbqEtForumTopic->isSubscribed->hasSetOriValue()) {
            $data['is_subscribed'] = (boolean) $oMbqEtForumTopic->isSubscribed->oriValue;
        }
        if ($oMbqEtForumTopic->canSubscribe->hasSetOriValue()) {
            $data['can_subscribe'] = (boolean) $oMbqEtForumTopic->canSubscribe->oriValue;
        }
        if ($oMbqEtForumTopic->isClosed->hasSetOriValue()) {
            $data['is_closed'] = (boolean) $oMbqEtForumTopic->isClosed->oriValue;
        }
        if ($oMbqEtForumTopic->postTime->hasSetOriValue()) {
            $data['post_time'] = (string) MbqMain::$oMbqCm->datetimeIso8601Encode($oMbqEtForumTopic->postTime->oriValue);
        }
        if ($oMbqEtForumTopic->lastReplyTime->hasSetOriValue()) {
            $data['last_reply_time'] = (string) MbqMain::$oMbqCm->datetimeIso8601Encode($oMbqEtForumTopic->lastReplyTime->oriValue);
        }
        if ($oMbqEtForumTopic->replyNumber->hasSetOriValue()) {
            $data['reply_number'] = (int) $oMbqEtForumTopic->replyNumber->oriValue;
        }
        if ($oMbqEtForumTopic->newPost->hasSetOriValue()) {
            $data['new_post'] = (boolean) $oMbqEtForumTopic->newPost->oriValue;
        }
        if ($oMbqEtForumTopic->viewNumber->hasSetOriValue()) {
            $data['view_number'] = (int) $oMbqEtForumTopic->viewNumber->oriValue;
        }
        if ($oMbqEtForumTopic->participatedUids->hasSetOriValue()) {
            $data['participated_uids'] = (array) MbqMain::$oMbqCm->changeArrValueToString($oMbqEtForumTopic->participatedUids->oriValue);
        }
        if ($oMbqEtForumTopic->canUpload->hasSetOriValue()) {
            $data['can_upload'] = (boolean) $oMbqEtForumTopic->canUpload->oriValue;
        }
        if ($oMbqEtForumTopic->canThank->hasSetOriValue()) {
            $data['can_thank'] = (boolean) $oMbqEtForumTopic->canThank->oriValue;
        }
        if ($oMbqEtForumTopic->thankCount->hasSetOriValue()) {
            $data['thank_count'] = (int) $oMbqEtForumTopic->thankCount->oriValue;
        }
        if ($oMbqEtForumTopic->canLike->hasSetOriValue()) {
            $data['can_like'] = (boolean) $oMbqEtForumTopic->canLike->oriValue;
        }
        if ($oMbqEtForumTopic->isLiked->hasSetOriValue()) {
            $data['is_liked'] = (boolean) $oMbqEtForumTopic->isLiked->oriValue;
        }
        if ($oMbqEtForumTopic->likeCount->hasSetOriValue()) {
            $data['like_count'] = (int) $oMbqEtForumTopic->likeCount->oriValue;
        }
        if ($oMbqEtForumTopic->canDelete->hasSetOriValue()) {
            $data['can_delete'] = (boolean) $oMbqEtForumTopic->canDelete->oriValue;
        }
        if ($oMbqEtForumTopic->isDeleted->hasSetOriValue()) {
            $data['is_deleted'] = (boolean) $oMbqEtForumTopic->isDeleted->oriValue;
        }
        if ($oMbqEtForumTopic->canApprove->hasSetOriValue()) {
            $data['can_approve'] = (boolean) $oMbqEtForumTopic->canApprove->oriValue;
        }
        if ($oMbqEtForumTopic->isApproved->hasSetOriValue()) {
            $data['is_approved'] = (boolean) $oMbqEtForumTopic->isApproved->oriValue;
        }
        if ($oMbqEtForumTopic->canStick->hasSetOriValue()) {
            $data['can_stick'] = (boolean) $oMbqEtForumTopic->canStick->oriValue;
        }
        if ($oMbqEtForumTopic->isSticky->hasSetOriValue()) {
            $data['is_sticky'] = (boolean) $oMbqEtForumTopic->isSticky->oriValue;
        }
        if ($oMbqEtForumTopic->canClose->hasSetOriValue()) {
            $data['can_close'] = (boolean) $oMbqEtForumTopic->canClose->oriValue;
        }
        if ($oMbqEtForumTopic->canRename->hasSetOriValue()) {
            $data['can_rename'] = (boolean) $oMbqEtForumTopic->canRename->oriValue;
        }
        if ($oMbqEtForumTopic->canMove->hasSetOriValue()) {
            $data['can_move'] = (boolean) $oMbqEtForumTopic->canMove->oriValue;
        }
        if ($oMbqEtForumTopic->modByUserId->hasSetOriValue()) {
            $data['moderated_by_id'] = (string) $oMbqEtForumTopic->modByUserId->oriValue;
        }
        if ($oMbqEtForumTopic->deleteByUserId->hasSetOriValue()) {
            $data['deleted_by_id'] = (string) $oMbqEtForumTopic->deleteByUserId->oriValue;
        }
        if ($oMbqEtForumTopic->deleteReason->hasSetOriValue()) {
            $data['delete_reason'] = (string) $oMbqEtForumTopic->deleteReason->oriValue;
        }
        if ($oMbqEtForumTopic->canReply->hasSetOriValue()) {
            $data['can_reply'] = (boolean) $oMbqEtForumTopic->canReply->oriValue;
        }
        return $data;
    }
    
    /**
     * return forum topic array api data
     *
     * @param  Array  $objsMbqEtForumTopic
     * @return  Array
     */
    public function returnApiArrDataForumTopic($objsMbqEtForumTopic) {
        $data = array();
        foreach ($objsMbqEtForumTopic as $oMbqEtForumTopic) {
            $data[] = $this->returnApiDataForumTopic($oMbqEtForumTopic);
        }
        return $data;
    }
    
    /**
     * get forum topic objs
     *
     * @param  Mixed  $var
     * @param  Array  $mbqOpt
     * $mbqOpt['case'] = 'byForum' means get data by forum obj.$var is the forum obj.
     * @return  Mixed
     */
    public function getObjsMbqEtForumTopic($var, $mbqOpt) {
        if ($mbqOpt['case'] == 'byForum') {
            $oMbqEtForum = $var;
            if ($mbqOpt['oMbqDataPage']) {
                $oMbqDataPage = $mbqOpt['oMbqDataPage'];
                require_once(MBQ_APPEXTENTION_PATH.'ExttMbqKunenaModelCategory.php');
                $oExttMbqKunenaModelCategory = new ExttMbqKunenaModelCategory();
                //$oExttMbqKunenaModelCategory->setState('item.id', $oMbqEtForum->forumId->oriValue);
                //$oExttMbqKunenaModelCategory->setState('list.start', $oMbqDataPage->startNum);
                //$oExttMbqKunenaModelCategory->setState('list.limit', $oMbqDataPage->numPerPage);
                $objsKunenaForumTopic = $oExttMbqKunenaModelCategory->exttMbqGetTopics(array('catId' => $oMbqEtForum->forumId->oriValue, 'start' => $oMbqDataPage->startNum, 'limit' => $oMbqDataPage->numPerPage));
                $objsMbqEtForumTopic = array();
                $authorUserIds = array();
                foreach ($objsKunenaForumTopic as $oKunenaForumTopic) {
                    $objsMbqEtForumTopic[] = $this->initOMbqEtForumTopic($oKunenaForumTopic, array('case' => 'oKunenaForumTopic', 'withAuthor' => false));
                }
                foreach ($objsMbqEtForumTopic as $oMbqEtForumTopic) {
                    $authorUserIds[$oMbqEtForumTopic->topicAuthorId->oriValue] = $oMbqEtForumTopic->topicAuthorId->oriValue;
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
                $oMbqDataPage->datas = $objsMbqEtForumTopic;
                return $oMbqDataPage;
            }
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
     * @return  Mixed
     */
    public function initOMbqEtForumTopic($var, $mbqOpt) {
        $mbqOpt['withAuthor'] = isset($mbqOpt['withAuthor']) ? $mbqOpt['withAuthor'] : true;
        if ($mbqOpt['case'] == 'oKunenaForumTopic') {
            $oMbqEtForumTopic = MbqMain::$oClk->newObj('MbqEtForumTopic');
            $oMbqEtForumTopic->totalPostNum->setOriValue($var->posts);
            $oMbqEtForumTopic->topicId->setOriValue($var->id);
            $oMbqEtForumTopic->forumId->setOriValue($var->category_id);
            $oMbqEtForumTopic->firstPostId->setOriValue($var->first_post_id);
            $oMbqEtForumTopic->topicTitle->setOriValue($var->subject);
            $oMbqEtForumTopic->topicContent->setOriValue($var->first_post_message);
            $oMbqEtForumTopic->topicAuthorId->setOriValue($var->first_post_userid);
            $oMbqEtForumTopic->lastReplyAuthorId->setOriValue($var->last_post_userid);
            $oMbqEtForumTopic->postTime->setOriValue($var->first_post_time);
            $oMbqEtForumTopic->lastReplyTime->setOriValue($var->last_post_time);
            $oMbqEtForumTopic->replyNumber->setOriValue($var->posts - 1);
            $oMbqEtForumTopic->newPost->setOriValue($var->unread ? MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.newPost.range.yes') : MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.newPost.range.no'));
            $oMbqEtForumTopic->viewNumber->setOriValue($var->hits);
            $oMbqEtForumTopic->mbqBind['oKunenaForumTopic'] = $var;
            if ($mbqOpt['withAuthor']) {
                /* load topic author */
                $this->makeProperty($oMbqEtForumTopic, 'oAuthorMbqEtUser');
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