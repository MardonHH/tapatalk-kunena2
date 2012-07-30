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