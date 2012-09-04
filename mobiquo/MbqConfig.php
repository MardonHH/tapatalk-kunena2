<?php

defined('MBQ_IN_IT') or exit;

/* error constant */
define('MBQ_ERR_TOP', 1);   /* the worst error that must stop the program immediately.we often use this constant in plugin development. */
define('MBQ_ERR_HIGH', 3);  /* serious error that must stop the program immediately for display in html page.we need not use this constant in plugin development,but can use it in other projects development perhaps. */
define('MBQ_ERR_NOT_SUPPORT', 5);  /* not support corresponding function error that must stop the program immediately. */
define('MBQ_ERR_APP', 7);   /* normal error that maked by program logic can be displayed,the program can works continue or not. */
define('MBQ_ERR_INFO', 9);  /* success info that maked by program logic can be displayed,the program can works continue or not. */
define('MBQ_ERR_DEFAULT_INFO', 'You are not logged in or you do not have permission to do this action.');
define('MBQ_ERR_INFO_UNKNOWN_CASE', 'Unknown case value!');
define('MBQ_ERR_INFO_UNKNOWN_PNAME', 'Unknown property name!');
define('MBQ_ERR_INFO_NOT_ACHIEVE', 'Has not been achieved!');
define('MBQ_ERR_INFO_SAVE_FAIL', 'Can not save data!');
define('MBQ_RUNNING_NAMEPRE', 'mbqnamepre_');   /* mobiquo running time vars name prefix,for example bbcode names. */
/* path constant */
define('MBQ_DS', DIRECTORY_SEPARATOR);
define('MBQ_PATH', dirname(__FILE__).MBQ_DS);    /* mobiquo path */
define('MBQ_DIRNAME', basename(MBQ_PATH));    /* mobiquo dir name */
define('MBQ_PARENT_PATH', realpath(dirname(__FILE__).MBQ_DS.'..').MBQ_DS);    /* mobiquo parent dir path */
define('MBQ_FRAME_PATH', MBQ_PATH.'mbqFrame'.MBQ_DS);    /* frame path */
$_SERVER['PHP_SELF'] = str_replace(MBQ_DIRNAME.'/', '', $_SERVER['PHP_SELF']);  /* Important!!! */
$_SERVER['SCRIPT_NAME'] = str_replace(MBQ_DIRNAME.'/', '', $_SERVER['SCRIPT_NAME']);    /* Important!!! */
$_SERVER['REQUEST_URI'] = str_replace(MBQ_DIRNAME.'/', '', $_SERVER['REQUEST_URI']);    /* Important!!! */
require_once(MBQ_FRAME_PATH.'MbqError.php');
require_once(MBQ_FRAME_PATH.'MbqBaseConfig.php');
require_once(MBQ_FRAME_PATH.'MbqBaseMain.php');
require_once(MBQ_FRAME_PATH.'MbqClassLink.php');
require_once(MBQ_FRAME_PATH.'MbqValue.php');
define('MBQ_CLASS_PATH', MBQ_PATH.'mbqClass'.MBQ_DS);    /* class path */
define('MBQ_ENTITY_PATH', MBQ_FRAME_PATH.'entity'.MBQ_DS);    /* entity class path */
define('MBQ_FDT_PATH', MBQ_FRAME_PATH.'fdt'.MBQ_DS);    /* fdt class path */
define('MBQ_IO_PATH', MBQ_FRAME_PATH.'io'.MBQ_DS);    /* io class path */
define('MBQ_IO_HANDLE_PATH', MBQ_IO_PATH.'handle'.MBQ_DS);    /* io handle class path */
define('MBQ_LIB_PATH', MBQ_CLASS_PATH.'lib'.MBQ_DS);    /* lib class path */
define('MBQ_ACL_PATH', MBQ_LIB_PATH.'acl'.MBQ_DS);    /* acl class path */
define('MBQ_READ_PATH', MBQ_LIB_PATH.'read'.MBQ_DS);    /* read class path */
define('MBQ_WRITE_PATH', MBQ_LIB_PATH.'write'.MBQ_DS);    /* write class path */
define('MBQ_BASE_ACTION_PATH', MBQ_FRAME_PATH.'mbqBaseAction'.MBQ_DS);    /* base action class path */
define('MBQ_ACTION_PATH', MBQ_PATH.'mbqAction'.MBQ_DS);    /* action class path */
define('MBQ_APPEXTENTION_PATH', MBQ_PATH.'appExtt'.MBQ_DS);    /* application extention path */
define('MBQ_CUSTOM_PATH', MBQ_PATH.'custom'.MBQ_DS);    /* user custom path */
define('MBQ_3RD_LIB_PATH', MBQ_FRAME_PATH.'3rdLib'.MBQ_DS);    /* 3rd lib path */

