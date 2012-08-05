<?php

defined('MBQ_IN_IT') or exit;

/**
 * application environment class
 * 
 * @since  2012-7-2
 * @author Wu ZeTao <578014287@qq.com>
 */
Class MbqAppEnv extends MbqBaseAppEnv {
    
    /* this class fully rely the application,so you can define the properties you need come from the application. */
    public $oApp;    /* joomla application obj */
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * application environment init
     */
    public function init() {
        define('_JEXEC', 1);
        define('DS', DIRECTORY_SEPARATOR);
        define('JPATH_BASE', realpath(MBQ_PARENT_PATH));    /* attention!!! */
        require_once JPATH_BASE.'/includes/defines.php';
        require_once JPATH_BASE.'/includes/framework.php';
        $this->oApp = JFactory::getApplication('site');
        $this->oApp->initialise();
        
        // Initialize session
        $ksession = KunenaFactory::getSession ( true );
        if ($ksession->userid > 0) {
            // Create user if it does not exist
            $kuser = KunenaUserHelper::getMyself ();
            if (! $kuser->exists ()) {
                $kuser->save ();
            }
            // Save session
            if (! $ksession->save ()) {
                JFactory::getApplication ()->enqueueMessage ( JText::_ ( 'COM_KUNENA_ERROR_SESSION_SAVE_FAILED' ), 'error' );
            }
        }
    }
    
}

?>