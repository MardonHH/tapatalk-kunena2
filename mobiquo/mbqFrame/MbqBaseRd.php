<?php

defined('MBQ_IN_IT') or exit;

/**
 * read base class
 * 
 * @since  2012-8-8
 * @author Wu ZeTao <578014287@qq.com>
 */
Abstract Class MbqBaseRd {
    
    public $neededMethods;   /* describe the methods that should be implemented in all extention class. */
    
    public function __construct() {
        $this->neededMethods = array();
        $this->neededMethods[] = 'makeProperty';    /* make obj property */
        $this->neededMethods[] = 'getObjsEntityClassName';    /* get entity objs by condition.for example:getObjsMbqEtForum */
        $this->neededMethods[] = 'initOEntityClassName';    /* init one entity obj by condition.for example:initOMbqEtForum */
        $this->neededMethods[] = 'returnApiDataObjLogicName';    /* return obj api data by entity obj.for example:returnApiDataUser,returnApiDataForum */
        $this->neededMethods[] = 'returnApiArrDataObjLogicName';    /* return obj array api data by entity obj array.for example:returnApiArrDataForumTopic */
        $this->neededMethods[] = 'returnApiTreeDataObjLogicName';    /* return obj tree api data by entity obj tree.for example:returnApiTreeDataForum */
    }
    
    /**
     * make obj property
     *
     * @param  Object  $o  the obj need make property
     * @param  String  $pName  property name
     */
    abstract protected function makeProperty($o, $pName);
  
}

?>