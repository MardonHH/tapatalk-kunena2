<?php

defined('MBQ_IN_IT') or exit;

/**
 * login action
 * 
 * @since  2012-8-5
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqActLogin extends MbqBaseAct {
    
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
        $data = & MbqMain::$data;
        $oMbqRdEtUser = MbqMain::$oClk->newObj('MbqRdEtUser');
        $result = $oMbqRdEtUser->login(MbqMain::$input[0], MbqMain::$input[1]);
        if ($result) {
            $data['result'] = true;
            $data1 = $oMbqRdEtUser->returnApiDataUser(MbqMain::$oCurMbqEtUser);
            MbqCm::mergeApiData($data, $data1);
        } else {
            $data['result'] = false;
        }
    }
  
}

?>