<?php

defined('MBQ_IN_IT') or exit;

/**
 * error handle
 * 
 * @since  2012-7-2
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqError {

    public function __construct() {
    }
   
    /**
     * echo error info
     *
     * @param  String  $errTitle  error title
     * @param  Mixed  $errInfo  error info
     * @param  Array  $data  other data need return
     * @param  String  $errDegree  error degree(MBQ_ERR_TOP|MBQ_ERR_HIGH|MBQ_ERR_APP|MBQ_ERR_INFO)
     * @param  Boolean  $stop  need stop the program immediately flag,it often is true value in plugin development.
     */
    public static function alert($errTitle = '', $errInfo = 'error!', $data = '', $errDegree = MBQ_ERR_TOP, $stop = true) {
        switch ($errDegree) {
            case MBQ_ERR_TOP:
                die($errTitle.':'.$errInfo);
                break;
            case MBQ_ERR_HIGH:
                die($errTitle.':'.$errInfo);
                break;
            case MBQ_ERR_APP:
                die($errTitle.':'.$errInfo);
                break;
            case MBQ_ERR_INFO:
                die($errTitle.':'.$errInfo);
                break;
            default:
                die($errTitle.':'.$errInfo);
                break;
        }
    }
  
}

?>