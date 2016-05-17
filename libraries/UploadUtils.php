<?php
namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class UploadUtils implements \Phalcon\DI\InjectionAwareInterface
{
	/* (non-PHPdoc)
	 * @see \Phalcon\Di\InjectionAwareInterface::setDI()
	 */
	public function setDI(\Phalcon\DiInterface $dependencyInjector) {
		// TODO Auto-generated method stub
	}

	/* (non-PHPdoc)
	 * @see \Phalcon\Di\InjectionAwareInterface::getDI()
	 */
	public function getDI() {
		// TODO Auto-generated method stub
		
	}
	
	public static function upload()
	{//
		return 'url';
	}
	
	public static function del()
	{
		return true;
	}
	
}

?>