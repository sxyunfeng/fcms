<?php

namespace apps\admin\libraries;

use Phalcon\DI\InjectionAwareInterface;

class ArticlesData implements  InjectionAwareInterface {
	
	private $_di;
	
	public function setDI(\Phalcon\DiInterface $dependencyInjector) {
		// TODO Auto-generated method stub
		$this->_di = $dependencyInjector;
	}
	
	/* (non-PHPdoc)
	 * @see \Phalcon\DI\InjectionAwareInterface::getDI()
	*/
	public function getDI() {
		// TODO Auto-generated method stub
		return $this->_di;
	}

	
}

?>