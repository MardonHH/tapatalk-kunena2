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
    
}

?>