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
     * change script work dir
     *
     * @param  String  $relativePath  .. or folder name separated by / or \. for example:../../folder1/folder2
     * @param  String  $basePath  the base script work dir,default is the mobiquo folder absolute path
     */
    public function changeWorkDir($relativePath, $basePath = MBQ_PATH) {
        chdir($basePath.$relativePath);
    }
    
    /**
     * write log into a file for debug
     */
    public function writeLog($logContent, $add = false) {
        if (defined('MBQ_PATH')) {
            $filePath = MBQ_PATH.'mbqDebug.log';
            if ($add) {
                if ($handle = fopen($filePath, 'wb')) {
                    fwrite($handle, $logContent);
                    fclose($handle);
                }
            } else {
                file_put_contents($filePath, $logContent);
            }
        }
    }
    
    /**
     * change array leaf value to string
     * now only support 3 dimensional array
     *
     * @param  Array  $arr
     * @return  Array
     */
    public function changeArrValueToString($arr) {
        foreach ($arr as &$v) {
            if (is_array($v)) {
                foreach ($v as &$v1) {
                    if (is_array($v1)) {
                        foreach ($v1 as &$v2) {
                            if (!is_array($v2)) {
                                $v2 = (string) $v2;
                            }
                        }
                    } else {
                        $v1 = (string) $v1;
                    }
                } 
            } else {
                $v = (string) $v;
            }
        }
        return $arr;
    }
    
    /**
     * remove array key
     *
     * @param  Array  $arr
     * @return  Array
     */
    public function removeArrayKey($arr) {
        $retArr = array();
        foreach ($arr as $v) {
            $retArr[] = $v;
        }
        return $retArr;
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
    
}

?>