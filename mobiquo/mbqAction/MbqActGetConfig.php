<?php

defined('MBQ_IN_IT') or exit;

/**
 * get_config action
 * 
 * @since  2012-7-30
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqActGetConfig extends MbqBaseAct {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * action implement
     */
    public function actionImplement() {
        $data = & MbqMain::$data;
        $cfg = MbqMain::$oMbqConfig->getAllCfg();
        foreach ($cfg as $moduleName => $module) {
            foreach ($module as $k => $v) {
                if ($k !== 'module_name' && $k != 'module_version' && $k != 'module_enable') {
                    if (isset($data[$k])) {
                        MbqError::alert('', "Find repeat config $k!");
                    } else {
                        if ($v->hasSetOriValue()) {
                            if ($k == 'is_open' || $k == 'guest_okay' || $k == 'min_search_length') {
                                $data[$k] = $v->oriValue;
                            } else {
                                $data[$k] = (string) $v->oriValue;
                            }
                        } else {
                            MbqError::alert('', "Need set config $k!");
                        }
                    }
                }
            }
        }
    }
  
}

?>