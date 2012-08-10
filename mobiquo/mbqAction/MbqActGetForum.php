<?php

defined('MBQ_IN_IT') or exit;

/**
 * get_forum action
 * 
 * @since  2012-8-3
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqActGetForum extends MbqBaseAct {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * action implement
     */
    public function actionImplement() {
        if (!MbqMain::$oMbqConfig->moduleIsEnable('forum')) {
            MbqError::alert('', "Not support module forum!", '', MBQ_ERR_NOT_SUPPORT);
        }
        $data = & MbqMain::$data;
        $oMbqRdEtForum = MbqMain::$oClk->newObj('MbqRdEtForum');
        $tree = $oMbqRdEtForum->getForumTree();
        $data = $oMbqRdEtForum->returnApiTreeDataForum($tree);
    }
  
}

?>