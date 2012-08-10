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
/* path constant */
define('MBQ_DS', DIRECTORY_SEPARATOR);
define('MBQ_PATH', dirname(__FILE__).MBQ_DS);    /* mobiquo path */
define('MBQ_PARENT_PATH', realpath(dirname(__FILE__).MBQ_DS.'..').MBQ_DS);    /* mobiquo parent dir path */
define('MBQ_FRAME_PATH', MBQ_PATH.'mbqFrame'.MBQ_DS);    /* frame path */
require_once(MBQ_FRAME_PATH.'MbqError.php');
require_once(MBQ_FRAME_PATH.'MbqBaseConfig.php');
require_once(MBQ_FRAME_PATH.'MbqBaseMain.php');
require_once(MBQ_FRAME_PATH.'MbqClassLink.php');
require_once(MBQ_FRAME_PATH.'MbqValue.php');
define('MBQ_CLASS_PATH', MBQ_PATH.'mbqClass'.MBQ_DS);    /* class path */
define('MBQ_ENTITY_PATH', MBQ_CLASS_PATH.'entity'.MBQ_DS);    /* entity class path */
define('MBQ_FDT_PATH', MBQ_CLASS_PATH.'fdt'.MBQ_DS);    /* fdt class path */
define('MBQ_IO_PATH', MBQ_CLASS_PATH.'io'.MBQ_DS);    /* io class path */
define('MBQ_IO_HANDLE_PATH', MBQ_IO_PATH.'handle'.MBQ_DS);    /* io handle class path */
define('MBQ_LIB_PATH', MBQ_CLASS_PATH.'lib'.MBQ_DS);    /* lib class path */
define('MBQ_ACL_PATH', MBQ_LIB_PATH.'acl'.MBQ_DS);    /* acl class path */
define('MBQ_READ_PATH', MBQ_LIB_PATH.'read'.MBQ_DS);    /* read class path */
define('MBQ_WRITE_PATH', MBQ_LIB_PATH.'write'.MBQ_DS);    /* write class path */
define('MBQ_ACTION_PATH', MBQ_PATH.'mbqAction'.MBQ_DS);    /* action class path */
define('MBQ_APPEXTENTION_PATH', MBQ_PATH.'appExtt'.MBQ_DS);    /* application extention path */
define('MBQ_CUSTOM_PATH', MBQ_PATH.'custom'.MBQ_DS);    /* user custom path */
define('MBQ_3RD_LIB_PATH', MBQ_PATH.'3rdLib'.MBQ_DS);    /* 3rd lib path */

