<?php

defined('MBQ_IN_IT') or exit;

/**
 * forum topic acl class
 * 
 * @since  2012-8-10
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqAclEtForumTopic extends MbqBaseAcl {
    
    public function __construct() {
    }
    
    /**
     * judge can get topic from the forum
     *
     * @param  Object  $oMbqEtForum
     * @return  Boolean
     */
    public function canAclGetTopic($oMbqEtForum) {
        if ($oMbqEtForum->mbqBind['oKunenaForumCategory'] && $oMbqEtForum->mbqBind['oKunenaForumCategory']->authorise('read')) {
            return true;
        }
        return false;
    }
    
    /**
     * judge can get thread
     *
     * @param  Object  $oMbqEtForumTopic
     * @return  Boolean
     */
    public function canAclGetThread($oMbqEtForumTopic) {
        if ($oMbqEtForumTopic->mbqBind['oKunenaForumTopic'] && $oMbqEtForumTopic->mbqBind['oKunenaForumTopic']->authorise('read') && KunenaForumMessageHelper::get($oMbqEtForumTopic->mbqBind['oKunenaForumTopic']->first_post_id)->exists()) {
            return true;
        }
        return false;
    }
    
    /**
     * judge can new topic
     *
     * @param  Object  $oMbqEtForumTopic
     * @return  Boolean
     */
    public function canAclNewTopic($oMbqEtForum) {
        if ($oMbqEtForum->mbqBind['oKunenaForumCategory'] && $oMbqEtForum->mbqBind['oKunenaForumCategory']->authorise('topic.create')) {
            return true;
        }
        return false;
    }
    
    /**
     * judge can get subscribed topic
     *
     * @return  Boolean
     */
    public function canAclGetSubscribedTopic() {
        return MbqMain::hasLogin();
    }
  
}

?>