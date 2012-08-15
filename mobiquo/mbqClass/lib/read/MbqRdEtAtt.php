<?php

defined('MBQ_IN_IT') or exit;

/**
 * attachment read class
 * 
 * @since  2012-8-14
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqRdEtAtt extends MbqBaseRd {
    
    public function __construct() {
    }
    
    protected function makeProperty(&$oMbqEtAtt, $pName, $mbqOpt = array()) {
        switch ($pName) {
            default:
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_PNAME);
            break;
        }
    }
    
    /**
     * return attachment api data
     *
     * @param  Object  $oMbqEtAtt
     * @return  Array
     */
    public function returnApiDataAttachment($oMbqEtAtt) {
        $data = array();
        if ($oMbqEtAtt->attId->hasSetOriValue()) {
            $data['attachment_id'] = (string) $oMbqEtAtt->attId->oriValue;
        }
        if ($oMbqEtAtt->groupId->hasSetOriValue()) {
            $data['group_id'] = (string) $oMbqEtAtt->groupId->oriValue;
        }
        if ($oMbqEtAtt->forumId->hasSetOriValue()) {
            $data['forum_id'] = (string) $oMbqEtAtt->forumId->oriValue;
        }
        if ($oMbqEtAtt->postId->hasSetOriValue()) {
            $data['post_id'] = (string) $oMbqEtAtt->postId->oriValue;
        }
        if ($oMbqEtAtt->filtersSize->hasSetOriValue()) {
            $data['filters_size'] = (int) $oMbqEtAtt->filtersSize->oriValue;
        }
        if ($oMbqEtAtt->contentType->hasSetOriValue()) {
            $data['content_type'] = (string) $oMbqEtAtt->contentType->oriValue;
        }
        if ($oMbqEtAtt->thumbnailUrl->hasSetOriValue()) {
            $data['thumbnail_url'] = (string) $oMbqEtAtt->thumbnailUrl->oriValue;
        }
        if ($oMbqEtAtt->url->hasSetOriValue()) {
            $data['url'] = (string) $oMbqEtAtt->url->oriValue;
        }
        return $data;
    }
    
    /**
     * return attachment array api data
     *
     * @param  Array  $objsMbqEtAtt
     * @return  Array
     */
    public function returnApiArrDataAttachment($objsMbqEtAtt) {
        $data = array();
        foreach ($objsMbqEtAtt as $oMbqEtAtt) {
            $data[] = $this->returnApiDataAttachment($oMbqEtAtt);
        }
        return $data;
    }
    
    /**
     * get attachment objs
     *
     * @param  Mixed  $var
     * @param  Array  $mbqOpt
     * $mbqOpt['case'] = 'byForumPostIds' means get data by forum post ids.$var is the ids.
     * @return  Mixed
     */
    public function getObjsMbqEtAtt($var, $mbqOpt) {
        if ($mbqOpt['case'] == 'byForumPostIds') {
            $postIds = $var;
            $objsKunenaForumMessageAttachment = KunenaForumMessageAttachmentHelper::getByMessage($postIds);
            $objsMbqEtAtt = array();
            foreach ($objsKunenaForumMessageAttachment as $oKunenaForumMessageAttachment) {
                $objsMbqEtAtt[] = $this->initOMbqEtAtt($oKunenaForumMessageAttachment, array('case' => 'oKunenaForumMessageAttachment'));
            }
            return $objsMbqEtAtt;
        }
        MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_CASE);
    }
    
    /**
     * init one attachment by condition
     *
     * @param  Mixed  $var
     * @param  Array  $mbqOpt
     * $mbqOpt['case'] = 'oKunenaForumMessageAttachment' means init attachment by KunenaForumMessageAttachment obj
     * @return  Mixed
     */
    public function initOMbqEtAtt($var, $mbqOpt) {
        if ($mbqOpt['case'] == 'oKunenaForumMessageAttachment') {
            $oMbqEtAtt = MbqMain::$oClk->newObj('MbqEtAtt');
            $oMbqEtAtt->attId->setOriValue($var->id);
            $oMbqEtAtt->postId->setOriValue($var->mesid);
            $oMbqEtAtt->filtersSize->setOriValue($var->size);
            $oMbqEtAtt->uploadFileName->setOriValue($var->filename);
            $oMbqEtAtt->attType->setOriValue(MbqBaseFdt::getFdt('MbqFdtAtt.MbqEtAtt.attType.range.forumPostAtt'));
            $ext = MbqMain::$oMbqCm->getFileExtension($oMbqEtAtt->uploadFileName->oriValue);
            if ($ext == 'jpeg' || $ext == 'gif' || $ext == 'bmp' || $ext == 'png' || $ext == 'jpg') {
                $contentType = MbqBaseFdt::getFdt('MbqFdtAtt.MbqEtAtt.contentType.range.image');
            } elseif ($ext == 'pdf') {
                $contentType = MbqBaseFdt::getFdt('MbqFdtAtt.MbqEtAtt.contentType.range.pdf');
            } else {
                $contentType = MbqBaseFdt::getFdt('MbqFdtAtt.MbqEtAtt.contentType.range.other');
            }     
            $oMbqEtAtt->contentType->setOriValue($contentType);
            $oMbqEtAtt->thumbnailUrl->setOriValue(preg_replace('/<a .*?href="(.*?)".*?>.*?<\/a>/i', '$1', $var->getThumbnailLink()));
            $oMbqEtAtt->url->setOriValue(preg_replace('/<a .*?href="(.*?)".*?>.*?<\/a>/i', '$1', $var->getImageLink()));
            $oMbqEtAtt->userId->setOriValue($var->userid);
            $oMbqEtAtt->mbqBind['oKunenaForumMessageAttachment'] = $var;
            return $oMbqEtAtt;
        }
        MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_CASE);
    }
  
}

?>