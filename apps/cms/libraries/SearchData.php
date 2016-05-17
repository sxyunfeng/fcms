<?php

namespace apps\cms\libraries;

use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

class SearchData implements InjectionAwareInterface{

	/* (non-PHPdoc)
	 * @see \Phalcon\DI\InjectionAwareInterface::setDI()
	*/
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
	
	/**
	 * 获取关键字查询的列表
	 * @param unknown $key
	 * @param unknown $page
	 * @return \Phalcon\Paginator\Adapter\stdClass
	 */
	public function getSearchRes( $key , $page )
	{
		
		$xs = $this->getDI()->get( 'xs_article' );
		$search = $xs->search;
		$search->setQuery( $key );
		$res =  $search->search();
		
		$pagination = new PaginatorArray( array(
			'data'  => $res,
			'limit' => 10,
			'page'  => $page
		) );
		
		return $pagination->getPaginate();
	}
}

?>