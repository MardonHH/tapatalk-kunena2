<?php

defined('MBQ_IN_IT') or exit;

/**
 * common method base class
 * 
 * @since  2012-7-2
 * @author Wu ZeTao <578014287@qq.com>
 */
Abstract Class MbqBaseCm {
  
    public function __construct() {
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
     * write error log into a file for debug
     */
    public function errorLog() {
        if (defined('MBQ_PATH') && ($error = error_get_last())) {
            $filePath = MBQ_PATH.'mbqError.log';
            if ($handle = fopen($filePath, 'wb')) {
                fwrite($handle, print_r($error, true));
                fclose($handle);
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
     * return sql in  string
     *
     * @param  Mixed  $arr
     * @return  Mixed
     */
    public function getSqlIn($arr) {
        $sqlIn = '';
        if (is_array($arr)) {
            if (count($arr) > 0) {
                $flag = true;
                foreach ($arr as $value) {
                    if ($flag) {
                        $sqlIn .= "'".addslashes($value)."'";
                        $flag = false;
                    } else {
                        $sqlIn .= ", '".addslashes($value)."'";
                    }
                }
                return $sqlIn;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    /**
     * Get all request headers
     * 
     * @return array
     */
    public static function getAllRequestHeaders() {
        static $_cached_headers = false;
        if($_cached_headers !== false) {
            return $_cached_headers;
        }
        $headers = array();
        if(function_exists('getallheaders')) {
            foreach( getallheaders() as $name => $value ) {
                $headers[strtolower($name)] = $value;
            }
        } else {
            foreach($_SERVER as $name => $value) {
                if(substr($name, 0, 5) == 'HTTP_') {
                    $headers[strtolower(str_replace(' ', '-', str_replace('_', ' ', substr($name, 5))))] = $value;
                }
            }
        }
        return $_cached_headers = $headers;
    }
    
    /**
     * Get a request header
     *
     * @param  string $name the requested header title
     * @return string|false
     */
    public static function getRequestHeader($name) {
        $headers = self::getAllRequestHeaders();
        if (isset($headers[strtolower($name)])) {
            return $headers[strtolower($name)];
        }
        return false;
    }
    
}

?>