<?php

defined('MBQ_IN_IT') or exit;

MbqMain::$oClk->includeClass('MbqBaseAclEtForumPost');

/**
 * forum post acl class
 * 
 * @since  2012-8-20
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqAclEtForumPost extends MbqBaseAclEtForumPost {
    
    public function __construct() {
    }
    
    /**
     * judge can reply post
     *
     * @param  Object  $oMbqEtForumPost
     * @return  Boolean
     */
    public function canAclReplyPost($oMbqEtForumPost) {
        if ($oMbqEtForumPost->mbqBind['oKunenaForumMessage'] && $oMbqEtForumPost->mbqBind['oKunenaForumMessage']->authorise('reply')) {
            return true;
        }
        return false;
    }
    
    /**
     * judge can get quote post
     *
     * @param  Object  $oMbqEtForumPost
     * @return  Boolean
     */
    public function canAclGetQuotePost($oMbqEtForumPost) {
        return $this->canAclReplyPost($oMbqEtForumPost);
    }
    
    /**
     * judge can search_post
     *
     * @return  Boolean
     */
    public function canAclSearchPost() {
        if (MbqMain::$oMbqConfig->getCfg('forum.guest_search')->oriValue == MbqBaseFdt::getFdt('MbqFdtConfig.forum.guest_search.range.support')) {
            return true;
        } else {
            return MbqMain::hasLogin();
        }
    }
  
}

?>