<?php

namespace apps\cms\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Controller;

/**
 * 检索查询
 * @author Carey
 * @date 2015/10/27
 */
class SearchController extends Controller{
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.10.27' )
	 * @comment( comment = '检索查询首页' )
	 * @method( method = 'indexAction' )
	 * @op( op = 'r' )
	 */
	public function indexAction()
	{
		$sKey = $this->dispatcher->getParam( 'key' );
		if( false == $sKey )
		{
			$this->response->redirect( '/' );
			return false;
		}
		$pageNum = $this->dispatcher->getParam( 'page', 'int' );
		$currentPage = $pageNum ? $pageNum : 1;
		
		$this->view->setVar( 'curPage' , $currentPage );
		$this->view->setVar( 'key' , $sKey );
		$this->view->pick( 'default/search' );
	}
	
}

?>