<?php

defined('MBQ_IN_IT') or exit;

include_once(MBQ_3RD_LIB_PATH . 'xmlrpc/xmlrpc.inc');
include_once(MBQ_3RD_LIB_PATH . 'xmlrpc/xmlrpcs.inc');

/**
 * io handle for xmlrpc class
 * 
 * @since  2012-7-30
 * @author Jayeley Yang <jayeley@gmail.com>
 */
Class MbqIoHandleXmlrpc {
    
    protected $cmd;   /* action command name,must unique in all action. */
    protected $input;   /* input params array */
    
    public function __construct() {
        $this->init();
    }
    
    /**
     * Get request protocol based on Content-Type
     *
     * @return string default as xmlrpc
     */
    protected function init() {
        
        $ver = phpversion();
        if ($ver[0] >= 5) {
            $data = file_get_contents('php://input');
        } else {
            $data = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
        }
        
        if (count($_SERVER) == 0)
        {
            self::alert('XML-RPC: '.__METHOD__.': cannot parse request headers as $_SERVER is not populated');
        }
        
        if(isset($_SERVER['HTTP_CONTENT_ENCODING'])) {
            $content_encoding = str_replace('x-', '', $_SERVER['HTTP_CONTENT_ENCODING']);
        } else {
            $content_encoding = '';
        }
        
        if($content_encoding != '' && strlen($data)) {
            if($content_encoding == 'deflate' || $content_encoding == 'gzip') {
                // if decoding works, use it. else assume data wasn't gzencoded
                if(function_exists('gzinflate')) {
                    if ($content_encoding == 'deflate' && $degzdata = @gzuncompress($data)) {
                        $data = $degzdata;
                    } elseif ($degzdata = @gzinflate(substr($data, 10))) {
                        $data = $degzdata;
                    }
                } else {
                    self::alert('XML-RPC: '.__METHOD__.': Received from client compressed HTTP request and cannot decompress');
                }
            }
        }
        
        $parsers = php_xmlrpc_decode_xml($data);
        $this->cmd = $parsers->methodname;
        $this->input = php_xmlrpc_decode(new xmlrpcval($parsers->params, 'array'));
    }
    
    /**
     * return current command
     *
     * @return string
     */
    public function getCmd() {
        return $this->cmd;
    }
    
    /**
     * return current input
     *
     * @return array
     */
    public function getInput() {
        return $this->input;
    }
    
    public function output(&$data) {
        
        if (!headers_sent)
        {
            header('Content-Type: text/xml');
        }
        
        if (method_exists($this, $this->cmd)) {
            $response = $this->{$this->cmd}($data);
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n".$response->serialize('UTF-8');
            exit;
        } else {
            self::alert('XML-RPC: '.__METHOD__.": Unknown method '{$this->cmd}'");
        }
        
    }
    
    /**
     * output error message
     *
     * @return string default as xmlrpc
     */
    public static function alert($message, $result = false) {
        
        if (!headers_sent)
        {
            header('Content-Type: text/xml');
        }
        
        $response = new xmlrpcresp(new xmlrpcval(array(
            'result'        => new xmlrpcval($result, 'boolean'),
            'result_text'   => new xmlrpcval(strip_tags($message), 'base64'),
        ), 'struct'));
        
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n".$response->serialize('UTF-8');
        exit;
    }
    
    public function get_config($data)
    {
        $xmlrpcData = array();
        foreach($data as $key => $value)
        {
            switch ($key) {
                case 'is_open':
                case 'guest_okay':
                    $xmlrpcData[$key] = new xmlrpcval($value, 'boolean');
                    break;
                case 'min_search_length':
                    $xmlrpcData[$key] = new xmlrpcval($value, 'int');
                    break;
                default:
                    $xmlrpcData[$key] = new xmlrpcval($value);
            }
        }
        
        return new xmlrpcresp(new xmlrpcval($xmlrpcData, 'struct'));
    }
}

?>