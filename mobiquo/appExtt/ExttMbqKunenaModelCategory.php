<?php

require_once(KPATH_SITE.'/models/category.php');

/**
 * for kunena 2.0.1/2.0.2/2.0.3/2.0.4
 * ExttMbqKunenaModelCategory modified from KunenaModelCategory
 * add method exttMbqGetTopics() modified from method getTopics()
 * 
 * @since  2012-8-8
 * @modified by Wu ZeTao <578014287@qq.com>
 */
class ExttMbqKunenaModelCategory extends KunenaAdminModelCategories {
	protected $topics = false;
	protected $pending = array();
	protected $items = false;
	protected $topicActions = false;
	protected $actionMove = false;

	protected function populateState() {
		$layout = $this->getCmd ( 'layout', 'default' );
		$this->setState ( 'layout', $layout );

		// Administrator state
		if ($layout == 'manage' || $layout == 'create' || $layout == 'edit') {
			return parent::populateState();
		}

		$active = $this->app->getMenu ()->getActive ();
		$active = $active ? (int) $active->id : 0;
		$catid = $this->getInt ( 'catid', 0 );
		$this->setState ( 'item.id', $catid );

		$format = $this->getWord ( 'format', 'html' );
		$this->setState ( 'format', $format );

		// List state information
		$value = $this->getUserStateFromRequest ( "com_kunena.category{$catid}_{$format}_list_limit", 'limit', 0, 'int' );
		$defaultlimit = $format!='feed' ? $this->config->threads_per_page : $this->config->rss_limit;
		if ($value < 1 || $value > 100) $value = $defaultlimit;
		$this->setState ( 'list.limit', $value );

		$value = $this->getUserStateFromRequest ( "com_kunena.category{$catid}_{$format}_{$active}_list_ordering", 'filter_order', 'time', 'cmd' );
		//$this->setState ( 'list.ordering', $value );

		$value = $this->getUserStateFromRequest ( "com_kunena.category{$catid}_{$format}_list_start", 'limitstart', 0, 'int' );
		$this->setState ( 'list.start', $value );

		$value = $this->getUserStateFromRequest ( "com_kunena.category{$catid}_{$format}_{$active}_list_direction", 'filter_order_Dir', 'desc', 'word' );
		if ($value != 'asc')
			$value = 'desc';
		$this->setState ( 'list.direction', $value );
	}

	public function getLastestCategories() {
		if ( $this->items === false ) {
			$this->items = array();
			$user = KunenaFactory::getUser();
			list($total,$categories) = KunenaForumCategoryHelper::getLatestSubscriptions($user->userid);
			$this->items = $categories;
		}
		return $this->items;
	}

