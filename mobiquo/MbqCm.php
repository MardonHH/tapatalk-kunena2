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
    
}

?>