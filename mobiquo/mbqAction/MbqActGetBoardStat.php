<?php

defined('MBQ_IN_IT') or exit;

/**
 * get_board_stat action
 * this method will be abolished
 * 
 * @since  2012-8-16
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqActGetBoardStat extends MbqBaseAct {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * action implement
     */
    public function actionImplement() {
        /* TODO */
        $this->data['total_threads'] = 0;
        $this->data['total_posts'] = 0;
        $this->data['total_members'] = 0;
        $this->data['active_members'] = 0;
        $this->data['total_online'] = 0;
        $this->data['guest_online'] = 0;
    }
  
}

?>