/**
 * plugin config
 * 
 * @since  2012-7-2
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqConfig extends MbqBaseConfig {

    public function __construct() {
        parent::__construct();
        /* include custom config */
        require_once(MBQ_CUSTOM_PATH.'customConfig.php');
        $this->initCfg();
    }
    
    /**
     * init cfg default value
     */
    protected function initCfg() {
        parent::initCfg();
      /* user */
        $this->cfg['user']['module_name'] = MbqMain::$oClk->newObj('MbqValue', 'Joomla! Kunena');    /* module name.it indicate this module is supported by whitch applications or 3rd plugins/modules.it is used to distinguish the diffrent 3rd plugins or modules. */
        $this->cfg['user']['module_version'] = MbqMain::$oClk->newObj('MbqValue', 'Joomla!1.5.26+/Joomla!2.5.4+  Kunena2.0.x');    /* module version.it indicate the applications version that support this module. */
      /* forum */
        $this->cfg['forum']['module_name'] = MbqMain::$oClk->newObj('MbqValue', 'Kunena');
        $this->cfg['forum']['module_version'] = MbqMain::$oClk->newObj('MbqValue', 'Kunena2.0.x');
    }
    
    /**
     * calculate the final config of $this->cfg through $this->cfg default value and MbqMain::$customConfig and MbqMain::$oMbqAppEnv and the plugin support degree
     */
    public function calCfg() {
        parent::calCfg();
      /* calculate the final config */
        if ( class_exists('KunenaForum') && KunenaForum::isCompatible('2.0') && KunenaForum::enabled() ) {
            $this->cfg['forum']['module_enable']->setOriValue(MbqBaseFdt::getFdt('MbqFdtConfig.forum.module_enable.range.enable'));
        }
        /* because the forum module is the main function,so the is_open setting relys on the forum module status. */
        if (!$this->moduleIsEnable('forum')) {
            $this->cfg['base']['is_open']->setOriValue(MbqBaseFdt::getFdt('MbqFdtConfig.base.is_open.range.no'));
        }
        if ($this->moduleIsEnable('user') && !MbqMain::$oMbqAppEnv->oKunenaConfig->regonly && ($this->getCfg('user.guest_okay')->oriValue == MbqBaseFdt::getFdt('MbqFdtConfig.user.guest_okay.range.support'))) {
            $this->cfg['user']['guest_okay']->setOriValue(MbqBaseFdt::getFdt('MbqFdtConfig.user.guest_okay.range.support'));
        } else {
            $this->cfg['user']['guest_okay']->setOriValue(MbqBaseFdt::getFdt('MbqFdtConfig.user.guest_okay.range.notSupport'));
        }
        if ($this->moduleIsEnable('user') && MbqMain::$oMbqAppEnv->oKunenaConfig->showwhoisonline && ($this->getCfg('user.guest_whosonline')->oriValue == MbqBaseFdt::getFdt('MbqFdtConfig.user.guest_whosonline.range.support'))) {
            $this->cfg['user']['guest_whosonline']->setOriValue(MbqBaseFdt::getFdt('MbqFdtConfig.user.guest_whosonline.range.support'));
        } else {
            $this->cfg['user']['guest_whosonline']->setOriValue(MbqBaseFdt::getFdt('MbqFdtConfig.user.guest_whosonline.range.notSupport'));
        }
    }
    
}

?>