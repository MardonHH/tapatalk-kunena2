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
        if ($oMbqEtForumTopic->oMbqEtForum) {
            $data['forum_name'] = (string) $oMbqEtForumTopic->oMbqEtForum->forumName->oriValue;
        }
        if ($oMbqEtForumTopic->topicTitle->hasSetOriValue()) {
            $data['topic_title'] = (string) $oMbqEtForumTopic->topicTitle->oriValue;
        }
        $data['short_content'] = (string) $oMbqEtForumTopic->shortContent->oriValue;
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
            $data['post_author_name'] = (string) $oMbqEtForumTopic->oAuthorMbqEtUser->getDisplayName();
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
        } else {
            $data['can_subscribe'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.canSubscribe.default');
        }
        if ($oMbqEtForumTopic->isClosed->hasSetOriValue()) {
            $data['is_closed'] = (boolean) $oMbqEtForumTopic->isClosed->oriValue;
        }
        if ($oMbqEtForumTopic->postTime->hasSetOriValue()) {
            $data['post_time'] = (string) MbqMain::$oMbqCm->datetimeIso8601Encode($oMbqEtForumTopic->postTime->oriValue);
        }
        if ($oMbqEtForumTopic->authorIconUrl->hasSetOriValue()) {
            $data['icon_url'] = (string) $oMbqEtForumTopic->authorIconUrl->oriValue;
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
        } else {
            $data['can_upload'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.canUpload.default');
        }
        if ($oMbqEtForumTopic->canThank->hasSetOriValue()) {
            $data['can_thank'] = (boolean) $oMbqEtForumTopic->canThank->oriValue;
        } else {
            $data['can_thank'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.canThank.default');
        }
        if ($oMbqEtForumTopic->thankCount->hasSetOriValue()) {
            $data['thank_count'] = (int) $oMbqEtForumTopic->thankCount->oriValue;
        }
        if ($oMbqEtForumTopic->canLike->hasSetOriValue()) {
            $data['can_like'] = (boolean) $oMbqEtForumTopic->canLike->oriValue;
        } else {
            $data['can_like'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.canLike.default');
        }
        if ($oMbqEtForumTopic->isLiked->hasSetOriValue()) {
            $data['is_liked'] = (boolean) $oMbqEtForumTopic->isLiked->oriValue;
        }
        if ($oMbqEtForumTopic->likeCount->hasSetOriValue()) {
            $data['like_count'] = (int) $oMbqEtForumTopic->likeCount->oriValue;
        }
        if ($oMbqEtForumTopic->canDelete->hasSetOriValue()) {
            $data['can_delete'] = (boolean) $oMbqEtForumTopic->canDelete->oriValue;
        } else {
            $data['can_delete'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.canDelete.default');
        }
        if ($oMbqEtForumTopic->isDeleted->hasSetOriValue()) {
            $data['is_deleted'] = (boolean) $oMbqEtForumTopic->isDeleted->oriValue;
        }
        if ($oMbqEtForumTopic->canApprove->hasSetOriValue()) {
            $data['can_approve'] = (boolean) $oMbqEtForumTopic->canApprove->oriValue;
        } else {
            $data['can_approve'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.canApprove.default');
        }
        if ($oMbqEtForumTopic->isApproved->hasSetOriValue()) {
            $data['is_approved'] = (boolean) $oMbqEtForumTopic->isApproved->oriValue;
        }
        if ($oMbqEtForumTopic->canStick->hasSetOriValue()) {
            $data['can_stick'] = (boolean) $oMbqEtForumTopic->canStick->oriValue;
        } else {
            $data['can_stick'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.canStick.default');
        }
        if ($oMbqEtForumTopic->isSticky->hasSetOriValue()) {
            $data['is_sticky'] = (boolean) $oMbqEtForumTopic->isSticky->oriValue;
        }
        if ($oMbqEtForumTopic->canClose->hasSetOriValue()) {
            $data['can_close'] = (boolean) $oMbqEtForumTopic->canClose->oriValue;
        } else {
            $data['can_close'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.canClose.default');
        }
        if ($oMbqEtForumTopic->canRename->hasSetOriValue()) {
            $data['can_rename'] = (boolean) $oMbqEtForumTopic->canRename->oriValue;
        } else {
            $data['can_rename'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.canRename.default');
        }
        if ($oMbqEtForumTopic->canMove->hasSetOriValue()) {
            $data['can_move'] = (boolean) $oMbqEtForumTopic->canMove->oriValue;
        } else {
            $data['can_move'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.canMove.default');
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
        } else {
            $data['can_reply'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumTopic.canReply.default');
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
     * $mbqOpt['case'] = 'subscribed' means get subscribed data.$var is the user id.
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
                $oMbqDataPage->datas = $objsMbqEtForumTopic;
                return $oMbqDataPage;
                /* common end */
            }
        } elseif ($mbqOpt['case'] == 'subscribed') {
            if ($mbqOpt['oMbqDataPage']) {
                $oMbqDataPage = $mbqOpt['oMbqDataPage'];
                $arr = $objsKunenaForumTopic = KunenaForumTopicHelper::getLatestTopics(false, $oMbqDataPage->startNum, $oMbqDataPage->numPerPage, array('subscribed' => 1, 'user' => $var));
                $oMbqDataPage->totalNum = $arr[0];
                $objsKunenaForumTopic = $arr[1];
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
                $oMbqDataPage->datas = $objsMbqEtForumTopic;
                return $oMbqDataPage;
                /* common end */
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
     * $mbqOpt['oMbqEtForum'] = true means load oMbqEtForum property of this topic,default is true
     * @return  Mixed
     */
    public function initOMbqEtForumTopic($var, $mbqOpt) {
        $mbqOpt['withAuthor'] = isset($mbqOpt['withAuthor']) ? $mbqOpt['withAuthor'] : true;
        $mbqOpt['oMbqEtForum'] = isset($mbqOpt['oMbqEtForum']) ? $mbqOpt['oMbqEtForum'] : true;
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
            $this->makeProperty($oMbqEtForumTopic, 'oFirstMbqEtForumPost');
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