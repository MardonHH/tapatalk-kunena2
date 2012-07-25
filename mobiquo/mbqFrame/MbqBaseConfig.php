<?php

defined('MBQ_IN_IT') or exit;

/**
 * plugin config base class
 * 
 * @since  2012-7-2
 * @author Wu ZeTao <578014287@qq.com>
 */
Abstract Class MbqBaseConfig {
    
    /* plugin config,many dimensions array.will be calculated with $this->cfg default value and MbqMain::$customConfig and MbqMain::$oMbqAppEnv and the plugin support degree. */
    protected $cfg;

    public function __construct() {
        $this->cfg = array();
    }
    
    /**
     * regist classes
     */
    abstract protected function regClass();
    
    /**
     * init cfg
     */
    abstract protected function initCfg();
    
    /**
     * calculate the final config of $this->cfg through $this->cfg default value and MbqMain::$customConfig and MbqMain::$oMbqAppEnv
     */
    abstract protected function calCfg();
    
    /**
     * return corresponding config value
     *
     * @param  String  $cfgPath
     * @return  fixed  if is set return the corresponding config value,else alert error info.
     */
    public function getCfg($cfgPath) {
        $arr = explode(".", $cfgPath);
        $count = count($arr);
        if (is_array($arr) && $count > 0) {
            switch ($count) {
                case 1:
                    if (isset($this->cfg[$arr[0]])) {
                        return $this->cfg[$arr[0]];
                    }
                break;
                case 2:
                    if (isset($this->cfg[$arr[0]][$arr[1]])) {
                        return $this->cfg[$arr[0]][$arr[1]];
                    }
                break;
                case 3:
                    if (isset($this->cfg[$arr[0]][$arr[1]][$arr[2]])) {
                        return $this->cfg[$arr[0]][$arr[1]][$arr[2]];
                    }
                break;
                case 4;
                    if (isset($this->cfg[$arr[0]][$arr[1]][$arr[2]][$arr[3]])) {
                        return $this->cfg[$arr[0]][$arr[1]][$arr[2]][$arr[3]];
                    }
                break;
                case 5;
                    if (isset($this->cfg[$arr[0]][$arr[1]][$arr[2]][$arr[3]][$arr[4]])) {
                        return $this->cfg[$arr[0]][$arr[1]][$arr[2]][$arr[3]][$arr[4]];
                    }
                break;
                case 6;
                    if (isset($this->cfg[$arr[0]][$arr[1]][$arr[2]][$arr[3]][$arr[4]][$arr[5]])) {
                        return $this->cfg[$arr[0]][$arr[1]][$arr[2]][$arr[3]][$arr[4]][$arr[5]];
                    }
                break;
                default:
                break;
            }
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . "Can not find config $cfgPath!");
        } else {
            MbqError::alert('', __METHOD__ . ',line:' . __LINE__ . '.' . "Can not find config $cfgPath!");
        }
    }
  
}

?>