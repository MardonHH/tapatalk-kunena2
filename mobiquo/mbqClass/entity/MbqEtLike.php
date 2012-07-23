<?php

defined('MBQ_IN_IT') or exit;

/**
 * like class
 * 
 * @since  2012-7-14
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqEtLike extends MbqBaseEntity {
    
    public $key;    /* now only postId */
    public $userId; /* user id who liked this */
    public $type;   /* like post or other anything */
    
    public function __construct() {
        parent::__construct();
        $this->key = clone MbqMain::$simpleV;
        $this->userId = clone MbqMain::$simpleV;
        $this->type = clone MbqMain::$simpleV;
    }
  
}

?>