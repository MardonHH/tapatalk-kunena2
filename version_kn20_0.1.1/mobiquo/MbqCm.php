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
     * merge api data
     *
     * @param  Array  $apiData
     * @param  Array  $addApiData
     */
    public function mergeApiData(&$apiData, $addApiData) {
        foreach ($addApiData as $k => $v) {
            $apiData[$k] = $v;
        }
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
    
    /**
     * replace some code in content
     *
     * @param  String  $content
     * @param  String  $strNeedReplaced
     * @param  String  $type  replacement type.'bbcodeName' means replace bbcode name for our rules.
     */
    public function replaceCode($content, $strNeedReplaced = 'quote', $type = 'bbcodeName') {
        switch ($type) {
            case 'bbcodeName':
                switch ($strNeedReplaced) {
                    case 'quote':
                    $newName = MBQ_RUNNING_NAMEPRE.'quote';
                    $content = preg_replace('/\[quote(=.*?)\]/i', "[$newName$1]", $content);
                    $content = preg_replace('/\[\/quote\]/i', "[/$newName]", $content);
                    break;
                    default:
                    break;
                }
            break;
            default:
            break;
        }
        return $content;
    }
    
    /**
     * upreplace some code in content
     *
     * @param  String  $content
     * @param  String  $strNeedReplaced
     * @param  String  $type  replacement type.'bbcodeName' means replace bbcode name for our rules.
     */
    public function unreplaceCode($content, $strNeedReplaced = 'quote', $type = 'bbcodeName') {
        switch ($type) {
            case 'bbcodeName':
                switch ($strNeedReplaced) {
                    case 'quote':
                    $curName = MBQ_RUNNING_NAMEPRE.'quote';
                    $content = preg_replace('/\['.$curName.'(=.*?)\]/i', "[quote$1]", $content);
                    $content = preg_replace('/\[\/'.$curName.'\]/i', "[/quote]", $content);
                    break;
                    default:
                    break;
                }
            break;
            default:
            break;
        }
        return $content;
    }
    
}
    
/**
 * shutdown handle
 */
function mbqShutdownHandle() {
    $error = error_get_last();
    if(!empty($error)){
        $errorInfo = "Server error occurred: '{$error['message']} (".basename($error['file']).":{$error['line']})'";
        //MbqError::alert('', $errorInfo);
        //MbqMain::$oMbqCm->writeLog($errorInfo, true);
        switch($error['type']){
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
            case E_PARSE:
                @ ob_end_clean();
                MbqError::alert('', $errorInfo);
                break;
        }
    }
}

?>