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
			
        //if (JRequest::getCmd('option') == 'com_kunena' && (JRequest::getCmd('view') == 'topics' || JRequest::getCmd('view') == 'category')) {
        $pathCustomDetectJs = 'mobiquo/custom/customDetectJs.php';
        if (JRequest::getCmd('option') == 'com_kunena' && is_file($pathCustomDetectJs)) {
            require_once($pathCustomDetectJs);
    		$base	= JURI::base(false).'';
    		$buffer = JResponse::getBody();
    
            $str = "<script type='text/javascript'>";
            $str .= 'var tapatalk_iphone_msg = "'.MbqCustomDetectJs::$MBQ_DETECTJS_IPHONEIPOD_CONFIRM_TITLE.'";';
            $str .= 'var tapatalk_iphone_url = "'.MbqCustomDetectJs::$MBQ_DETECTJS_IPHONEIPOD_DOWNLOAD_URL.'";';
            $str .= 'var tapatalk_ipad_msg = "'.MbqCustomDetectJs::$MBQ_DETECTJS_IPAD_CONFIRM_TITLE.'";';
            $str .= 'var tapatalk_ipad_url = "'.MbqCustomDetectJs::$MBQ_DETECTJS_IPAD_DOWNLOAD_URL.'";';
            $str .= 'var tapatalk_kindle_msg = "'.MbqCustomDetectJs::$MBQ_DETECTJS_KINDLEFIRE_CONFIRM_TITLE.'";';
            $str .= 'var tapatalk_kindle_url = "'.MbqCustomDetectJs::$MBQ_DETECTJS_KINDLEFIRE_DOWNLOAD_URL.'";';
            $str .= 'var tapatalk_android_msg = "'.MbqCustomDetectJs::$MBQ_DETECTJS_ANDROID_CONFIRM_TITLE.'";';
            $str .= 'var tapatalk_android_url = "'.MbqCustomDetectJs::$MBQ_DETECTJS_ANDROID_DOWNLOAD_URL.'";';
            $str .= 'var tapatalk_chrome_enable = '.(MbqCustomDetectJs::$MBQ_DETECTJS_CHROME_ENABLE ? 'true' : 'false').';';
            $str .= 'var tapatalkdir = "'.MbqCustomDetectJs::$MBQ_DETECTJS_TAPATALKDIR.'";';
            $str .= "</script><script type='text/javascript' src='{$base}mobiquo/tapatalkdetect.js'></script>";
            $str .= '</head>';
    		$buffer = str_ireplace("</head>", $str, $buffer);
    
    		JResponse::setBody($buffer);
    		return true;
    	} else {
    	    return false;
    	}
	}
}

?>