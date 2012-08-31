<?php

defined('MBQ_IN_IT') or exit;

/**
 * logout_user action
 * 
 * @since  2012-8-27
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqActLogoutUser extends MbqBaseAct {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * action implement
     */
    public function actionImplement() {
        if (!MbqMain::$oMbqConfig->moduleIsEnable('user')) {
            MbqError::alert('', "Not support module user!", '', MBQ_ERR_NOT_SUPPORT);
        }
        $oMbqRdEtUser = MbqMain::$oClk->newObj('MbqRdEtUser');
        $result = $oMbqRdEtUser->logout();
        if ($result) {
            $this->data['result'] = true;
        } else {
            $this->data['result'] = false;
        }
    }
  
}

?>