<?php

defined('MBQ_IN_IT') or exit;

/**
 * common method class
 * 
 * @since  2012-7-2
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqCm extends MbqBaseCm {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * transform timestamp to iso8601 format
     *
     * @param  Integer  $timeStamp
     * @param  Mixed  $timeOffset
     * TODO:need to be made more general.
     */
    public function datetimeIso8601Encode($timeStamp, $timeOffset = NULL) {
        $timeOffset = $timeOffset ? $timeOffset : MbqMain::$oMbqAppEnv->timeOffset;
        $date = JFactory::getDate($timeStamp);
        if (is_numeric($timeOffset)) {
            $date->setOffset($timeOffset);
        } else {
            // Joomla 1.6 support
            $offset = new DateTimeZone($timeOffset);
            $date->setTimezone($offset);
        }
        $timezone = method_exists($date, 'getOffsetFromGMT') ? $date->getOffsetFromGMT(true) : 0;
        $t = $date->toFormat("%Y%m%dT%H:%M:%S", true);
        $t .= sprintf("%+03d:%02d", intval($timezone), abs($timezone - intval($timezone)) * 60);
        return $t;
    }
    
    /**
     * get short content
     *
     * @param  String  $str
     * @param  Integer  $length
     * @return  String
     * TODO:need to be made more useful.
     */
    public function getShortContent($str, $length = 200) {
        $str = preg_replace('/\[url.*?\].*?\[\/url.*?\]/', '[url]', $str);
        $str = preg_replace('/\[img.*?\].*?\[\/img.*?\]/', '[img]', $str);
        $str = preg_replace('/[\n\r\t]+/', ' ', $str);
        
        $str = preg_replace('/\[\/?.*?]/s', '', $str);
    
        $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
        $str = function_exists('mb_substr') ? mb_substr($str, 0, $length) : substr($str, 0, $length);
        return $str;
    }
    
    /**
     * get attachment ids from content
     *
     * @params  String  $content
     * @return  Array
     */
    public function getAttIdsFromContent($content) {
        preg_match_all('/\[attachment=(.*?)\](.*?)\[\/attachment\]/i', $content, $mat);
        if ($mat[1]) {
            return $mat[1];
        } else {
            return array();
        }
    }
    
}

?>