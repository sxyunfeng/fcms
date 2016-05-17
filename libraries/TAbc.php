<?php

namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class TAbc implements \Phalcon\DI\InjectionAwareInterface
{
	protected $_di;
	
	
	public function __construct()
	{
		
	}
	
	/* (non-PHPdoc)
	 * @see \Phalcon\Di\InjectionAwareInterface::setDI()
	 */
	public function setDI( $dependencyInjector )
	{
		// TODO Auto-generated method stub
		$this->_di = $dependencyInjector;
	}

	/* (non-PHPdoc)
	 * @see \Phalcon\Di\InjectionAwareInterface::getDI()
	 */
	public function getDI()
	{
		// TODO Auto-generated method stub
		return $this->_di;
	}

	public function getA(  )
	{
		echo __FILE__;
	}
}


?>