	public function getCategories() {
		if ( $this->items === false ) {
			$this->items = array();
			$catid = $this->getState ( 'item.id' );
			$layout = $this->getState ( 'layout' );
			$flat = false;

			if ($layout == 'user') {
				$categories[0] = KunenaForumCategoryHelper::getSubscriptions();
				$flat = true;
			} elseif ($catid) {
				$categories[0] = KunenaForumCategoryHelper::getCategories($catid);
				if (empty($categories[0]))
					return array();
			} else {
				$categories[0] = KunenaForumCategoryHelper::getChildren();
			}


		if ($flat) {
			$allsubcats = $categories[0];
		} else {
			$allsubcats = KunenaForumCategoryHelper::getChildren(array_keys($categories [0]), 1);
		}
		if (empty ( $allsubcats ))
			return array();

		KunenaForumCategoryHelper::getNewTopics(array_keys($allsubcats));

		$modcats = array ();
		$lastpostlist = array ();
		$userlist = array();
		$topiclist = array();

		foreach ( $allsubcats as $subcat ) {
			if ($flat || isset ( $categories [0] [$subcat->parent_id] )) {

				$last = $subcat->getLastCategory ();
				if ($last->last_topic_id) {
					// Get list of topics
					$topiclist[$last->last_topic_id] = $last->last_topic_id;
				}

				if ($this->config->listcat_show_moderators) {
					// Get list of moderators
					$subcat->moderators = $subcat->getModerators ( false, false );
					$userlist += $subcat->moderators;
				}

				if ($this->me->isModerator ( $subcat ))
					$modcats [] = $subcat->id;
			}
			$categories [$subcat->parent_id] [] = $subcat;
		}
		// Prefetch topics
		$topics = KunenaForumTopicHelper::getTopics($topiclist);
		foreach ( $topics as $topic ) {
			// Prefetch users
			$userlist [$topic->last_post_userid] = $topic->last_post_userid;
			$lastpostlist [$topic->id] = $topic->last_post_id;
		}

		if ($this->me->ordering != 0) {
			$topic_ordering = $this->me->ordering == 1 ? true : false;
		} else {
			$topic_ordering = $this->config->default_sort == 'asc' ? false : true;
		}

		$this->pending = array ();
		if ($this->me->userid && count ( $modcats )) {
			$catlist = implode ( ',', $modcats );
			$db = JFactory::getDBO ();
			$db->setQuery ( "SELECT catid, COUNT(*) AS count
				FROM #__kunena_messages
				WHERE catid IN ({$catlist}) AND hold=1
				GROUP BY catid" );
			$pending = $db->loadAssocList ();
			KunenaError::checkDatabaseError();
			foreach ( $pending as $item ) {
				if ($item ['count'])
					$this->pending [$item ['catid']] = $item ['count'];
			}
		}
		// Fix last post position when user can see unapproved or deleted posts
		if ($lastpostlist && !$topic_ordering && ($this->me->isAdmin() || KunenaAccess::getInstance()->getModeratorStatus())) {
			KunenaForumMessageHelper::loadLocation($lastpostlist);
		}

		// Prefetch all users/avatars to avoid user by user queries during template iterations
		KunenaUserHelper::loadUsers($userlist);

		if ($flat) {
			$this->items = $allsubcats;
		} else {
			$this->items = $categories;
		}
		}

		return $this->items;
	}

	public function getUnapprovedCount() {
		return $this->pending;
	}

	public function getCategory() {
		return KunenaForumCategoryHelper::get($this->getState ( 'item.id'));
	}

	public function getTopics() {
		if ($this->topics === false) {
			$catid = $this->getState ( 'item.id');
			$limitstart = $this->getState ( 'list.start');
			$limit = $this->getState ( 'list.limit');
			$format = $this->getState ( 'format');

			$topic_ordering = $this->getCategory()->topic_ordering;

			$access = KunenaAccess::getInstance();
			$hold = $format == 'feed' ? 0 : $access->getAllowedHold($this->me, $catid);
			$moved = $format == 'feed' ? 0 : 1;
			$params = array(
				'hold'=>$hold,
				'moved'=>$moved);
			switch ($topic_ordering) {
				case 'alpha':
					$params['orderby'] = 'tt.ordering DESC, tt.subject ASC ';
					break;
				case 'creation':
					$params['orderby'] = 'tt.ordering DESC, tt.first_post_time ' . strtoupper($this->getState ( 'list.direction'));
					break;
				case 'lastpost':
				default:
					$params['orderby'] = 'tt.ordering DESC, tt.last_post_time ' . strtoupper($this->getState ( 'list.direction'));
			}

			if ($format == 'feed') {
				$catid = array_keys(KunenaForumCategoryHelper::getChildren($catid, 100)+array($catid=>1));
			}
			list($this->total, $this->topics) = KunenaForumTopicHelper::getLatestTopics($catid, $limitstart, $limit, $params);
			if ($this->total > 0) {
				// collect user ids for avatar prefetch when integrated
				$userlist = array();
				foreach ( $this->topics as $topic ) {
					$userlist[intval($topic->first_post_userid)] = intval($topic->first_post_userid);
					$userlist[intval($topic->last_post_userid)] = intval($topic->last_post_userid);
					$lastpostlist[intval($topic->last_post_id)] = intval($topic->last_post_id);
				}

				// Prefetch all users/avatars to avoid user by user queries during template iterations
				if ( !empty($userlist) ) KunenaUserHelper::loadUsers($userlist);

				KunenaForumTopicHelper::getUserTopics(array_keys($this->topics));
				KunenaForumTopicHelper::getKeywords(array_keys($this->topics));
				$lastreadlist = KunenaForumTopicHelper::fetchNewStatus($this->topics);

				// Fetch last / new post positions when user can see unapproved or deleted posts
				if (($lastpostlist || $lastreadlist) && ($this->me->isAdmin() || KunenaAccess::getInstance()->getModeratorStatus())) {
					KunenaForumMessageHelper::loadLocation($lastpostlist + $lastreadlist);
				}

			}
		}
		return $this->topics;
	}
	
	/**
	 * get topics
	 *
	 * @param  $params
	 * $params['catId'] means category id,in the original getTopics() method it always be changed to 0,so add this parameter to hack it.
	 * $params['start'] means the data index num need to be get start,in the original getTopics() method it always be changed to 0,so add this parameter to hack it.
	 * $params['limit'] means the data num per page,in the original getTopics() method it always be changed to config setting,so add this parameter to hack it.
	 */
	public function exttMbqGetTopics($params = array()) {
	    $exttMbqOldParams = $params;
		if ($this->topics === false) {
			//$catid = $this->getState ( 'item.id');
			$catid = $params['catId'];
			//$limitstart = $this->getState ( 'list.start');
			$limitstart = $params['start'];
			//$limit = $this->getState ( 'list.limit');
			$limit = $params['limit'];
			$format = $this->getState ( 'format');

			$topic_ordering = $this->getCategory()->topic_ordering;

			$access = KunenaAccess::getInstance();
			$hold = $format == 'feed' ? 0 : $access->getAllowedHold($this->me, $catid);
			$moved = $format == 'feed' ? 0 : 1;
			$params = array(
				'hold'=>$hold,
				'moved'=>$moved);
			switch ($topic_ordering) {
				case 'alpha':
					$params['orderby'] = 'tt.ordering DESC, tt.subject ASC ';
					break;
				case 'creation':
					$params['orderby'] = 'tt.ordering DESC, tt.first_post_time ' . strtoupper($this->getState ( 'list.direction'));
					break;
				case 'lastpost':
				default:
					$params['orderby'] = 'tt.ordering DESC, tt.last_post_time ' . strtoupper($this->getState ( 'list.direction'));
			}

			if ($format == 'feed') {
				$catid = array_keys(KunenaForumCategoryHelper::getChildren($catid, 100)+array($catid=>1));
			}
			if ($exttMbqOldParams['where']) $params['where'] = $exttMbqOldParams['where'];
			list($this->total, $this->topics) = KunenaForumTopicHelper::getLatestTopics($catid, $limitstart, $limit, $params);
			/*
			if ($this->total > 0) {
				// collect user ids for avatar prefetch when integrated
				$userlist = array();
				foreach ( $this->topics as $topic ) {
					$userlist[intval($topic->first_post_userid)] = intval($topic->first_post_userid);
					$userlist[intval($topic->last_post_userid)] = intval($topic->last_post_userid);
					$lastpostlist[intval($topic->last_post_id)] = intval($topic->last_post_id);
				}

				// Prefetch all users/avatars to avoid user by user queries during template iterations
				if ( !empty($userlist) ) KunenaUserHelper::loadUsers($userlist);

				KunenaForumTopicHelper::getUserTopics(array_keys($this->topics));
				KunenaForumTopicHelper::getKeywords(array_keys($this->topics));
				$lastreadlist = KunenaForumTopicHelper::fetchNewStatus($this->topics);

				// Fetch last / new post positions when user can see unapproved or deleted posts
				if (($lastpostlist || $lastreadlist) && ($this->me->isAdmin() || KunenaAccess::getInstance()->getModeratorStatus())) {
					KunenaForumMessageHelper::loadLocation($lastpostlist + $lastreadlist);
				}

			}
			*/
		}
		return array('topics' => $this->topics, 'total' => $this->total);
		//return $this->topics;
	}

	public function getTotal() {
		if ($this->total === false) {
			$this->getTopics();
		}
		return $this->total;
	}

	public function getTopicActions() {
		if ($this->topics === false) {
			$this->getTopics();
		}
		$delete = $approve = $undelete = $move = $permdelete = false;
		foreach ($this->topics as $topic) {
			if (!$delete && $topic->authorise('delete')) $delete = true;
			if (!$approve && $topic->authorise('approve')) $approve = true;
			if (!$undelete && $topic->authorise('undelete')) $undelete = true;
			if (!$move && $topic->authorise('move')) {
				$move = $this->actionMove = true;
			}
			if (!$permdelete && $topic->authorise('permdelete')) $permdelete = true;
		}
		$actionDropdown[] = JHTML::_('select.option', 'none', JText::_('COM_KUNENA_BULK_CHOOSE_ACTION'));
		if ($move) $actionDropdown[] = JHTML::_('select.option', 'move', JText::_('COM_KUNENA_MOVE_SELECTED'));
		if ($approve) $actionDropdown[] = JHTML::_('select.option', 'approve', JText::_('COM_KUNENA_APPROVE_SELECTED'));
		if ($delete) $actionDropdown[] = JHTML::_('select.option', 'delete', JText::_('COM_KUNENA_DELETE_SELECTED'));
		if ($permdelete) $actionDropdown[] = JHTML::_('select.option', 'permdel', JText::_('COM_KUNENA_BUTTON_PERMDELETE_LONG'));
		if ($undelete) $actionDropdown[] = JHTML::_('select.option', 'restore', JText::_('COM_KUNENA_BUTTON_UNDELETE_LONG'));

		if (count($actionDropdown) == 1) return null;
		return $actionDropdown;
	}

	public function getActionMove() {
		return $this->actionMove;
	}

	public function getModerators() {
		$moderators = $this->getCategory()->getModerators(false);
		return $moderators;
	}

	public function getCategoryActions() {
		$actionDropdown[] = JHTML::_('select.option', 'none', JText::_('COM_KUNENA_BULK_CHOOSE_ACTION'));
		$actionDropdown[] = JHTML::_('select.option', 'unsubscribe', JText::_('COM_KUNENA_UNSUBSCRIBE_SELECTED'));

		if (count($actionDropdown) == 1) return null;
		return $actionDropdown;
	}
}

?>