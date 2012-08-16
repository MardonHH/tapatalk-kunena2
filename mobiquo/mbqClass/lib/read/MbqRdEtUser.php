<?php

defined('MBQ_IN_IT') or exit;

/**
 * user read class
 * 
 * @since  2012-8-6
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqRdEtUser extends MbqBaseRd {
    
    public function __construct() {
    }
    
    protected function makeProperty(&$oMbqEtUser, $pName, $mbqOpt = array()) {
        switch ($pName) {
            default:
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_PNAME);
            break;
        }
    }
    
    /**
     * return user api data
     *
     * @param  Object  $oMbqEtUser
     * @return  Array
     */
    public function returnApiDataUser($oMbqEtUser) {
        $data = array();
        if ($oMbqEtUser->userId->hasSetOriValue()) {
            $data['user_id'] = (string) $oMbqEtUser->userId->oriValue;
        }
        $data['username'] = (string) $oMbqEtUser->getDisplayName();
        if ($oMbqEtUser->userGroupIds->hasSetOriValue()) {
            $data['usergroup_id'] = (array) MbqMain::$oMbqCm->changeArrValueToString($oMbqEtUser->userGroupIds->oriValue);
        }
        if ($oMbqEtUser->iconUrl->hasSetOriValue()) {
            $data['icon_url'] = (string) $oMbqEtUser->iconUrl->oriValue;
        }
        if ($oMbqEtUser->postCount->hasSetOriValue()) {
            $data['post_count'] = (int) $oMbqEtUser->postCount->oriValue;
        }
        if ($oMbqEtUser->canPm->hasSetOriValue()) {
            $data['can_pm'] = (boolean) $oMbqEtUser->canPm->oriValue;
        } else {
            $data['can_pm'] = (boolean) MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.canPm.default');
        }
        if ($oMbqEtUser->canSendPm->hasSetOriValue()) {
            $data['can_send_pm'] = (boolean) $oMbqEtUser->canSendPm->oriValue;
        } else {
            $data['can_send_pm'] = (boolean) MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.canSendPm.default');
        }
        if ($oMbqEtUser->canModerate->hasSetOriValue()) {
            $data['can_moderate'] = (boolean) $oMbqEtUser->canModerate->oriValue;
        } else {
            $data['can_moderate'] = (boolean) MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.canModerate.default');
        }
        if ($oMbqEtUser->canSearch->hasSetOriValue()) {
            $data['can_search'] = (boolean) $oMbqEtUser->canSearch->oriValue;
        } else {
            $data['can_search'] = (boolean) MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.canSearch.default');
        }
        if ($oMbqEtUser->canWhosonline->hasSetOriValue()) {
            $data['can_whosonline'] = (boolean) $oMbqEtUser->canWhosonline->oriValue;
        } else {
            $data['can_whosonline'] = (boolean) MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.canWhosonline.default');
        }
        if ($oMbqEtUser->canUploadAvatar->hasSetOriValue()) {
            $data['can_upload_avatar'] = (string) $oMbqEtUser->canUploadAvatar->oriValue;
        } else {
            $data['can_upload_avatar'] = (boolean) MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.canUploadAvatar.default');
        }
        if ($oMbqEtUser->maxAttachment->hasSetOriValue()) {
            $data['max_attachment'] = (int) $oMbqEtUser->maxAttachment->oriValue;
        }
        if ($oMbqEtUser->maxPngSize->hasSetOriValue()) {
            $data['max_png_size'] = (int) $oMbqEtUser->maxPngSize->oriValue;
        }
        if ($oMbqEtUser->maxJpgSize->hasSetOriValue()) {
            $data['max_jpg_size'] = (int) $oMbqEtUser->maxJpgSize->oriValue;
        }
        if ($oMbqEtUser->displayText->hasSetOriValue()) {
            $data['display_text'] = (string) $oMbqEtUser->displayText->oriValue;
        }
        if ($oMbqEtUser->regTime->hasSetOriValue()) {
            $data['reg_time'] = (string) MbqMain::$oMbqCm->datetimeIso8601Encode($oMbqEtUser->regTime->oriValue);
        }
        if ($oMbqEtUser->lastActivityTime->hasSetOriValue()) {
            $data['last_activity_time'] = (string) MbqMain::$oMbqCm->datetimeIso8601Encode($oMbqEtUser->lastActivityTime->oriValue);
        }
        if ($oMbqEtUser->isOnline->hasSetOriValue()) {
            $data['is_online'] = (boolean) $oMbqEtUser->isOnline->oriValue;
        }
        if ($oMbqEtUser->acceptPm->hasSetOriValue()) {
            $data['accept_pm'] = (boolean) $oMbqEtUser->acceptPm->oriValue;
        } else {
            $data['accept_pm'] = (boolean) MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.acceptPm.default');
        }
        if ($oMbqEtUser->iFollowU->hasSetOriValue()) {
            $data['i_follow_u'] = (boolean) $oMbqEtUser->iFollowU->oriValue;
        } else {
            $data['i_follow_u'] = (boolean) MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.iFollowU.default');
        }
        if ($oMbqEtUser->uFollowMe->hasSetOriValue()) {
            $data['u_follow_me'] = (boolean) $oMbqEtUser->uFollowMe->oriValue;
        } else {
            $data['u_follow_me'] = (boolean) MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.uFollowMe.default');
        }
        if ($oMbqEtUser->acceptFollow->hasSetOriValue()) {
            $data['accept_follow'] = (boolean) $oMbqEtUser->acceptFollow->oriValue;
        } else {
            $data['accept_follow'] = (boolean) MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.acceptFollow.default');
        }
        if ($oMbqEtUser->followingCount->hasSetOriValue()) {
            $data['following_count'] = (int) $oMbqEtUser->followingCount->oriValue;
        }
        if ($oMbqEtUser->follower->hasSetOriValue()) {
            $data['follower'] = (int) $oMbqEtUser->follower->oriValue;
        }
        if ($oMbqEtUser->currentAction->hasSetOriValue()) {
            $data['current_action'] = (string) $oMbqEtUser->currentAction->oriValue;
        }
        if ($oMbqEtUser->topicId->hasSetOriValue()) {
            $data['topic_id'] = (string) $oMbqEtUser->topicId->oriValue;
        }
        if ($oMbqEtUser->canBan->hasSetOriValue()) {
            $data['can_ban'] = (boolean) $oMbqEtUser->canBan->oriValue;
        } else {
            $data['can_ban'] = (boolean) MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.canBan.default');
        }
        if ($oMbqEtUser->isBan->hasSetOriValue()) {
            $data['is_ban'] = (boolean) $oMbqEtUser->isBan->oriValue;
        }
        if ($oMbqEtUser->canMarkSpam->hasSetOriValue()) {
            $data['can_mark_spam'] = (boolean) $oMbqEtUser->canMarkSpam->oriValue;
        } else {
            $data['can_mark_spam'] = (boolean) MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.canMarkSpam.default');
        }
        if ($oMbqEtUser->isSpam->hasSetOriValue()) {
            $data['is_spam'] = (boolean) $oMbqEtUser->isSpam->oriValue;
        }
        if ($oMbqEtUser->reputation->hasSetOriValue()) {
            $data['reputation'] = (int) $oMbqEtUser->reputation->oriValue;
        }
        if ($oMbqEtUser->customFieldsList->hasSetOriValue()) {
            $data['custom_fields_list'] = (array) MbqMain::$oMbqCm->changeArrValueToString($oMbqEtUser->customFieldsList->oriValue);
        }
        return $data;
    }
    
    /**
     * login
     *
     * @param  String  $loginName
     * @param  String  $password
     * @return  Boolean  return true when login success.
     */
    public function login($loginName, $password) {
        $result = MbqMain::$oMbqAppEnv->oApp->login(array('username' => $loginName, 'password' => $password), array('remember' => true));
        if ($result) {
            MbqMain::$oMbqAppEnv->oCurJUser = JFactory::getUser();
            KunenaUserHelper::initialize();
            MbqMain::$oMbqAppEnv->oCurKunenaUser = KunenaUserHelper::getMyself();
            $this->initOCurMbqEtUser();
        }
        return $result ? true : false;
    }
    
    /**
     * get user objs
     *
     * @param  Mixed  $var
     * @param  Array  $mbqOpt
     * $mbqOpt['case'] = 'byUserIds' means get data by user ids.$var is the ids.
     * @return  Array
     */
    public function getObjsMbqEtUser($var, $mbqOpt) {
        if ($mbqOpt['case'] == 'byUserIds') {
            require_once(MBQ_APPEXTENTION_PATH.'ExttMbqKunenaUserHelper.php');
            $userIds = $var;
            $objsKunenaUser = ExttMbqKunenaUserHelper::exttMbqLoadUsers($userIds);
            $objsJUser = array();
            $objsMbqEtUser = array();
            foreach ($userIds as $userId) {
                if ($oJUser = JFactory::getUser($userId)) {
                    $objsJUser[$oJUser->id] = $oJUser;
                }
            }
            foreach ($objsKunenaUser as $oKunenaUser) {
                foreach ($objsJUser as $oJUser) {
                    if ($oKunenaUser->userid && ($oKunenaUser->userid == $oJUser->id)) {
                        $objsMbqEtUser[] = $this->initOMbqEtUser(array('oJuser' => $oJUser, 'oKunenaUser' => $oKunenaUser), array('case' => 'JUserAndKunenaUser'));
                    }
                }
            }
            return $objsMbqEtUser;
        }
        MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_CASE);
    }
    
    /**
     * init one user by condition
     *
     * @param  Mixed  $var
     * @param  Array  $mbqOpt
     * $mbqOpt['case'] = 'JUserAndKunenaUser' means init user by JUser obj and KunenaUser obj.$var['oJuser'] is JUser obj,$var['oKunenaUser'] is KunenaUser obj.
     * $mbqOpt['case'] = 'byUserId' means init user by user id.$var is user id.
     * $mbqOpt['case'] = 'byLoginName' means init user by login name.$var is login name.
     * @return  Mixed
     */
    public function initOMbqEtUser($var, $mbqOpt) {
        if ($mbqOpt['case'] == 'JUserAndKunenaUser') {
            $oJUser = $var['oJuser'];
            $oKunenaUser = $var['oKunenaUser'];
            $oMbqEtUser = MbqMain::$oClk->newObj('MbqEtUser');
            $oMbqEtUser->userId->setOriValue($oJUser->id);
            $oMbqEtUser->loginName->setOriValue($oJUser->username);
            $oMbqEtUser->userName->setOriValue($oJUser->name);
            $oMbqEtUser->userGroupIds->setOriValue(MbqMain::$oMbqCm->removeArrayKey($oJUser->groups));
            $oMbqEtUser->iconUrl->setOriValue($var['oKunenaUser']->getAvatarURL());
            $oMbqEtUser->postCount->setOriValue($var['oKunenaUser']->posts);
            $oMbqEtUser->displayText->setOriValue($var['oKunenaUser']->signature);
            $oMbqEtUser->regTime->setOriValue(strtotime($oJUser->registerDate));
            $oMbqEtUser->lastActivityTime->setOriValue(strtotime($oJUser->lastvisitDate));
            $oMbqEtUser->isOnline->setOriValue($var['oKunenaUser']->isOnline() ? MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.isOnline.range.yes') : MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.isOnline.range.no'));
            $oMbqEtUser->isBan->setOriValue($var['oKunenaUser']->isBanned() ? MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.isBan.range.yes') : MbqBaseFdt::getFdt('MbqFdtUser.MbqEtUser.isBan.range.no'));
            $oMbqEtUser->mbqBind['oJuser'] = $var['oJuser'];
            $oMbqEtUser->mbqBind['oKunenaUser'] = $var['oKunenaUser'];
            return $oMbqEtUser;
        } elseif ($mbqOpt['case'] == 'byUserId') {
            $userIds = array($var);
            $objsMbqEtUser = $this->getObjsMbqEtUser($userIds, array('case' => 'byUserIds'));
            if (is_array($objsMbqEtUser) && (count($objsMbqEtUser) == 1)) {
                return $objsMbqEtUser[0];
            }
            return false;
        } elseif ($mbqOpt['case'] == 'byLoginName') {
            $loginName = $var;
            $oKunenaUser = KunenaFactory::getUser($loginName);
            if ($oKunenaUser->userid) {
                return $this->initOMbqEtUser($oKunenaUser->userid, array('case' => 'byUserId'));
            } else {
                return false;
            }
        }
        MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_CASE);
    }
    
    /**
     * init current user obj if login
     */
    public function initOCurMbqEtUser() {
        if (MbqMain::$oMbqAppEnv->oCurJUser && MbqMain::$oMbqAppEnv->oCurKunenaUser) {
            MbqMain::$oCurMbqEtUser = $this->initOMbqEtUser(array('oJuser' => MbqMain::$oMbqAppEnv->oCurJUser, 'oKunenaUser' => MbqMain::$oMbqAppEnv->oCurKunenaUser), array('case' => 'JUserAndKunenaUser'));
        }
    }
    
    /**
     * get user display name
     *
     * @param  Object  $oMbqEtUser
     * @return  String
     */
    public function getDisplayName($oMbqEtUser) {
        //return $oMbqEtUser->userName->hasSetOriValue() ? $oMbqEtUser->userName->oriValue : $oMbqEtUser->loginName->oriValue;
        return $oMbqEtUser->loginName->oriValue;
    }
  
}

?>