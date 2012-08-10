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
  
}

?>