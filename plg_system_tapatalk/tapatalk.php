<?php

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Joomla! Tapatalk Plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	System.Tapatalk
 */
class plgSystemTapatalk extends JPlugin
{
	public function onAfterRender()
	{
		$app = JFactory::getApplication();

		//if($app->getName() != 'kunena')
		//	return false;
		
		if (!class_exists('KunenaForum'))
			return false;
			
        if (JRequest::getCmd('option') != 'com_kunena') {
            return false;
        }

		$base	= JURI::base(false).'';
		$buffer = JResponse::getBody();

		$buffer = str_ireplace("</head>", "<script type='text/javascript' src='{$base}mobiquo/tapatalkdetect.js'></script></head>", $buffer);

		JResponse::setBody($buffer);
		return true;
	}
}
