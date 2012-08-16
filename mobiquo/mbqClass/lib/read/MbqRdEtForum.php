<?php

defined('MBQ_IN_IT') or exit;

/**
 * forum read class
 * 
 * @since  2012-8-4
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqRdEtForum extends MbqBaseRd {
    
    public function __construct() {
    }
    
    protected function makeProperty(&$oMbqEtForum, $pName, $mbqOpt = array()) {
        switch ($pName) {
            default:
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_PNAME);
            break;
        }
    }
    
    /**
     * return forum api data
     *
     * @param  Object  $oMbqEtForum
     * @return  Array
     */
    public function returnApiDataForum($oMbqEtForum) {
        $data = array();
        if ($oMbqEtForum->forumId->hasSetOriValue()) {
            $data['forum_id'] = (string) $oMbqEtForum->forumId->oriValue;
        }
        if ($oMbqEtForum->forumName->hasSetOriValue()) {
            $data['forum_name'] = (string) $oMbqEtForum->forumName->oriValue;
        }
        if ($oMbqEtForum->canPost->hasSetOriValue()) {
            $data['can_post'] = (boolean) $oMbqEtForum->canPost->oriValue;
        } else {
            $data['can_post'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForum.canPost.default');
        }
        if ($oMbqEtForum->description->hasSetOriValue()) {
            $data['description'] = (string) $oMbqEtForum->description->oriValue;
        }
        if ($oMbqEtForum->totalTopicNum->hasSetOriValue()) {
            $data['total_topic_num'] = (int) $oMbqEtForum->totalTopicNum->oriValue;
        }
        if ($oMbqEtForum->parentId->hasSetOriValue()) {
            $data['parent_id'] = (string) $oMbqEtForum->parentId->oriValue;
        }
        if ($oMbqEtForum->logoUrl->hasSetOriValue()) {
            $data['logo_url'] = (string) $oMbqEtForum->logoUrl->oriValue;
        }
        if ($oMbqEtForum->newPost->hasSetOriValue()) {
            $data['new_post'] = (boolean) $oMbqEtForum->newPost->oriValue;
        }
        if ($oMbqEtForum->isProtected->hasSetOriValue()) {
            $data['is_protected'] = (boolean) $oMbqEtForum->isProtected->oriValue;
        }
        if ($oMbqEtForum->isSubscribed->hasSetOriValue()) {
            $data['is_subscribed'] = (boolean) $oMbqEtForum->isSubscribed->oriValue;
        }
        if ($oMbqEtForum->canSubscribe->hasSetOriValue()) {
            $data['can_subscribe'] = (boolean) $oMbqEtForum->canSubscribe->oriValue;
        } else {
            $data['can_subscribe'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForum.canSubscribe.default');
        }
        if ($oMbqEtForum->url->hasSetOriValue()) {
            $data['url'] = (string) $oMbqEtForum->url->oriValue;
        }
        if ($oMbqEtForum->subOnly->hasSetOriValue()) {
            $data['sub_only'] = (boolean) $oMbqEtForum->subOnly->oriValue;
        }
        if ($oMbqEtForum->canPost->hasSetOriValue()) {
            $data['can_post'] = (boolean) $oMbqEtForum->canPost->oriValue;
        } else {
            $data['can_post'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForum.canPost.default');
        }
        if ($oMbqEtForum->unreadStickyCount->hasSetOriValue()) {
            $data['unread_sticky_count'] = (int) $oMbqEtForum->unreadStickyCount->oriValue;
        }
        if ($oMbqEtForum->unreadAnnounceCount->hasSetOriValue()) {
            $data['unread_announce_count'] = (int) $oMbqEtForum->unreadAnnounceCount->oriValue;
        }
        if ($oMbqEtForum->requirePrefix->hasSetOriValue()) {
            $data['require_prefix'] = (boolean) $oMbqEtForum->requirePrefix->oriValue;
        }
        $data['prefixes'] = (array) $oMbqEtForum->prefixes->oriValue;
        if ($oMbqEtForum->canUpload->hasSetOriValue()) {
            $data['can_upload'] = (boolean) $oMbqEtForum->canUpload->oriValue;
        } else {
            $data['can_upload'] = (boolean) MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForum.canUpload.default');
        }
        $data['child'] = array();
        $this->recurMakeApiTreeDataForum($data['child'], $oMbqEtForum->objsSubMbqEtForum);
        return $data;
    }
    
    /**
     * recur make forum tree api data
     *
     * @param  Array  $dataChild
     * @param  Array  $objsSubMbqEtForum
     */
    private function recurMakeApiTreeDataForum(&$dataChild, $objsSubMbqEtForum) {
        $j = 0;
        foreach ($objsSubMbqEtForum as $$oMbqEtForum) {
            $dataChild[$j] = $this->returnApiDataForum($$oMbqEtForum);
            $j ++;
        }
    }
    
    /**
     * return forum tree api data
     *
     * @param  Array  $tree  forum tree
     * @return  Array
     */
    public function returnApiTreeDataForum($tree) {
        $data = array();
        $i = 0;
        foreach ($tree as $oMbqEtForum) {
            $data[$i] = $this->returnApiDataForum($oMbqEtForum);
            $i ++;
        }
        return $data;
    }
    
    /**
     * get forum tree structure
     *
     * @return  Array
     */
    public function getForumTree() {
        $arr = KunenaForumCategoryHelper::getCategories();
        $level = 0;
        $tree = array();
        $newTree = array();
        $i = 0;
        foreach ($arr as $oKunenaForumCategory) {
            if ($oKunenaForumCategory->level == $level) {
                $tree[$i]['obj'] = $oKunenaForumCategory;
                $tree[$i]['children'] = array();
                $this->exttRecurGetKunenaForumCategoryTree($arr, $tree[$i]);
                $i ++;
            }
        }
        foreach ($tree as $item) {
            $id = $item['obj']->id;
            $newTree[$id] = $this->initOMbqEtForum($item['obj'], array('case' => 'oKunenaForumCategory'));
            $this->exttRecurInitObjsSubMbqEtForum($newTree[$id], $item['children'], array('case' => 'objsKunenaForumCategory'));
        }
        return $newTree;
    }
    /**
     * recursive get KunenaForumCategory tree
     *
     * @param  Array  $arr
     * @param  Array  $treeI
     */
    private function exttRecurGetKunenaForumCategoryTree(&$arr, &$treeI) {
        $j = 0;
        foreach ($arr as $oKunenaForumCategory) {
            if ($oKunenaForumCategory->parent_id == $treeI['obj']->id) {
                $treeI['children'][$j]['obj'] = $oKunenaForumCategory;
                $treeI['children'][$j]['children'] = array();
                $this->exttRecurGetKunenaForumCategoryTree($arr, $treeI['children'][$j]);
                $j ++;
            }
        }
    }
    /**
     * recursive init objsSubMbqEtForum
     *
     * @param  Object  $oMbqEtForum  the object need init objsSubMbqEtForum
     * @param  Array  
     * @param  Array  $mbqOpt
     * $mbqOpt['objsKunenaForumCategory'] means init forum by KunenaForumCategory objs
     */
    private function exttRecurInitObjsSubMbqEtForum(&$oMbqEtForum, $arr, $mbqOpt) {
        $i = 0;
        foreach ($arr as $item) {
            $oMbqEtForum->objsSubMbqEtForum[$i] = $this->initOMbqEtForum($item['obj'], array('case' => 'oKunenaForumCategory'));
            $this->exttRecurInitObjsSubMbqEtForum($oMbqEtForum->objsSubMbqEtForum[$i], $item['children'], array('case' => 'objsKunenaForumCategory'));
            $i ++;
        }
    }
    
    /**
     * get forum objs
     *
     * @param  Mixed  $var
     * @param  Array  $mbqOpt
     * $mbqOpt['case'] = 'byForumIds' means get data by forum ids.$var is the ids.
     * @return  Array
     */
    public function getObjsMbqEtForum($var, $mbqOpt) {
        if ($mbqOpt['case'] == 'byForumIds') {
            $forumIds = $var;
            $objsKunenaForumCategory = KunenaForumCategoryHelper::getCategories($forumIds);
            $objsMbqEtForum = array();
            foreach ($objsKunenaForumCategory as $oKunenaForumCategory) {
                $objsMbqEtForum[] = $this->initOMbqEtForum($oKunenaForumCategory, array('case' => 'oKunenaForumCategory'));
            }
            return $objsMbqEtForum;
        }
        MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_CASE);
    }
    
    /**
     * init one forum by condition
     *
     * @param  Mixed  $var
     * @param  Array  $mbqOpt
     * $mbqOpt['case'] = 'oKunenaForumCategory' means init forum by KunenaForumCategory obj
     * @return  Mixed
     */
    public function initOMbqEtForum($var, $mbqOpt) {
        if ($mbqOpt['case'] == 'oKunenaForumCategory') {
            $oMbqEtForum = MbqMain::$oClk->newObj('MbqEtForum');
            $oMbqEtForum->forumId->setOriValue($var->id);
            $oMbqEtForum->forumName->setOriValue($var->name);
            $oMbqEtForum->description->setOriValue($var->description);
            $oMbqEtForum->totalTopicNum->setOriValue($var->numTopics);
            $oMbqEtForum->parentId->setOriValue($var->parent_id);
            $oMbqEtForum->subOnly->setOriValue($var->parent_id == 0 ? MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForum.subOnly.range.yes') : MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForum.subOnly.range.no'));
            $oMbqEtForum->mbqBind['oKunenaForumCategory'] = $var;
            return $oMbqEtForum;
        }
        MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_CASE);
    }
  
}

?>