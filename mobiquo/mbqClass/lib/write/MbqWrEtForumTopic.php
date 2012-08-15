<?php

defined('MBQ_IN_IT') or exit;

/**
 * forum topic write class
 * 
 * @since  2012-8-15
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqWrEtForumTopic extends MbqBaseWr {
    
    public function __construct() {
    }
    
    /**
     * add forum topic view num
     *
     * @param  Mixed  $var($oMbqEtForumTopic or $objsMbqEtForumTopic)
     */
    public function addForumTopicViewNum($var) {
        if (is_array($var)) {
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_NOT_ACHIEVE);
        } else {
            $var->mbqBind['oKunenaForumTopic']->hit();
        }
    }
    
    /**
     * mark forum topic read
     *
     * @param  Mixed  $var($oMbqEtForumTopic or $objsMbqEtForumTopic)
     */
    public function markForumTopicRead($var) {
        if (is_array($var)) {
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_NOT_ACHIEVE);
        } else {
            $var->mbqBind['oKunenaForumTopic']->markRead();
        }
    }
    
    /**
     * reset forum topic subscription
     *
     * @param  Mixed  $var($oMbqEtForumTopic or $objsMbqEtForumTopic)
     */
    public function resetForumTopicSubscription($var) {
        if (is_array($var)) {
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_NOT_ACHIEVE);
        } else {
            $var->mbqBind['oKunenaForumTopic']->markRead();
            // Check is subscriptions have been sent and reset the value
            if ($var->mbqBind['oKunenaForumTopic']->authorise('subscribe')) {
                $usertopic = $var->mbqBind['oKunenaForumTopic']->getUserTopic();
                if ($usertopic->subscribed == 2) {
                    $usertopic->subscribed = 1;
                    $usertopic->save();
                }
            }
        }
    }
  
}

?>