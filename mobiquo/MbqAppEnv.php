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
    public $db;
    public $my;
    public $profile;
    public $config;
    public $session;
    public $prevCheck;
    public $timeOffset;
    
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
        
        define('JPATH_COMPONENT', JPATH_BASE.DS.'components'.DS.'com_kunena');
        define('KPATH_SITE', JPATH_ROOT.DS.'components'.DS.'com_kunena');
        define('KPATH_ADMIN', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_kunena');
        define('KPATH_MEDIA', JPATH_ROOT.DS.'media'.DS.'kunena');
        $this->db = JFactory::getDBO ();
        $this->my = JFactory::getUser ();
        $this->profile = KunenaFactory::getUser ();
        $this->config = KunenaFactory::getConfig ();
        $this->session = KunenaFactory::getSession ();
        $this->prevCheck = $this->session->lasttime;
        
        $lang = JFactory::getLanguage();
        $lang->load("com_kunena", JPATH_SITE);
        jimport('joomla.utilities.date');
        $offset = 0;
        if(!empty($this->app))
            $offset = $this->app->getCfg('offset', 0);
        $this->timeOffset = $this->my->getParam('timezone', $offset);
        
        if (empty($this->session->allowed)){            
            $query = "  SELECT id FROM #__kunena_categories
                        WHERE published='1' AND pub_access='0'
            ";
            $this->db->setQuery ( $query );
            $cats = $this->db->loadObjectList ();       
            $allowed = array();
            foreach($cats as $cat){
                $allowed[]=$cat->id;
            }
            //$this->session->allowed = implode(",", $allowed);
            if ($allowed) {
                $this->session->allowed = implode(",", $allowed);
            } else {
                $this->session->allowed = 'na'; /* can access none */
            }
        }
        if($this->session->allowed == 'na'){
            $this->session->allowed = '-1';
        }
        //print_r($this->session);
    }
    
}

?>