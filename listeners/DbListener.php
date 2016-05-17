<?php
namespace listeners;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class DbListener
{
    protected $_logger;
    
    function __construct()
    {
        $this->_logger = new \Phalcon\Logger\Adapter\File( APP_ROOT . 'logs/sql_debug.log' );    
    }
    
    public function afterConnect( $event, $connection )
    {
        
    }
    
    public function beforeQuery( $event, $connection )
    {
    	if (preg_match('/DROP|ALTER/i', $connection->getSQLStatement())) {
    		// DROP/ALTER operations aren’t allowed in the application,
    		// this must be a SQL injection!
    		
    		//log sql injection
    		return false;
    	}
    }
    
    public function afterQuery( $event, $connection )
    {
        $this->_logger->log( $connection->getSQLStatement(), \Phalcon\Logger::INFO );
    }

}

?>