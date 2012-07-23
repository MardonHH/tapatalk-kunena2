<?php

defined('MBQ_IN_IT') or exit;

/**
 * forum topic class
 * 
 * @since  2012-7-8
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqEtForumTopic extends MbqBaseEntity {
    
    public $topicId;
    public $forumId;
    public $topicTitle;
    public $topicContent;
    public $prefixId;
    public $topicAuthorId;
    public $lastReplyAuthorId;
    public $attachMentIdArray;
    public $groupId;
    public $state;  /* 1 = post is success but need moderation. Otherwise no need to return this key. */
    public $isSubscribed;   /* return true if this thread has been subscribed by this user */
    public $canSubscribe;   /* returns false if the subscription feature is turned off */
    public $isClosed;       /* return true if this thread has been closed. */
    public $postTime;       /* dateTime.iso8601 format. If this topic has no reply, use the topic creation time. */
    public $lastReplyTime;  /* dateTime.iso8601 format. If this topic has no reply, use the topic creation time. */
    public $replyNumber;    /* total number of reply in this topic. If this is no reply in this return, return 0. */
    public $newPost;        /* return true if this topic contains new post since user last login */
    public $replyNumber;    /* total number of reply in this topic. If this is no reply in this return, return 0. */
    public $viewNumber;     /* total number of view in this topic */
    public $participatedUids;
    public $canUpload;  /* return true if the user has authority to upload attachments in this thread. */
    public $canThank;
    public $thankCount;
    public $canLike;
    public $isLiked;
    public $likeCount;
    public $canDelete;
    public $isDeleted;
    public $canApprove;
    public $isApproved;
    public $canStick;   /* return true if the user has authority to stick or unstick this topic. */
    public $isSticky;   /* return true if this topic is set as sticky mode. */
    public $canClose;   /* return true if the user has authority to close this topic. */
    public $canRename;  /* return true if the user has authority to rename this topic. */
    public $canMove;    /* return true if the user has authority to move this topic to somewhere else. */
    public $modByUserId;    /* If this topic has already been moderated, return the user id of the person who moderated this topic */
    public $deleteByUserId; /* return the user id of the person who has previously soft-deleted this topic */
    public $deleteReason;   /* return reason of deletion, if any. */
    
    public $objsMbqEtAtt;
    public $objsMbqEtForumPost;
    
    public function __construct() {
        parent::__construct();
        $this->topicId = clone MbqMain::$simpleV;
        $this->forumId = clone MbqMain::$simpleV;
        $this->topicTitle = clone MbqMain::$simpleV;
        $this->topicContent = clone MbqMain::$simpleV;
        $this->prefixId = clone MbqMain::$simpleV;
        $this->topicAuthorId = clone MbqMain::$simpleV;
        $this->lastReplyAuthorId = clone MbqMain::$simpleV;
        $this->attachMentIdArray = clone MbqMain::$simpleV;
        $this->state = clone MbqMain::$simpleV;
        $this->groupId = clone MbqMain::$simpleV;
        $this->isSubscribed = clone MbqMain::$simpleV;
        $this->canSubscribe = clone MbqMain::$simpleV;
        $this->isClosed = clone MbqMain::$simpleV;
        $this->postTime = clone MbqMain::$simpleV;
        $this->lastReplyTime = clone MbqMain::$simpleV;
        $this->replyNumber = clone MbqMain::$simpleV;
        $this->newPost = clone MbqMain::$simpleV;
        $this->replyNumber = clone MbqMain::$simpleV;
        $this->viewNumber = clone MbqMain::$simpleV;
        $this->participatedUids = clone MbqMain::$simpleV;
        $this->canUpload = clone MbqMain::$simpleV;
        $this->canThank = clone MbqMain::$simpleV;
        $this->thankCount = clone MbqMain::$simpleV;
        $this->canLike = clone MbqMain::$simpleV;
        $this->isLiked = clone MbqMain::$simpleV;
        $this->likeCount = clone MbqMain::$simpleV;
        $this->canDelete = clone MbqMain::$simpleV;
        $this->isDeleted = clone MbqMain::$simpleV;
        $this->canApprove = clone MbqMain::$simpleV;
        $this->isApproved = clone MbqMain::$simpleV;
        $this->canStick = clone MbqMain::$simpleV;
        $this->isSticky = clone MbqMain::$simpleV;
        $this->canClose = clone MbqMain::$simpleV;
        $this->canRename = clone MbqMain::$simpleV;
        $this->canMove = clone MbqMain::$simpleV;
        $this->modByUserId = clone MbqMain::$simpleV;
        $this->deleteByUserId = clone MbqMain::$simpleV;
        $this->deleteReason = clone MbqMain::$simpleV;
        
        $this->objsMbqEtAtt = array();
        $this->objsMbqEtForumPost = array();
    }
  
}

?>