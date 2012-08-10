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
    
    /**
     * make obj property
     *
     * @param  Object  $oMbqEtUser
     * @param  String  $pName  property name
     */
    protected function makeProperty($oMbqEtUser, $pName) {
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
        }
        if ($oMbqEtUser->canSendPm->hasSetOriValue()) {
            $data['can_send_pm'] = (boolean) $oMbqEtUser->canSendPm->oriValue;
        }
        if ($oMbqEtUser->canModerate->hasSetOriValue()) {
            $data['can_moderate'] = (boolean) $oMbqEtUser->canModerate->oriValue;
        }
        if ($oMbqEtUser->canSearch->hasSetOriValue()) {
            $data['can_search'] = (boolean) $oMbqEtUser->canSearch->oriValue;
        }
        if ($oMbqEtUser->canWhosonline->hasSetOriValue()) {
            $data['can_whosonline'] = (boolean) $oMbqEtUser->canWhosonline->oriValue;
        }
        if ($oMbqEtUser->canUploadAvatar->hasSetOriValue()) {
            $data['can_upload_avatar'] = (string) $oMbqEtUser->canUploadAvatar->oriValue;
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
        }
        if ($oMbqEtUser->iFollowU->hasSetOriValue()) {
            $data['i_follow_u'] = (boolean) $oMbqEtUser->iFollowU->oriValue;
        }
        if ($oMbqEtUser->uFollowMe->hasSetOriValue()) {
            $data['u_follow_me'] = (boolean) $oMbqEtUser->uFollowMe->oriValue;
        }
        if ($oMbqEtUser->acceptFollow->hasSetOriValue()) {
            $data['accept_follow'] = (boolean) $oMbqEtUser->acceptFollow->oriValue;
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
        }
        if ($oMbqEtUser->isBan->hasSetOriValue()) {
            $data['is_ban'] = (boolean) $oMbqEtUser->isBan->oriValue;
        }
        if ($oMbqEtUser->canMarkSpam->hasSetOriValue()) {
            $data['can_mark_spam'] = (boolean) $oMbqEtUser->canMarkSpam->oriValue;
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
                    if ($oKunenaUser->userid == $oJUser->id) {
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
     * $mbqOpt['case'] = 'JUserAndKunenaUser' means init user by JUser obj and KunenaUser obj
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
            $oMbqEtUser->regTime->setOriValue(strtotime($oJUser->registerDate));
            $oMbqEtUser->lastActivityTime->setOriValue(strtotime($oJUser->lastvisitDate));
            return $oMbqEtUser;
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
        return $oMbqEtUser->userName->hasSetOriValue() ? $oMbqEtUser->userName->oriValue : $oMbqEtUser->loginName->oriValue;
    }
  
}

?>