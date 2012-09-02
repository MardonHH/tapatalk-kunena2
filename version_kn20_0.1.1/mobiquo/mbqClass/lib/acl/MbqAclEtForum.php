<?php

defined('MBQ_IN_IT') or exit;

/**
 * forum acl class
 * 
 * @since  2012-8-8
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqAclEtForum extends MbqBaseAcl {
    
    public function __construct() {
    }
    
    /**
     * judge can get subscribed forum
     *
     * @return  Boolean
     */
    public function canAclGetSubscribedForum() {
        return MbqMain::hasLogin();
    }
  
}

?>