<?php

defined('MBQ_IN_IT') or exit;

/**
 * forum read class
 * 
 * @since  2012-8-4
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqRdEtForum {
    
    public function __construct() {
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
        if ($oMbqEtForum->description->hasSetOriValue()) {
            $data['description'] = (string) $oMbqEtForum->description->oriValue;
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
        }
        if ($oMbqEtForum->url->hasSetOriValue()) {
            $data['url'] = (string) $oMbqEtForum->url->oriValue;
        }
        if ($oMbqEtForum->subOnly->hasSetOriValue()) {
            $data['sub_only'] = (boolean) $oMbqEtForum->subOnly->oriValue;
        }
        if ($oMbqEtForum->canPost->hasSetOriValue()) {
            $data['can_post'] = (boolean) $oMbqEtForum->canPost->oriValue;
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
        if ($oMbqEtForum->prefixes->hasSetOriValue()) {
            $data['prefixes'] = (array) $oMbqEtForum->prefixes->oriValue;
        }
        if ($oMbqEtForum->canUpload->hasSetOriValue()) {
            $data['can_upload'] = (boolean) $oMbqEtForum->canUpload->oriValue;
        }
        if ($oMbqEtForum->objsSubMbqEtForum) {
            $data['child'] = array();
            $this->recurMakeApiDataForumTree($data['child'], $oMbqEtForum->objsSubMbqEtForum);
        }
        return $data;
    }
    
    /**
     * return forum tree api data
     *
     * @param  Array  $tree  forum tree
     * @return  Array
     */
    public function returnApiDataForumTree($tree) {
        $data = array();
        $i = 0;
        foreach ($tree as $oMbqEtForum) {
            $data[$i] = $this->returnApiDataForum($oMbqEtForum);
            $i ++;
        }
        return $data;
    }
    
    /**
     * recur make forum tree api data
     *
     * @param  Array  $dataChild
     * @param  Array  $objsSubMbqEtForum
     */
    private function recurMakeApiDataForumTree(&$dataChild, $objsSubMbqEtForum) {
        $j = 0;
        foreach ($objsSubMbqEtForum as $$oMbqEtForum) {
            $dataChild[$j] = $this->returnApiDataForum($$oMbqEtForum);
            $j ++;
        }
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
     * init forum by condition
     *
     * @param  Mixed  $var
     * @param  Array  $mbqOpt
     * $mbqOpt['oKunenaForumCategory'] means init forum by KunenaForumCategory obj
     * @return  Object
     */
    public function initOMbqEtForum($var, $mbqOpt) {
        $oMbqEtForum = MbqMain::$oClk->newObj('MbqEtForum');
        $oMbqEtForum->forumId->setOriValue($var->id);
        $oMbqEtForum->forumName->setOriValue($var->name);
        $oMbqEtForum->description->setOriValue($var->description);
        $oMbqEtForum->parentId->setOriValue($var->parent_id);
        $oMbqEtForum->subOnly->setOriValue($var->parent_id == 0 ? MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForum.subOnly.range.yes') : MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForum.subOnly.range.no'));
        return $oMbqEtForum;
    }
  
}

?>