/**
 * plugin config
 * 
 * @since  2012-7-2
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqConfig extends MbqBaseConfig {

    public function __construct() {
        parent::__construct();
        $this->regClass();
        MbqMain::$oClk->includeClass('MbqError');
        MbqMain::$oClk->includeClass('MbqBaseAct');
        MbqMain::$oClk->includeClass('MbqBaseAppEnv');
        MbqMain::$oClk->includeClass('MbqBaseCm');
        MbqMain::$oClk->includeClass('MbqBaseIo');
        MbqMain::$oClk->includeClass('MbqBaseClass');
        MbqMain::$oClk->includeClass('MbqValue');
        MbqMain::$oClk->includeClass('MbqBaseEntity');
        MbqMain::$oClk->includeClass('MbqBaseFdt');
        MbqMain::$oClk->includeClass('MbqBaseRd');
        MbqMain::$oClk->includeClass('MbqBaseWr');
        MbqMain::$oClk->includeClass('MbqBaseAcl');
        /* include fdt class */
        MbqMain::$oClk->includeClass('MbqFdtConfig');
        MbqMain::$oClk->includeClass('MbqFdtBase');
        MbqMain::$oClk->includeClass('MbqFdtUser');
        MbqMain::$oClk->includeClass('MbqFdtForum');
        MbqMain::$oClk->includeClass('MbqFdtPm');
        MbqMain::$oClk->includeClass('MbqFdtPc');
        MbqMain::$oClk->includeClass('MbqFdtLike');
        MbqMain::$oClk->includeClass('MbqFdtSubscribe');
        MbqMain::$oClk->includeClass('MbqFdtThank');
        MbqMain::$oClk->includeClass('MbqFdtFollow');
        MbqMain::$oClk->includeClass('MbqFdtFeed');
        /* include custom config */
        require_once(MBQ_CUSTOM_PATH.'customConfig.php');
        $this->initCfg();
    }
    
    /**
     * regist classes
     */
    protected function regClass() {
        /* frame class */
        MbqMain::$oClk->reg('MbqBaseAct', MBQ_FRAME_PATH.'MbqBaseAct.php');
        MbqMain::$oClk->reg('MbqBaseAppEnv', MBQ_FRAME_PATH.'MbqBaseAppEnv.php');
        MbqMain::$oClk->reg('MbqBaseCm', MBQ_FRAME_PATH.'MbqBaseCm.php');
        MbqMain::$oClk->reg('MbqBaseConfig', MBQ_FRAME_PATH.'MbqBaseConfig.php');
        MbqMain::$oClk->reg('MbqBaseIo', MBQ_FRAME_PATH.'MbqBaseIo.php');
        MbqMain::$oClk->reg('MbqBaseMain', MBQ_FRAME_PATH.'MbqBaseMain.php');
        MbqMain::$oClk->reg('MbqClassLink', MBQ_FRAME_PATH.'MbqClassLink.php');
        MbqMain::$oClk->reg('MbqCookie', MBQ_FRAME_PATH.'MbqCookie.php');
        MbqMain::$oClk->reg('MbqError', MBQ_FRAME_PATH.'MbqError.php');
        MbqMain::$oClk->reg('MbqSession', MBQ_FRAME_PATH.'MbqSession.php');
        MbqMain::$oClk->reg('MbqValue', MBQ_FRAME_PATH.'MbqValue.php');
        MbqMain::$oClk->reg('MbqBaseEntity', MBQ_FRAME_PATH.'MbqBaseEntity.php');
        MbqMain::$oClk->reg('MbqBaseFdt', MBQ_FRAME_PATH.'MbqBaseFdt.php');
        MbqMain::$oClk->reg('MbqBaseRd', MBQ_FRAME_PATH.'MbqBaseRd.php');
        MbqMain::$oClk->reg('MbqBaseWr', MBQ_FRAME_PATH.'MbqBaseWr.php');
        MbqMain::$oClk->reg('MbqBaseAcl', MBQ_FRAME_PATH.'MbqBaseAcl.php');
        MbqMain::$oClk->reg('MbqDataPage', MBQ_FRAME_PATH.'MbqDataPage.php');
        /* other class */
        MbqMain::$oClk->reg('MbqCm', MBQ_PATH.'MbqCm.php');
        MbqMain::$oClk->reg('MbqAppEnv', MBQ_PATH.'MbqAppEnv.php');
        /* entity class */
        MbqMain::$oClk->reg('MbqEtSysStatistics', MBQ_ENTITY_PATH.'MbqEtSysStatistics.php');
        MbqMain::$oClk->reg('MbqEtUser', MBQ_ENTITY_PATH.'MbqEtUser.php');
        MbqMain::$oClk->reg('MbqEtForum', MBQ_ENTITY_PATH.'MbqEtForum.php');
        MbqMain::$oClk->reg('MbqEtForumSmilie', MBQ_ENTITY_PATH.'MbqEtForumSmilie.php');
        MbqMain::$oClk->reg('MbqEtForumTopic', MBQ_ENTITY_PATH.'MbqEtForumTopic.php');
        MbqMain::$oClk->reg('MbqEtForumReportPost', MBQ_ENTITY_PATH.'MbqEtForumReportPost.php');
        MbqMain::$oClk->reg('MbqEtForumPost', MBQ_ENTITY_PATH.'MbqEtForumPost.php');
        MbqMain::$oClk->reg('MbqEtAtt', MBQ_ENTITY_PATH.'MbqEtAtt.php');
        MbqMain::$oClk->reg('MbqEtPc', MBQ_ENTITY_PATH.'MbqEtPc.php');
        MbqMain::$oClk->reg('MbqEtPcMsg', MBQ_ENTITY_PATH.'MbqEtPcMsg.php');
        MbqMain::$oClk->reg('MbqEtPcInviteParticipant', MBQ_ENTITY_PATH.'MbqEtPcInviteParticipant.php');
        MbqMain::$oClk->reg('MbqEtPm', MBQ_ENTITY_PATH.'MbqEtPm.php');
        MbqMain::$oClk->reg('MbqEtReportPm', MBQ_ENTITY_PATH.'MbqEtReportPm.php');
        MbqMain::$oClk->reg('MbqEtPmBox', MBQ_ENTITY_PATH.'MbqEtPmBox.php');
        MbqMain::$oClk->reg('MbqEtSubscribe', MBQ_ENTITY_PATH.'MbqEtSubscribe.php');
        MbqMain::$oClk->reg('MbqEtThank', MBQ_ENTITY_PATH.'MbqEtThank.php');
        MbqMain::$oClk->reg('MbqEtFollow', MBQ_ENTITY_PATH.'MbqEtFollow.php');
        MbqMain::$oClk->reg('MbqEtLike', MBQ_ENTITY_PATH.'MbqEtLike.php');
        MbqMain::$oClk->reg('MbqEtFeed', MBQ_ENTITY_PATH.'MbqEtFeed.php');
        /* fdt class */
        MbqMain::$oClk->reg('MbqFdtConfig', MBQ_FDT_PATH.'MbqFdtConfig.php');
        MbqMain::$oClk->reg('MbqFdtBase', MBQ_FDT_PATH.'MbqFdtBase.php');
        MbqMain::$oClk->reg('MbqFdtUser', MBQ_FDT_PATH.'MbqFdtUser.php');
        MbqMain::$oClk->reg('MbqFdtForum', MBQ_FDT_PATH.'MbqFdtForum.php');
        MbqMain::$oClk->reg('MbqFdtPm', MBQ_FDT_PATH.'MbqFdtPm.php');
        MbqMain::$oClk->reg('MbqFdtPc', MBQ_FDT_PATH.'MbqFdtPc.php');
        MbqMain::$oClk->reg('MbqFdtLike', MBQ_FDT_PATH.'MbqFdtLike.php');
        MbqMain::$oClk->reg('MbqFdtSubscribe', MBQ_FDT_PATH.'MbqFdtSubscribe.php');
        MbqMain::$oClk->reg('MbqFdtThank', MBQ_FDT_PATH.'MbqFdtThank.php');
        MbqMain::$oClk->reg('MbqFdtFollow', MBQ_FDT_PATH.'MbqFdtFollow.php');
        MbqMain::$oClk->reg('MbqFdtFeed', MBQ_FDT_PATH.'MbqFdtFeed.php');
        /* lib class */
            /* read class */
        MbqMain::$oClk->reg('MbqRdEtForum', MBQ_READ_PATH.'MbqRdEtForum.php');
        MbqMain::$oClk->reg('MbqRdEtUser', MBQ_READ_PATH.'MbqRdEtUser.php');
        MbqMain::$oClk->reg('MbqRdEtForumTopic', MBQ_READ_PATH.'MbqRdEtForumTopic.php');
            /* write class */
            /* acl class */
        MbqMain::$oClk->reg('MbqAclEtForum', MBQ_ACL_PATH.'MbqAclEtForum.php');
        MbqMain::$oClk->reg('MbqAclEtForumTopic', MBQ_ACL_PATH.'MbqAclEtForumTopic.php');
        /* I/O class */
        MbqMain::$oClk->reg('MbqIo', MBQ_IO_PATH.'MbqIo.php');
        MbqMain::$oClk->reg('MbqIoHandleXmlrpc', MBQ_IO_HANDLE_PATH.'MbqIoHandleXmlrpc.php');
        MbqMain::$oClk->reg('MbqIoHandleJson', MBQ_IO_HANDLE_PATH.'MbqIoHandleJson.php');
        /* action class */
        MbqMain::$oClk->reg('MbqActGetConfig', MBQ_ACTION_PATH.'MbqActGetConfig.php');
        MbqMain::$oClk->reg('MbqActGetForum', MBQ_ACTION_PATH.'MbqActGetForum.php');
        MbqMain::$oClk->reg('MbqActGetTopic', MBQ_ACTION_PATH.'MbqActGetTopic.php');
        MbqMain::$oClk->reg('MbqActGetThread', MBQ_ACTION_PATH.'MbqActGetThread.php');
        MbqMain::$oClk->reg('MbqActLogin', MBQ_ACTION_PATH.'MbqActLogin.php');
    }
    
    /**
     * init cfg default value
     */
    protected function initCfg() {
        /* base/user/forum/pm/pc/like/subscribe/thank/follow/feed */
        $this->cfg['base'] = $this->cfg['user'] = $this->cfg['forum'] = $this->cfg['pm'] = $this->cfg['pc'] = $this->cfg['like'] = $this->cfg['subscribe'] = $this->cfg['thank'] = $this->cfg['follow'] = $this->cfg['like'] = $this->cfg['feed'] = array();
      /* base config includes some global setting */
        $this->cfg['base']['sys_version'] = clone MbqMain::$simpleV;
        $this->cfg['base']['version'] = clone MbqMain::$simpleV; /* Tapatalk plugin version. Plugin developers: Set "version=dev" in order to get your development environment verified by the Tapatalk Network. */
        $this->cfg['base']['api_level'] = clone MbqMain::$simpleV;
        $this->cfg['base']['is_open'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.base.is_open.default')));  /* false: service is not available / true: service is available.  */
        $this->cfg['base']['inbox_stat'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.base.inbox_stat.default')));  /* Return "1" if the plugin support pm and subscribed topic unread number since last check time. */
        $this->cfg['base']['announcement'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.base.announcement.default')));    /* This instructs the app to hide/show the "Announcement" tab in topic view */
        $this->cfg['base']['disable_bbcode'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.base.disable_bbcode.default')));    /* disable bbcode function flag */
        $this->cfg['base']['push'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.base.push.default')));
      /* user */
        $this->cfg['user']['module_name'] = MbqMain::$oClk->newObj('MbqValue', 'Joomla! Kunena');    /* module name.it indicate this module is supported by whitch applications or 3rd plugins/modules.it is used to distinguish the diffrent 3rd plugins or modules. */
        $this->cfg['user']['module_version'] = MbqMain::$oClk->newObj('MbqValue', 'Joomla!1.5.26+/Joomla!2.5.4+  Kunena2.0.x');    /* module version.it indicate the applications version that support this module. */
        $this->cfg['user']['module_enable'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.user.module_enable.default')));    /* enable module flag */
        $this->cfg['user']['reg_url'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.user.reg_url.default')));     /* regist url on web page */
        $this->cfg['user']['guest_okay'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.user.guest_okay.default'))); /* false: guest access is not allowed / true: guess access is allowed. */
        $this->cfg['user']['anonymous'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.user.anonymous.default'))); /* Return 1 if plugin support anonymous login. */
        $this->cfg['user']['guest_whosonline'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.user.guest_whosonline.default'))); /* Return "1" if guest user can see who is currently online */
        $this->cfg['user']['avatar'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.user.avatar.default')));
        $this->cfg['user']['emoji'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.user.emoji.default')));    /* Return 1 to indicate the plugin contains emoji package */
        $this->cfg['user']['support_md5'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.user.support_md5.default')));     /* Return 1 to indicate the plugin support md5 password.  */
        $this->cfg['user']['get_smilies'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.user.get_smilies.default')));    /* Return 1 if the plugin support function get_smilies */
        $this->cfg['user']['advanced_online_users'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.user.advanced_online_users.default')));    /* Return 1 if the plugin support get_online_users with forum and thread filter, and also pagination */
        $this->cfg['user']['user_id'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.user.user_id.default')));    /* Indicate the function get_participated_topic / get_user_info / get_user_topic / get_user_reply_post support request with user id. */
        $this->cfg['user']['upload_avatar'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.user.upload_avatar.default')));    /* can upload avatar flag. */
      /* forum */
        $this->cfg['forum']['module_name'] = MbqMain::$oClk->newObj('MbqValue', 'Kunena');
        $this->cfg['forum']['module_version'] = MbqMain::$oClk->newObj('MbqValue', 'Kunena2.0.x');
        $this->cfg['forum']['module_enable'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.module_enable.default')));
        $this->cfg['forum']['report_post'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.report_post.default')));    /* return 1 to indicate the plugin support report_post function. */
        $this->cfg['forum']['goto_post'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.goto_post.default')));
        $this->cfg['forum']['goto_unread'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.goto_unread.default')));
        $this->cfg['forum']['mark_read'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.mark_read.default')));    /* This is to indicate if the forum system support function mark_all_as_read */
        $this->cfg['forum']['mark_forum'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.mark_forum.default')));    /* This is to indicate if function mark_all_as_read can accept a parameter as forum id to mark a specified forum as read. */
        $this->cfg['forum']['no_refresh_on_post'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.no_refresh_on_post.default')));
        $this->cfg['forum']['subscribe_forum'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.subscribe_forum.default')));    /* this is to indicate this forum system supports "Sub-Forum Subscription" feature.  */
        $this->cfg['forum']['get_latest_topic'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.get_latest_topic.default')));
        $this->cfg['forum']['get_id_by_url'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.get_id_by_url.default')));
        $this->cfg['forum']['delete_reason'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.delete_reason.default')));
        $this->cfg['forum']['mod_approve'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.mod_approve.default')));    /* This is to indicate this forum system supports a centralized view to list all topics / posts pending to be approved. */
        $this->cfg['forum']['mod_delete'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.mod_delete.default')));    /* This is to indicate this forum system supports a centralized view to list all topics / posts that has been soft-deleted, allowing moderator to undelete topics / posts. */
        $this->cfg['forum']['mod_report'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.mod_report.default')));    /* This is to indicate this forum system supports a centralized view to list all topics / posts that have been reported by the users and need moderator attention. */
        $this->cfg['forum']['guest_search'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.guest_search.default')));    /* Returns "1" if guest user can search in this forum without logging in. This is helpful as the app can enable search function under guest mode */
        $this->cfg['forum']['subscribe_load'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.subscribe_load.default')));    /* Return "1" if get_subscribed_topic support pagination.  */
        $this->cfg['forum']['subscribe_topic_mode'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.subscribe_topic_mode.default')));    /* It indicates the plugin support notification type option when do subscribe topic. */
        $this->cfg['forum']['subscribe_forum_mode'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.subscribe_forum_mode.default')));
        $this->cfg['forum']['min_search_length'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.min_search_length.default')));    /* Minimum string length for search_topic / search_post / search within forum. */
        $this->cfg['forum']['multi_quote'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.multi_quote.default')));    /* Return 1 is the plugin support multi quote. Check more in get_quote_post */
        $this->cfg['forum']['default_smilies'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.default_smilies.default')));    /* Forum default smilie set support. */
        $this->cfg['forum']['can_unread'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.can_unread.default')));    /* If it set to "0", indicate this forum does not support Unread feature. */
        $this->cfg['forum']['get_forum'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.get_forum.default')));    /* Return 1 if the plugin support function get_forum with two parameters for description control and sub forum id filter. */
        $this->cfg['forum']['get_topic_status'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.get_topic_status.default')));    /* Return 1 if the plugin support function get_topic_status */
        $this->cfg['forum']['get_participated_forum'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.get_participated_forum.default')));   /* Return 1 if the plugin support function get_participated_forum */
        $this->cfg['forum']['get_forum_status'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.get_forum_status.default')));    /* Return 1 if the plugin support function get_forum_status */
        $this->cfg['forum']['advanced_search'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.advanced_search.default')));    /* Return 1 if the plugin support function search */
        $this->cfg['forum']['mark_topic_read'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.mark_topic_read.default')));    /* Return 1 if the plugin support function mark_topic_read */
        $this->cfg['forum']['advanced_delete'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.advanced_delete.default')));    /* Return '1' if the plugin support both soft and hard delete. */
        $this->cfg['forum']['first_unread'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.first_unread.default')));    /* returns "0" if this forum system does not support First Unread feature. Assume "1" if missing. */
        $this->cfg['forum']['max_attachment'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.max_attachment.default')));    /* return the max attachment num can be submitted when submit topic/post. */
        $this->cfg['forum']['soft_delete'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.forum.soft_delete.default')));    /* support soft delete flag. */
      /* pm */
        $this->cfg['pm']['module_name'] = clone MbqMain::$simpleV;
        $this->cfg['pm']['module_version'] = clone MbqMain::$simpleV;
        $this->cfg['pm']['module_enable'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.pm.module_enable.default')));
        $this->cfg['pm']['report_pm'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.pm.report_pm.default')));
        $this->cfg['pm']['pm_load'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.pm.pm_load.default')));   /* Return "1" if get_box support pagination. */
        $this->cfg['pm']['mark_pm_unread'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.pm.mark_pm_unread.default')));   /* Return 1 if the plugin support function mark_pm_unread */
      /* pc */
        $this->cfg['pc']['module_name'] = clone MbqMain::$simpleV;
        $this->cfg['pc']['module_version'] = clone MbqMain::$simpleV;
        $this->cfg['pc']['module_enable'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.pc.module_enable.default')));
        $this->cfg['pc']['conversation'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.pc.conversation.default')));  /* Return 1 if the plugin support conversation pm */
      /* like */
        $this->cfg['like']['module_name'] = clone MbqMain::$simpleV;
        $this->cfg['like']['module_version'] = clone MbqMain::$simpleV;
        $this->cfg['like']['module_enable'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.like.module_enable.default')));
      /* subscribe */
        $this->cfg['subscribe']['module_name'] = clone MbqMain::$simpleV;
        $this->cfg['subscribe']['module_version'] = clone MbqMain::$simpleV;
        $this->cfg['subscribe']['module_enable'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.subscribe.module_enable.default')));
        $this->cfg['subscribe']['mass_subscribe'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.subscribe.mass_subscribe.default'))); /* Return 1 if the plugin support id 'ALL' in subscribe_topic / subscribe_forum / unsubscribe_topic / unsubscribe_forum */
      /* thank */
        $this->cfg['thank']['module_name'] = clone MbqMain::$simpleV;
        $this->cfg['thank']['module_version'] = clone MbqMain::$simpleV;
        $this->cfg['thank']['module_enable'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.thank.module_enable.default')));
      /* follow */
        $this->cfg['follow']['module_name'] = clone MbqMain::$simpleV;
        $this->cfg['follow']['module_version'] = clone MbqMain::$simpleV;
        $this->cfg['follow']['module_enable'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.follow.module_enable.default')));
      /* feed */
        $this->cfg['feed']['module_name'] = clone MbqMain::$simpleV;
        $this->cfg['feed']['module_version'] = clone MbqMain::$simpleV;
        $this->cfg['feed']['module_enable'] = MbqMain::$oClk->newObj('MbqValue', array('oriValue' => MbqBaseFdt::getFdt('MbqFdtConfig.feed.module_enable.default')));
    }
    
    /**
     * test plugin is open
     *
     * @return  Boolean
     */
    public function pluginIsOpen() {
        return ($this->cfg['base']['is_open']->oriValue == MbqBaseFdt::getFdt('MbqFdtConfig.base.is_open.range.yes')) ? true : false;
    }
    
    /**
     * test module is enable
     *
     * @param  String  module name
     * @return  Boolean
     */
    public function moduleIsEnable($moduleName) {
        if (isset($this->cfg[$moduleName])) {
            if (isset($this->cfg[$moduleName]['module_enable'])) {
                if ($this->cfg[$moduleName]['module_enable']->oriValue == MbqBaseFdt::getFdt('MbqFdtConfig.'.$moduleName.'.module_enable.range.enable')) {
                    return true;
                }
            }
            return false;
        } else {
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . "Invalid module name $moduleName!");
        }
    }
    
    /**
     * calculate the final config of $this->cfg through $this->cfg default value and MbqMain::$customConfig and MbqMain::$oMbqAppEnv and the plugin support degree
     */
    public function calCfg() {
      /* replace part config through MbqMain::$customConfig */
        foreach (MbqMain::$customConfig as $moduleKey => $module) {
            if (isset($this->cfg[$moduleKey])) {
                foreach ($module as $itemKey => $item) {
                    if (isset($this->cfg[$moduleKey][$itemKey])) {
                        $this->cfg[$moduleKey][$itemKey]->setOriValue($item);
                    } else {
                        MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . "Can not find module:$moduleKey,item:$itemKey in config!");
                    }
                }
            } else {
                MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . "Can not find module:$moduleKey in config!");
            }
        }
      /* calculate the final config through MbqMain::$oMbqAppEnv */
        if ( class_exists('KunenaForum') && KunenaForum::isCompatible('2.0') && KunenaForum::enabled() ) {
            $this->cfg['forum']['module_enable']->setOriValue(MbqBaseFdt::getFdt('MbqFdtConfig.forum.module_enable.range.enable'));
        }
        /* because the forum module is the main function,so the is_open setting relys on the forum module status. */
        if (!$this->moduleIsEnable('forum')) {
            $this->cfg['base']['is_open']->setOriValue(MbqBaseFdt::getFdt('MbqFdtConfig.base.is_open.range.no'));
        }
    }
    
}

?>