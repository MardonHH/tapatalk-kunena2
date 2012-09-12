<?php

defined('MBQ_IN_IT') or exit;

MbqMain::$oClk->includeClass('MbqBaseRdEtForumPost');

/**
 * forum post read class
 * 
 * @since  2012-8-13
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqRdEtForumPost extends MbqBaseRdEtForumPost {
    
    public function __construct() {
    }
    
    protected function makeProperty(&$oMbqEtForumPost, $pName, $mbqOpt = array()) {
        switch ($pName) {
            case 'oAuthorMbqEtUser':
            $oMbqRdEtUser = MbqMain::$oClk->newObj('MbqRdEtUser');
            if ($oMbqEtUser = $oMbqRdEtUser->initOMbqEtUser($oMbqEtForumPost->postAuthorId->oriValue, array('case' => 'byUserId'))) {
                $oMbqEtForumPost->oAuthorMbqEtUser = $oMbqEtUser;
            }
            break;
            case 'objsMbqEtAtt':
            $postIds = array($oMbqEtForumPost->postId->oriValue);
            $oMbqRdEtAtt = MbqMain::$oClk->newObj('MbqRdEtAtt');
            $objsMbqEtAtt = $oMbqRdEtAtt->getObjsMbqEtAtt($postIds, array('case' => 'byForumPostIds'));
            $oMbqEtForumPost->objsMbqEtAtt = $objsMbqEtAtt;
            break;
            case 'objsNotInContentMbqEtAtt':
            $attIds = MbqMain::$oMbqCm->getAttIdsFromContent($oMbqEtForumPost->postContent->oriValue);
            foreach ($oMbqEtForumPost->objsMbqEtAtt as $oMbqEtAtt) {
                if (!in_array($oMbqEtAtt->attId->oriValue, $attIds)) {
                    $oMbqEtForumPost->objsNotInContentMbqEtAtt[] = $oMbqEtAtt;
                }
            }
            break;
            case 'byOAuthorMbqEtUser':   /* make properties by oAuthorMbqEtUser */
            if ($oMbqEtForumPost->oAuthorMbqEtUser) {
                if ($oMbqEtForumPost->oAuthorMbqEtUser->isOnline->hasSetOriValue()) {
                    $oMbqEtForumPost->isOnline->setOriValue($oMbqEtForumPost->oAuthorMbqEtUser->isOnline->oriValue ? MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumPost.isOnline.range.yes') : MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumPost.isOnline.range.no'));
                }
                if ($oMbqEtForumPost->oAuthorMbqEtUser->iconUrl->hasSetOriValue()) {
                    $oMbqEtForumPost->authorIconUrl->setOriValue($oMbqEtForumPost->oAuthorMbqEtUser->iconUrl->oriValue);
                }
            }
            break;
            case 'oMbqEtForum':
            if ($oMbqEtForumPost->forumId->hasSetOriValue()) {
                $oMbqRdEtForum = MbqMain::$oClk->newObj('MbqRdEtForum');
                if ($objsMbqEtForum = $oMbqRdEtForum->getObjsMbqEtForum(array($oMbqEtForumPost->forumId->oriValue), array('case' => 'byForumIds'))) {
                    $oMbqEtForumPost->oMbqEtForum = $objsMbqEtForum[0];
                }
            }
            break;
            case 'oMbqEtForumTopic':
            if ($oMbqEtForumPost->topicId->hasSetOriValue()) {
                $oMbqRdEtForumTopic = MbqMain::$oClk->newObj('MbqRdEtForumTopic');
                if ($oMbqEtForumTopic = $oMbqRdEtForumTopic->initOMbqEtForumTopic($oMbqEtForumPost->topicId->oriValue, array('case' => 'byTopicId', 'oFirstMbqEtForumPost' => false))) {  /* must set 'oFirstMbqEtForumPost' to false,otherwise will cause infinite recursion call for get oMbqEtForumTopic and oFirstMbqEtForumPost and make memory depleted!!! */
                    $oMbqEtForumPost->oMbqEtForumTopic = $oMbqEtForumTopic;
                }
            }
            break;
            default:
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_PNAME . ':' . $pName . '.');
            break;
        }
    }
    
    /**
     * get forum post objs
     *
     * @param  Mixed  $var
     * @param  Array  $mbqOpt
     * $mbqOpt['case'] = 'byTopic' means get data by forum topic obj.$var is the forum topic obj.
     * $mbqOpt['case'] = 'byObjsKunenaForumMessage' means get data by objsKunenaForumMessage.$var is the objsKunenaForumMessage.
     * @return  Mixed
     */
    public function getObjsMbqEtForumPost($var, $mbqOpt) {
        if ($mbqOpt['case'] == 'byTopic') {
            $oMbqEtForumTopic = $var;
            if ($mbqOpt['oMbqDataPage']) {
                $oMbqDataPage = $mbqOpt['oMbqDataPage'];
                require_once(MBQ_APPEXTENTION_PATH.'ExttMbqKunenaModelTopic.php');
                $oExttMbqKunenaModelTopic = new ExttMbqKunenaModelTopic();
                //$oExttMbqKunenaModelTopic->setState('item.id', $oMbqEtForumTopic->topicId->oriValue);
                //$oExttMbqKunenaModelTopic->setState('list.start', $oMbqDataPage->startNum);
                //$oExttMbqKunenaModelTopic->setState('list.limit', $oMbqDataPage->numPerPage);
                $objsKunenaForumMessage = $oExttMbqKunenaModelTopic->exttMbqGetMessages(array('topicId' => $oMbqEtForumTopic->topicId->oriValue, 'start' => $oMbqDataPage->startNum, 'limit' => $oMbqDataPage->numPerPage));
                /* common begin */
                $mbqOpt['case'] = 'byObjsKunenaForumMessage';
                $mbqOpt['oMbqDataPage'] = $oMbqDataPage;
                return $this->getObjsMbqEtForumPost($objsKunenaForumMessage, $mbqOpt);
                /* common end */
            }
        } elseif ($mbqOpt['case'] == 'byObjsKunenaForumMessage') {
            if ($mbqOpt['oMbqDataPage']) {
                $oMbqDataPage = $mbqOpt['oMbqDataPage'];
                $objsKunenaForumMessage = $var;
                /* common begin */
                $objsMbqEtForumPost = array();
                $authorUserIds = array();
                $forumIds = array();
                $topicIds = array();
                foreach ($objsKunenaForumMessage as $oKunenaForumMessage) {
                    $objsMbqEtForumPost[] = $this->initOMbqEtForumPost($oKunenaForumMessage, array('case' => 'oKunenaForumMessage', 'withAuthor' => false, 'withAtt' => false, 'withObjsNotInContentMbqEtAtt' => false, 'oMbqEtForum' => false, 'oMbqEtForumTopic' => false));
                }
                foreach ($objsMbqEtForumPost as $oMbqEtForumPost) {
                    $authorUserIds[$oMbqEtForumPost->postAuthorId->oriValue] = $oMbqEtForumPost->postAuthorId->oriValue;
                    $forumIds[$oMbqEtForumPost->forumId->oriValue] = $oMbqEtForumPost->forumId->oriValue;
                    $topicIds[$oMbqEtForumPost->topicId->oriValue] = $oMbqEtForumPost->topicId->oriValue;
                }
                /* load oMbqEtForum property */
                $oMbqRdEtForum = MbqMain::$oClk->newObj('MbqRdEtForum');
                $objsMbqEtForum = $oMbqRdEtForum->getObjsMbqEtForum($forumIds, array('case' => 'byForumIds'));
                foreach ($objsMbqEtForum as $oNewMbqEtForum) {
                    foreach ($objsMbqEtForumPost as &$oMbqEtForumPost) {
                        if ($oNewMbqEtForum->forumId->oriValue == $oMbqEtForumPost->forumId->oriValue) {
                            $oMbqEtForumPost->oMbqEtForum = $oNewMbqEtForum;
                        }
                    }
                }
                /* load oMbqEtForumTopic property */
                $oMbqRdEtForumTopic = MbqMain::$oClk->newObj('MbqRdEtForumTopic');
                $objsMbqEtFroumTopic = $oMbqRdEtForumTopic->getObjsMbqEtForumTopic($topicIds, array('case' => 'byTopicIds'));
                foreach ($objsMbqEtFroumTopic as $oNewMbqEtFroumTopic) {
                    foreach ($objsMbqEtForumPost as &$oMbqEtForumPost) {
                        if ($oNewMbqEtFroumTopic->topicId->oriValue == $oMbqEtForumPost->topicId->oriValue) {
                            $oMbqEtForumPost->oMbqEtForumTopic = $oNewMbqEtFroumTopic;
                        }
                    }
                }
                /* load post author */
                $oMbqRdEtUser = MbqMain::$oClk->newObj('MbqRdEtUser');
                $objsAuthorMbqEtUser = $oMbqRdEtUser->getObjsMbqEtUser($authorUserIds, array('case' => 'byUserIds'));
                $postIds = array();
                foreach ($objsMbqEtForumPost as &$oMbqEtForumPost) {
                    $postIds[] = $oMbqEtForumPost->postId->oriValue;
                    foreach ($objsAuthorMbqEtUser as $oAuthorMbqEtUser) {
                        if ($oMbqEtForumPost->postAuthorId->oriValue == $oAuthorMbqEtUser->userId->oriValue) {
                            $oMbqEtForumPost->oAuthorMbqEtUser = $oAuthorMbqEtUser;
                            break;
                        }
                    }
                }
                /* load attachment */
                $oMbqRdEtAtt = MbqMain::$oClk->newObj('MbqRdEtAtt');
                $objsMbqEtAtt = $oMbqRdEtAtt->getObjsMbqEtAtt($postIds, array('case' => 'byForumPostIds'));
                foreach ($objsMbqEtAtt as $oMbqEtAtt) {
                    foreach ($objsMbqEtForumPost as &$oMbqEtForumPost) {
                        if ($oMbqEtAtt->isForumPostAtt() && ($oMbqEtAtt->postId->oriValue == $oMbqEtForumPost->postId->oriValue)) {
                            $oMbqEtForumPost->objsMbqEtAtt[] = $oMbqEtAtt;
                            break;
                        }
                    }
                }
                /* load objsNotInContentMbqEtAtt */
                foreach ($objsMbqEtForumPost as &$oMbqEtForumPost) {
                    $this->makeProperty($oMbqEtForumPost, 'objsNotInContentMbqEtAtt');
                }
                foreach ($objsMbqEtForumPost as &$oMbqEtForumPost) {
                    $this->makeProperty($oMbqEtForumPost, 'byOAuthorMbqEtUser');
                }
                $oMbqDataPage->datas = $objsMbqEtForumPost;
                return $oMbqDataPage;
                /* common end */
            }
        }
        MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_CASE);
    }
    
    /**
     * init one forum post by condition
     *
     * @param  Mixed  $var
     * @param  Array  $mbqOpt
     * $mbqOpt['case'] = 'oKunenaForumMessage' means init forum post by KunenaForumMessage obj
     * $mbqOpt['case'] = 'byPostId' means init forum post by post id
     * $mbqOpt['withAuthor'] = true means load post author,default is true
     * $mbqOpt['withAtt'] = true means load post attachments,default is true
     * $mbqOpt['withObjsNotInContentMbqEtAtt'] = true means load the attachement objs not in the content,default is true
     * $mbqOpt['oMbqEtForum'] = true means load oMbqEtForum property of this post,default is true
     * $mbqOpt['oMbqEtForumTopic'] = true means load oMbqEtForumTopic property of this post,default is true
     * @return  Mixed
     */
    public function initOMbqEtForumPost($var, $mbqOpt) {
        $mbqOpt['withAuthor'] = isset($mbqOpt['withAuthor']) ? $mbqOpt['withAuthor'] : true;
        $mbqOpt['withAtt'] = isset($mbqOpt['withAtt']) ? $mbqOpt['withAtt'] : true;
        $mbqOpt['withObjsNotInContentMbqEtAtt'] = isset($mbqOpt['withObjsNotInContentMbqEtAtt']) ? $mbqOpt['withObjsNotInContentMbqEtAtt'] : true;
        $mbqOpt['oMbqEtForum'] = isset($mbqOpt['oMbqEtForum']) ? $mbqOpt['oMbqEtForum'] : true;
        $mbqOpt['oMbqEtForumTopic'] = isset($mbqOpt['oMbqEtForumTopic']) ? $mbqOpt['oMbqEtForumTopic'] : true;
        if ($mbqOpt['case'] == 'oKunenaForumMessage') {
            require_once(MBQ_APPEXTENTION_PATH.'ExttMbqKunenaViewTopic.php');
            $oExttMbqKunenaViewTopic = new ExttMbqKunenaViewTopic();
            $oMbqEtForumPost = MbqMain::$oClk->newObj('MbqEtForumPost');
            $oMbqEtForumPost->postId->setOriValue($var->id);
            $oMbqEtForumPost->parentPostId->setOriValue($var->parent);
            $oMbqEtForumPost->forumId->setOriValue($var->catid);
            $oMbqEtForumPost->topicId->setOriValue($var->thread);
            $oMbqEtForumPost->postTitle->setOriValue($var->subject);
            $oMbqEtForumPost->postContent->setOriValue($var->message);
            $newVar = clone $var;
            $newVar->message = MbqMain::$oMbqCm->replaceCode($newVar->message);  /* do some change for process */
            $oMbqEtForumPost->postContent->setAppDisplayValue($oExttMbqKunenaViewTopic->exttMbqReturnDisplayMessageContents($var));
            $oMbqEtForumPost->postContent->setTmlDisplayValue($this->processContentForDisplay($oExttMbqKunenaViewTopic->exttMbqReturnDisplayMessageContents($newVar), true));
            $oMbqEtForumPost->postContent->setTmlDisplayValueNoHtml($this->processContentForDisplay($oExttMbqKunenaViewTopic->exttMbqReturnDisplayMessageContents($newVar), false));
            $oMbqEtForumPost->shortContent->setOriValue(MbqMain::$oMbqCm->getShortContent($var->message));
            $oMbqEtForumPost->postAuthorId->setOriValue($var->userid);
            if ($var->authorise('edit')) {
                $oMbqEtForumPost->canEdit->setOriValue(MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumPost.canEdit.range.yes'));
            } else {
                $oMbqEtForumPost->canEdit->setOriValue(MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumPost.canEdit.range.no'));
            }
            $oMbqEtForumPost->postTime->setOriValue($var->time);
            $oMbqEtForumPost->mbqBind['oKunenaForumMessage'] = $var;
            if ($mbqOpt['oMbqEtForum']) {
                /* load oMbqEtForum property */
                $this->makeProperty($oMbqEtForumPost, 'oMbqEtForum');
            }
            if ($mbqOpt['oMbqEtForumTopic']) {
                /* load oMbqEtForumTopic property */
                $this->makeProperty($oMbqEtForumPost, 'oMbqEtForumTopic');
            }
            if ($mbqOpt['withAuthor']) {
                /* load post author */
                $this->makeProperty($oMbqEtForumPost, 'oAuthorMbqEtUser');
            }
            if ($mbqOpt['withAtt']) {
                /* load attachment */
                $this->makeProperty($oMbqEtForumPost, 'objsMbqEtAtt');
            }
            if ($mbqOpt['withObjsNotInContentMbqEtAtt']) {
                /* load objsNotInContentMbqEtAtt */
                $this->makeProperty($oMbqEtForumPost, 'objsNotInContentMbqEtAtt');
            }
            $this->makeProperty($oMbqEtForumPost, 'byOAuthorMbqEtUser');
            return $oMbqEtForumPost;
        } elseif ($mbqOpt['case'] == 'byPostId') {
            require_once(KPATH_ADMIN.'/libraries/forum/message/helper.php');
            if (($oKunenaForumMessage = KunenaForumMessageHelper::get($var)) && $oKunenaForumMessage->id) {
                $mbqOpt['case'] = 'oKunenaForumMessage';
                return $this->initOMbqEtForumPost($oKunenaForumMessage, $mbqOpt);
            }
            return false;
        }
        MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_CASE);
    }
    
    /**
     * process content for display in mobile app
     *
     * @params  String  $content
     * @params  Boolean  $returnHtml
     * @return  String
     */
    public function processContentForDisplay($content, $returnHtml) {
        /*
        support bbcode:url/img/quoet
        support html:br/i/b/u/font+color(red/blue)
        <strong> -> <b>
        attention input param:return_html
        attention output param:post_content
        */
        $post = $content;
        $post = MbqMain::$oMbqCm->unreplaceCode($post);
        /* change the &quot; in quote bbcode to " maked by kunena! */
        $post = preg_replace('/\[quote=&quot;(.*?)&quot;.*?\]/i', '[quote="$1"]', $post);
        $returnHtml = $returnHtml;
    	if($returnHtml){
    		//$post = str_replace("&", '&amp;', $post);
    		//$post = str_replace("<", '&lt;', $post);
    		//$post = str_replace(">", '&gt;', $post);
    		$post = str_ireplace("[b]", '<b>', $post);
    		$post = str_ireplace("[/b]", '</b>', $post);
    		$post = str_ireplace("[i]", '<i>', $post);
    		$post = str_ireplace("[/i]", '</i>', $post);
    		$post = str_ireplace("[u]", '<u>', $post);
    		$post = str_ireplace("[/u]", '</u>', $post);
    		$post = str_replace("\r", '', $post);
    		//$post = str_replace("\n", '<br />', $post);
    		$post = str_ireplace('[hr]', '<br />____________________________________<br />', $post);
            $post = str_ireplace('<hr />', '<br />____________________________________<br />', $post);
    	} else {
    	    $post = preg_replace('/<br \/>/i', "\n", $post);
    		$post = str_ireplace('[hr]', "\n____________________________________\n", $post);
            $post = str_ireplace('<hr />', "\n____________________________________\n", $post);
    		//$post = strip_tags($post);
    		$post = html_entity_decode($post, ENT_QUOTES, 'UTF-8');
            // strip remaining bbcode
            //$post = preg_replace('/\[\/?.*?\]/i', '', $post);
    	}
    	$post = preg_replace('/\[quote="(.*?)".*?\]/i', '$1 wrote:[quote]', $post);
    	$post = preg_replace('/<a .*?><img .*?src="(.*?)" .*?\/><\/a>/i', '[img]$1[/img]', $post);
    	$post = preg_replace('/<a .*?href="(.*?)".*?>(.*?)<\/a>/i', '[url=$1]$2[/url]', $post);
    	/* replace the expression begin */
    	$post = preg_replace('/<img .*?src=".*?cool.png" .*?class="bbcode_smiley" \/>/i', 'B)', $post);
    	$post = preg_replace('/<img .*?src=".*?sad.png" .*?class="bbcode_smiley" \/>/i', ':(', $post);
    	$post = preg_replace('/<img .*?src=".*?smile.png" .*?class="bbcode_smiley" \/>/i', ':)', $post);
    	$post = preg_replace('/<img .*?src=".*?cheerful.png" .*?class="bbcode_smiley" \/>/i', ':cheer:', $post);
    	$post = preg_replace('/<img .*?src=".*?wink.png" .*?class="bbcode_smiley" \/>/i', ';)', $post);
    	$post = preg_replace('/<img .*?src=".*?tongue.png" .*?class="bbcode_smiley" \/>/i', ':P', $post);
    	$post = preg_replace('/<img .*?src=".*?angry.png" .*?class="bbcode_smiley" \/>/i', ':angry:', $post);
    	$post = preg_replace('/<img .*?src=".*?unsure.png" .*?class="bbcode_smiley" \/>/i', ':unsure:', $post);
    	$post = preg_replace('/<img .*?src=".*?shocked.png" .*?class="bbcode_smiley" \/>/i', ':ohmy:', $post);
    	$post = preg_replace('/<img .*?src=".*?wassat.png" .*?class="bbcode_smiley" \/>/i', ':huh:', $post);
    	$post = preg_replace('/<img .*?src=".*?ermm.png" .*?class="bbcode_smiley" \/>/i', ':dry:', $post);
    	$post = preg_replace('/<img .*?src=".*?grin.png" .*?class="bbcode_smiley" \/>/i', ':lol:', $post);
    	$post = preg_replace('/<img .*?src=".*?sick.png" .*?class="bbcode_smiley" \/>/i', ':sick:', $post);
    	$post = preg_replace('/<img .*?src=".*?silly.png" .*?class="bbcode_smiley" \/>/i', ':silly:', $post);
    	$post = preg_replace('/<img .*?src=".*?blink.png" .*?class="bbcode_smiley" \/>/i', ':blink:', $post);
    	$post = preg_replace('/<img .*?src=".*?blush.png" .*?class="bbcode_smiley" \/>/i', ':blush:', $post);
    	$post = preg_replace('/<img .*?src=".*?blush.png" .*?class="bbcode_smiley" \/>/i', ':oops:', $post);
    	$post = preg_replace('/<img .*?src=".*?kissing.png" .*?class="bbcode_smiley" \/>/i', ':kiss:', $post);
    	$post = preg_replace('/<img .*?src=".*?w00t.png" .*?class="bbcode_smiley" \/>/i', ':woohoo:', $post);
    	$post = preg_replace('/<img .*?src=".*?sideways.png" .*?class="bbcode_smiley" \/>/i', ':side:', $post);
    	$post = preg_replace('/<img .*?src=".*?dizzy.png" .*?class="bbcode_smiley" \/>/i', ':S', $post);
    	$post = preg_replace('/<img .*?src=".*?devil.png" .*?class="bbcode_smiley" \/>/i', ':evil:', $post);
    	$post = preg_replace('/<img .*?src=".*?whistling.png" .*?class="bbcode_smiley" \/>/i', ':whistle:', $post);
    	$post = preg_replace('/<img .*?src=".*?pinch.png" .*?class="bbcode_smiley" \/>/i', ':pinch:', $post);
    	/* replace the expression end */
    	//$post = preg_replace('/<img .*?src="(.*?)"{1,2} .*?\/>/i', '[img]$1[/img]', $post);
    	$post = preg_replace('/<img .*?src="(.*?)" .*?\/>/i', '[img]$1[/img]', $post);
    	$post = str_ireplace('<strong>', '<b>', $post);
    	$post = str_ireplace('</strong>', '</b>', $post);
    	$post = preg_replace_callback('/<span style=\"color:(\#.*?)\">(.*?)<\/span>/is', create_function('$matches','return MbqMain::$oMbqCm->mbColorConvert($matches[1], $matches[2]);'), $post);
    	$post = preg_replace('/<object .*?>.*?<embed src="(.*?)".*?><\/embed><\/object>/i', '[url=$1]$1[/url]', $post); /* for youtube content etc. */
    	if ($returnHtml) {
    	    $post = strip_tags($post, '<br><i><b><u><font>');
        } else {
    	    $post = strip_tags($post);
        }
    	$post = trim($post);
    	return $post;
    }
    
    /**
     * return quote post content
     *
     * @param  Object  $oMbqEtForumPost
     * @return  String
     */
    public function getQuotePostContent($oMbqEtForumPost) {
        if (MbqMain::$oCurMbqEtUser) {
            $name = MbqMain::$oCurMbqEtUser->loginName->oriValue;
        } else {
            $name = '';
        }
        $content = "[quote=\"$name\" post=".$oMbqEtForumPost->postId->oriValue."]".$oMbqEtForumPost->postContent->oriValue."[/quote]";
        return $content;
    }
  
}

?>