<?php

defined('MBQ_IN_IT') or exit;

MbqMain::$oClk->includeClass('MbqBaseWrEtForumPost');

/**
 * forum post write class
 * 
 * @since  2012-8-21
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqWrEtForumPost extends MbqBaseWrEtForumPost {
    
    public function __construct() {
    }
    
    /**
     * add forum post
     *
     * @param  Mixed  $var($oMbqEtForumPost or $objsMbqEtForumPost)
     */
    public function addMbqEtForumPost(&$var) {
        if (is_array($var)) {
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_NOT_ACHIEVE);
        } else {
            /* modified from KunenaControllerTopic::post(),for kunena 2.0.1/2.0.2 */
            require_once KPATH_SITE . '/lib/kunena.link.class.php';
            //$this->id = JRequest::getInt('parentid', 0);
            $fields = array (
                //'catid' => $this->catid,
                'catid' => $var->forumId->oriValue,
                //'name' => JRequest::getString ( 'authorname', $this->me->getName () ),
                'name' => (MbqMain::$oCurMbqEtUser ? MbqMain::$oCurMbqEtUser->loginName->oriValue : ''),
                'email' => JRequest::getString ( 'email', null ),
                //'subject' => JRequest::getVar ( 'subject', null, 'POST', 'string', JREQUEST_ALLOWRAW ),
                'subject' => $var->postTitle->oriValue,
                //'message' => JRequest::getVar ( 'message', null, 'POST', 'string', JREQUEST_ALLOWRAW ),
                'message' => $var->postContent->oriValue,
                'icon_id' => JRequest::getInt ( 'topic_emoticon', null ),
                'anonymous' => JRequest::getInt ( 'anonymous', 0 ),
                'poll_title' => JRequest::getString ( 'poll_title', '' ),
                'poll_options' => JRequest::getVar('polloptionsID', array (), 'post', 'array'),
                'poll_time_to_live' => JRequest::getString ( 'poll_time_to_live', 0 ),
                'tags' => JRequest::getString ( 'tags', null ),
                'mytags' => JRequest::getString ( 'mytags', null ),
                'subscribe' => JRequest::getInt ( 'subscribeMe', 0 )
            );
            //$this->app->setUserState('com_kunena.postfields', $fields);
            MbqMain::$oMbqAppEnv->oApp->setUserState('com_kunena.postfields', $fields);
    
            /*
            if (! JRequest::checkToken ()) {
                $this->app->enqueueMessage ( JText::_ ( 'COM_KUNENA_ERROR_TOKEN' ), 'error' );
                $this->redirectBack ();
            }
            */
    
            /*
            $captcha = KunenaSpamRecaptcha::getInstance();
            if ($captcha->enabled()) {
                $success = $captcha->verify();
                if ( !$success ) {
                    $this->app->enqueueMessage ( $captcha->getError(), 'error' );
                    $this->redirectBack ();
                }
            }
            */
            
            $parent = KunenaForumMessageHelper::get($var->parentPostId->oriValue);
            if (!$parent->authorise('reply')) {
                //$this->app->enqueueMessage ( $parent->getError(), 'notice' );
                //$this->redirectBack ();
                MbqError::alert('', '', '', MBQ_ERR_APP);
            }
            list ($topic, $message) = $parent->newReply($fields);
            $category = $topic->getCategory();
    
            // Flood protection
            //if ($this->config->floodprotection && ! $this->me->isModerator($category)) {
            if (MbqMain::$oMbqAppEnv->oKunenaConfig->floodprotection && MbqMain::$oCurMbqEtUser && ! MbqMain::$oCurMbqEtUser->mbqBind['oKunenaUser']->isModerator($category)) {
                //$timelimit = JFactory::getDate()->toUnix() - $this->config->floodprotection;
                $timelimit = JFactory::getDate()->toUnix() - MbqMain::$oMbqAppEnv->oKunenaConfig->floodprotection;
                $ip = $_SERVER ["REMOTE_ADDR"];
    
                $db = JFactory::getDBO();
                $db->setQuery ( "SELECT COUNT(*) FROM #__kunena_messages WHERE ip={$db->Quote($ip)} AND time>{$db->quote($timelimit)}" );
                $count = $db->loadResult ();
                if (KunenaError::checkDatabaseError() || $count) {
                    //$this->app->enqueueMessage ( JText::sprintf ( 'COM_KUNENA_POST_TOPIC_FLOOD', $this->config->floodprotection) );
                    //$this->redirectBack ();
                    MbqError::alert('', "Please post later!", '', MBQ_ERR_APP);
                }
            }
    
            // Set topic icon if permitted
            //if ($this->config->topicicons && isset($fields['icon_id']) && $topic->authorise('edit', null, false)) {
            if (MbqMain::$oMbqAppEnv->oKunenaConfig->topicicons && isset($fields['icon_id']) && $topic->authorise('edit', null, false)) {
                $topic->icon_id = $fields['icon_id'];
            }
            
            // Remove IP address
            // TODO: Add administrator tool to remove all tracked IP addresses (from the database)
            //if (!$this->config->iptracking) {
            if (!MbqMain::$oMbqAppEnv->oKunenaConfig->iptracking) {
                $message->ip = '';
            }
    
            // If requested: Make message to be anonymous
            if ($fields['anonymous'] && $message->getCategory()->allow_anonymous) {
                $message->makeAnonymous();
            }
    
            // If configured: Hold posts from guests
            //if ( !$this->me->userid && $this->config->hold_guest_posts) {
            if (MbqMain::$oCurMbqEtUser && !MbqMain::$oCurMbqEtUser->mbqBind['oKunenaUser']->userid && MbqMain::$oMbqAppEnv->oKunenaConfig->hold_guest_posts) {
                $message->hold = 1;
            }
            // If configured: Hold posts from users
            //if ( !$this->me->isModerator($category) && $this->me->posts < $this->config->hold_newusers_posts ) {
            if (MbqMain::$oCurMbqEtUser && !MbqMain::$oCurMbqEtUser->mbqBind['oKunenaUser']->isModerator($category) && MbqMain::$oCurMbqEtUser->mbqBind['oKunenaUser']->posts < MbqMain::$oMbqAppEnv->oKunenaConfig->hold_newusers_posts ) {
                $message->hold = 1;
            }
    
            // Upload new attachments
            /*
            foreach ($_FILES as $key=>$file) {
                $intkey = 0;
                if (preg_match('/\D*(\d+)/', $key, $matches))
                    $intkey = (int)$matches[1];
                if ($file['error'] != UPLOAD_ERR_NO_FILE) $message->uploadAttachment($intkey, $key);
            }
            */
    
            // Activity integration
            $activity = KunenaFactory::getActivityIntegration();
            if ( $message->hold == 0 ) {
                /*
                if (!$topic->exists()) {
                    $activity->onBeforePost($message);
                } else {
                    $activity->onBeforeReply($message);
                }
                */
                $activity->onBeforeReply($message);
            }
    
            // Save message
            $success = $message->save ();
            if (! $success) {
                //$this->app->enqueueMessage ( $message->getError (), 'error' );
                //$this->redirectBack ();
                MbqError::alert('', "Can not save!".$message->getError (), '', MBQ_ERR_APP);
            }
    
            // Message has been sent, we can now clear saved form
            //$this->app->setUserState('com_kunena.postfields', null);
            MbqMain::$oMbqAppEnv->oApp->setUserState('com_kunena.postfields', null);
    
            // Display possible warnings (upload failed etc)
            foreach ( $message->getErrors () as $warning ) {
                //$this->app->enqueueMessage ( $warning, 'notice' );
                MbqError::alert('', $warning, '', MBQ_ERR_APP);
            }
    
            // Create Poll
            /*
            $poll_title = $fields['poll_title'];
            $poll_options = $fields['poll_options'];
            if (! empty ( $poll_options ) && ! empty ( $poll_title )) {
                if ($topic->authorise('poll.create', null, false)) {
                    $poll = $topic->getPoll();
                    $poll->title = $poll_title;
                    $poll->polltimetolive = $fields['poll_time_to_live'];
                    $poll->setOptions($poll_options);
                    if (!$poll->save()) {
                        $this->app->enqueueMessage ( $poll->getError(), 'notice' );
                    } else {
                        $topic->poll_id = $poll->id;
                        $topic->save();
                        $this->app->enqueueMessage ( JText::_ ( 'COM_KUNENA_POLL_CREATED' ) );
                    }
                } else {
                    $this->app->enqueueMessage ( $topic->getError(), 'notice' );
                }
            }
            */
    
            // Update Tags
            //$this->updateTags($message->thread, $fields['tags'], $fields['mytags']);
    
            $message->sendNotification();
    
            //now try adding any new subscriptions if asked for by the poster
            $usertopic = $topic->getUserTopic();
            if ($fields['subscribe'] && !$usertopic->subscribed) {
                if ($topic->subscribe(1)) {
                    //$this->app->enqueueMessage ( JText::_ ( 'COM_KUNENA_POST_SUBSCRIBED_TOPIC' ) );
    
                    // Activity integration
                    $activity = KunenaFactory::getActivityIntegration();
                    $activity->onAfterSubscribe($topic, 1);
                } else {
                    //$this->app->enqueueMessage ( JText::_ ( 'COM_KUNENA_POST_NO_SUBSCRIBED_TOPIC' ) .' '. $topic->getError() );
                }
            }
    
            if ($message->hold == 1) {
                //$this->app->enqueueMessage ( JText::_ ( 'COM_KUNENA_POST_SUCCES_REVIEW' ) );
            } else {
                //$this->app->enqueueMessage ( JText::_ ( 'COM_KUNENA_POST_SUCCESS_POSTED' ) );
            }
            /*
            $category = KunenaForumCategoryHelper::get($this->return);
            if ($message->authorise('read', null, false)) {
                $this->setRedirect ( $message->getUrl($category, false) );
            } elseif ($topic->authorise('read', null, false)) {
                $this->setRedirect ( $topic->getUrl($category, false) );
            } else {
                $this->setRedirect ( $category->getUrl(null, false) );
            }
            */
            
            $var->postId->setOriValue($message->id);
            if ($var->attachmentIdArray->hasSetOriValue() && is_array($var->attachmentIdArray->oriValue) && $var->attachmentIdArray->oriValue) {
                //associate attachment
                $oDb = MbqMain::$oMbqAppEnv->oDb;
                $attIds = array();
                foreach ($var->attachmentIdArray->oriValue as $attId) {
                    $attIds[] = (int) $attId;
                }
                $sqlIn = MbqMain::$oMbqCm->getSqlIn($attIds, false);
                $userId = (MbqMain::$oCurMbqEtUser) ? MbqMain::$oCurMbqEtUser->userId->oriValue : 0;
                $oDb->setQuery("UPDATE #__kunena_attachments SET mesid={$oDb->Quote($message->id)} WHERE userid={$oDb->Quote($userId)} AND id in (".$sqlIn.") AND mesid = 0");
                $oDb->query();
            }
            if ($message->hold == 1) {
                $var->state->setOriValue(MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumPost.state.range.postOkNeedModeration'));
            } else {
                $var->state->setOriValue(MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumPost.state.range.postOk'));
            }
        }
    }
    
    /**
     * modify forum post
     *
     * @param  Mixed  $var($oMbqEtForumPost or $objsMbqEtForumPost)
     * $mbqOpt['case'] = 'edit' means edit forum post.
     */
    public function mdfMbqEtForumPost(&$var, $mbqOpt) {
        if (is_array($var)) {
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_NOT_ACHIEVE);
        } else {
            if ($mbqOpt['case'] == 'edit') {
                /* modified from KunenaControllerTopic::edit(),for kunena 2.0.1/2.0.2 */
                require_once KPATH_SITE . '/lib/kunena.link.class.php';
        		//$this->id = JRequest::getInt('mesid', 0);
        
        		//$message = KunenaForumMessageHelper::get($this->id);
        		$message = KunenaForumMessageHelper::get($var->postId->oriValue);
        		$topic = $message->getTopic();
        		$fields = array (
        			//'name' => JRequest::getString ( 'authorname', $message->name ),
                    'name' => (MbqMain::$oCurMbqEtUser ? MbqMain::$oCurMbqEtUser->loginName->oriValue : $message->name),
        			'email' => JRequest::getString ( 'email', $message->email ),
        			//'subject' => JRequest::getVar ( 'subject', $message->subject, 'POST', 'string', JREQUEST_ALLOWRAW ),
                    'subject' => ($var->postTitle->oriValue ? $var->postTitle->oriValue : $message->subject),
        			//'message' => JRequest::getVar ( 'message', $message->message, 'POST', 'string', JREQUEST_ALLOWRAW ),
                    'message' => ($var->postContent->oriValue ? $var->postContent->oriValue : $message->message),
        			'modified_reason' => JRequest::getString ( 'modified_reason', $message->modified_reason ),
        			'icon_id' => JRequest::getInt ( 'topic_emoticon', $topic->icon_id ),
        			'anonymous' => JRequest::getInt ( 'anonymous', 0 ),
        			'poll_title' => JRequest::getString ( 'poll_title', null ),
        			'poll_options' => JRequest::getVar('polloptionsID', array (), 'post', 'array'),
        			'poll_time_to_live' => JRequest::getString ( 'poll_time_to_live', 0 ),
        			'tags' => JRequest::getString ( 'tags', null ),
        			'mytags' => JRequest::getString ( 'mytags', null )
        		);
        
                /*
        		if (! JRequest::checkToken ()) {
        			$this->app->setUserState('com_kunena.postfields', $fields);
        			$this->app->enqueueMessage ( JText::_ ( 'COM_KUNENA_ERROR_TOKEN' ), 'error' );
        			$this->redirectBack ();
        		}
        		*/
        
        		if (!$message->authorise('edit')) {
        			//$this->app->setUserState('com_kunena.postfields', $fields);
                    MbqMain::$oMbqAppEnv->oApp->setUserState('com_kunena.postfields', $fields);
        			//$this->app->enqueueMessage ( $message->getError(), 'notice' );
        			//$this->redirectBack ();
                    MbqError::alert('', '', '', MBQ_ERR_APP);
        		}
        
        		// Update message contents
        		$message->edit ( $fields );
        		// If requested: Make message to be anonymous
        		if ($fields['anonymous'] && $message->getCategory()->allow_anonymous) {
        			$message->makeAnonymous();
        		}
        
        		// Mark attachments to be deleted
        		/*
        		$attachments = JRequest::getVar ( 'attachments', array(), 'post', 'array' );
        		$attachkeeplist = JRequest::getVar ( 'attachment', array(), 'post', 'array' );
        		$message->removeAttachment(array_keys(array_diff_key($attachments, $attachkeeplist)));
        		*/
        
        		// Upload new attachments
        		/*
        		foreach ($_FILES as $key=>$file) {
        			$intkey = 0;
        			if (preg_match('/\D*(\d+)/', $key, $matches))
        				$intkey = (int)$matches[1];
        			if ($file['error'] != UPLOAD_ERR_NO_FILE) $message->uploadAttachment($intkey, $key);
        		}
        		*/
        
        		// Set topic icon if permitted
        		//if ($this->config->topicicons && isset($fields['icon_id']) && $topic->authorise('edit', null, false)) {
                if (MbqMain::$oMbqAppEnv->oKunenaConfig->topicicons && isset($fields['icon_id']) && $topic->authorise('edit', null, false)) {
        			$topic->icon_id = $fields['icon_id'];
        		}
        
        		// Check if we are editing first post and update topic if we are!
        		if ($topic->first_post_id == $message->id) {
        			$topic->subject = $fields['subject'];
        		}
        
        		// Activity integration
        		$activity = KunenaFactory::getActivityIntegration();
        		$activity->onBeforeEdit($message);
        
        		// Save message
        		$success = $message->save ();
        		if (! $success) {
        			//$this->app->setUserState('com_kunena.postfields', $fields);
        			MbqMain::$oMbqAppEnv->oApp->setUserState('com_kunena.postfields', $fields);
        			//$this->app->enqueueMessage ( $message->getError (), 'error' );
        			//$this->redirectBack ();
                    MbqError::alert('', "Can not save!".$message->getError (), '', MBQ_ERR_APP);
        		}
        		// Display possible warnings (upload failed etc)
        		foreach ( $message->getErrors () as $warning ) {
        			//$this->app->enqueueMessage ( $warning, 'notice' );
                    MbqError::alert('', $warning, '', MBQ_ERR_APP);
        		}
                
                /*
        		$poll_title = $fields['poll_title'];
        		if ($poll_title !== null) {
        			// Save changes into poll
        			$poll_options = $fields['poll_options'];
        			$poll = $topic->getPoll();
        			if (! empty ( $poll_options ) && ! empty ( $poll_title )) {
        				$poll->title = $poll_title;
        				$poll->polltimetolive = $fields['poll_time_to_live'];
        				$poll->setOptions($poll_options);
        				if (!$topic->poll_id) {
        					// Create a new poll
        					if (!$topic->authorise('poll.create')) {
        						$this->app->enqueueMessage ( $topic->getError(), 'notice' );
        					} elseif (!$poll->save()) {
        						$this->app->enqueueMessage ( $poll->getError(), 'notice' );
        					} else {
        						$topic->poll_id = $poll->id;
        						$topic->save();
        						$this->app->enqueueMessage ( JText::_ ( 'COM_KUNENA_POLL_CREATED' ) );
        					}
        				} else {
        					// Edit existing poll
        					if (!$topic->authorise('poll.edit')) {
        						$this->app->enqueueMessage ( $topic->getError(), 'notice' );
        					} elseif (!$poll->save()) {
        						$this->app->enqueueMessage ( $poll->getError(), 'notice' );
        					} else {
        						$this->app->enqueueMessage ( JText::_ ( 'COM_KUNENA_POLL_EDITED' ) );
        					}
        				}
        			} elseif ($poll->exists() && $topic->authorise('poll.edit')) {
        				// Delete poll
        				if (!$topic->authorise('poll.delete')) {
        					// Error: No permissions to delete poll
        					$this->app->enqueueMessage ( $topic->getError(), 'notice' );
        				} elseif (!$poll->delete()) {
        					$this->app->enqueueMessage ( $poll->getError(), 'notice' );
        				} else {
        					$this->app->enqueueMessage ( JText::_ ( 'COM_KUNENA_POLL_DELETED' ) );
        				}
        			}
        		}
        		*/
        
        		// Update Tags
        		//$this->updateTags($message->thread, $fields['tags'], $fields['mytags']);
        
        		//$this->app->enqueueMessage ( JText::_ ( 'COM_KUNENA_POST_SUCCESS_EDIT' ) );
        		if ($message->hold == 1) {
        			//$this->app->enqueueMessage ( JText::_ ( 'COM_KUNENA_GEN_MODERATED' ) );
        		}
        		//$this->app->redirect ( $message->getUrl($this->return, false ) );
                
                if ($message->hold == 1) {
                    $var->state->setOriValue(MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumPost.state.range.postOkNeedModeration'));
                } else {
                    $var->state->setOriValue(MbqBaseFdt::getFdt('MbqFdtForum.MbqEtForumPost.state.range.postOk'));
                }
            } else {
                MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . MBQ_ERR_INFO_UNKNOWN_CASE);
            }
        }
    }
  
}

?>