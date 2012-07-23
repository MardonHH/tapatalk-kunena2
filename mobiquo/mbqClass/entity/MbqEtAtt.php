<?php

defined('MBQ_IN_IT') or exit;

/**
 * attachment class
 * 
 * @since  2012-7-13
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqEtAtt extends MbqBaseEntity {
    
    public $attId;
    public $groupId;
    public $forumId;
    public $postId;
    public $filtersSize;
    public $uploadFileName;
    public $attType;    /* post att or user avatar */
    
    public function __construct() {
        parent::__construct();
        $this->attId = clone MbqMain::$simpleV;
        $this->groupId = clone MbqMain::$simpleV;
        $this->forumId = clone MbqMain::$simpleV;
        $this->postId = clone MbqMain::$simpleV;
        $this->filtersSize = clone MbqMain::$simpleV;
        $this->uploadFileName = clone MbqMain::$simpleV;
        $this->attType = clone MbqMain::$simpleV;
    }
  
}

?>