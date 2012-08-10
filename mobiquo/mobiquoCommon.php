<?php

define('MBQ_IN_IT', true);  /* is in mobiquo flag */
define('MBQ_DEBUG', true);  /* is in debug mode flag */

if (MBQ_DEBUG) {
    ini_set('display_errors','1');
    ini_set('display_startup_errors','1');
    //error_reporting(E_ALL);
    error_reporting(E_ALL ^ E_NOTICE);
} else {
    error_reporting(0);
}
set_time_limit(60);

require_once('MbqConfig.php');

/**
 * frame main program
 * 
 * @since  2012-7-2
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqMain extends MbqBaseMain {
    
    public static $oCurMbqEtUser;  /* current user obj after login. */

    public function __construct() {
        parent::__construct();
        MbqMain::$oMbqCm->changeWorkDir('..');  /* change work dir to parent dir. */
        ob_start();
    }
    
    /**
     * action
     */
    public function action() {
        self::$oMbqConfig->calCfg();    /* you should do some modify with this function in multiple different type applications! */
        if (!self::$oMbqConfig->pluginIsOpen()) {
            MbqError::alert('', "Plugin is not in service!");
        }
        if (self::$cmd) {
            self::$cmd = (string) self::$cmd;
            if (preg_match('/[A-Za-z0-9_]{1,128}/', self::$cmd)) {
                $arr = explode('_', self::$cmd);
                foreach ($arr as &$v) {
                    $v = ucfirst(strtolower($v));
                }
                $actionClassName = 'MbqAct'.implode('', $arr);
                if (self::$oClk->hasReg($actionClassName)) {
                    self::$oAct = self::$oClk->newObj($actionClassName);
                    self::$oAct->actionImplement();
                } else {
                    MbqError::alert('', "Not support action for ".self::$cmd."!", '', MBQ_ERR_NOT_SUPPORT);
                }
            } else {
                MbqError::alert('', "Need valid cmd!");
            }
        } else {
            MbqError::alert('', "Need not empty cmd!");
        }
    }
    
    /**
     * do something before output
     */
    public function beforeOutPut() {
        ob_end_clean();
        if (self::$oCurMbqEtUser) {
            header('Mobiquo_is_login: true');
        } else {
            header('Mobiquo_is_login: false');
        }
    }
    
}

?>