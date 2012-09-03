<?php

defined('MBQ_IN_IT') or exit;

/**
 * frame main program base class
 * 
 * @since  2012-7-2
 * @author Wu ZeTao <578014287@qq.com>
 */
Abstract Class MbqBaseMain {
    
    public static $oMbqCm;
    public static $oMbqConfig;
    public static $customConfig;    /* user custom config,defined in customConfig.php */
    public static $oMbqAppEnv;
    public static $oClk;  /* instance of class MbqClassLink */
    public static $oMbqCookie;
    public static $oMbqSession;
    public static $oMbqIo;
    public static $simpleV;   /* an empty MbqValue object for simple value initialization */
    
    public static $protocol;    /* xmlrpc/json */
    public static $module;  /* module name */
    public static $cmd;   /* action command name,must unique in all action. */
    public static $input;   /* input params array */
    
    public static $data;   /* data need return */
    public static $oAct;   /* action object */

    public static function init() {
        self::$simpleV = new MbqValue();
        self::$oClk = new MbqClassLink();
        self::$oMbqConfig = new MbqConfig();
        self::$oMbqCm = self::$oClk->newObj('MbqCm');
        self::$oMbqAppEnv = self::$oClk->newObj('MbqAppEnv');
        self::$oMbqCookie = self::$oClk->newObj('MbqCookie');
        self::$oMbqSession = self::$oClk->newObj('MbqSession');
        self::$oMbqIo = self::$oClk->newObj('MbqIo');
    }
    
    /**
     * data input
     */
    public static function input() {
        self::$oMbqIo->input();
    }
    
    /**
     * init application environment
     */
    public static function initAppEnv() {
        self::$oMbqAppEnv->init();
    }
    
    /**
     * action
     */
    public static function action() {
    }
    
    /**
     * data output
     */
    public static function output() {
        self::$oMbqIo->output();
    }
  
}

?>