<?php

namespace apps\cms\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );
use Phalcon\Mvc\Controller;
use apps\cms\libraries\CacheMagCenter;

/**
 * CMS 文章系统 主页
 * @author Carey
 * @date 2015/10/20
 */
class IndexController  extends Controller{
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.10.20' )
	 * @comment( comment = '文章cms首页' )
	 * @method( method = 'indexAction' )
	 * @op( op = 'r' )
	 */
	public function indexAction()
	{
		//获取配置项缓存信息
		$strname = 'f_cms_page_index_cache'; 
		$cache = new CacheMagCenter();
		$cacheCfg = $cache->getPageCacheConf( $strname );
		if( false != $cacheCfg )
		{
			$mCacheName = $cacheCfg->cname;
			$iCacheType = $cacheCfg->type;
			$cache->settingPageCache( $iCacheType , $mCacheName );
		}
		$this->view->cache( array( 'key' => 'fcms_index' ) );
		
		$this->view->pick( 'default/index' );
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.10.20' )
	 * @comment( comment = '文章cms列表页' )
	 * @method( method = 'listAction' )
	 * @op( op = 'r' )
	 */
	public function listAction()
	{
		$pageNum = $this->dispatcher->getParam( 'page', 'int' );
		$currentPage = $pageNum ? $pageNum:1;
		$cid = $this->dispatcher->getParam( 'cid', 'int' );
		
		//获取配置项缓存信息
		$strname = 'f_cms_page_list_cache';
		$cache = new CacheMagCenter();
		$cacheCfg = $cache->getPageCacheConf( $strname );
		if( false != $cacheCfg )
		{
			$mCacheName = $cacheCfg->cname;
			$iCacheType = $cacheCfg->type;
			$cache->settingPageCache( $iCacheType , $mCacheName );
		}
		$keyname = $cid?'fcms_list_page_' . $currentPage . '_' . $cid:'fcms_list_page_' . $currentPage;
		$this->view->cache( array( 'key' => $keyname ) );

		$this->view->setVar( 'mid' , $cid );
		$this->view->setVar( 'curPage' , $currentPage );
		$this->view->pick( 'default/list' );
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.10.20' )
	 * @comment( comment = '文章cms详细页' )
	 * @method( method = 'detailsAction' )
	 * @op( op = 'r' )
	 */
	public function detailAction()
	{
		$optid = $this->dispatcher->getParam( 'id' );
		$this->view->setVar( 'sign' , $optid );
		//获取配置项缓存信息
		$strname = 'f_cms_page_list_cache';
		$cache = new CacheMagCenter();
		$cacheCfg = $cache->getPageCacheConf( $strname );
		if( false != $cacheCfg )
		{
			$mCacheName = $cacheCfg->cname;
			$iCacheType = $cacheCfg->type;
			$cache->settingPageCache( $iCacheType , $mCacheName );
		}
		$this->view->cache( array( 'key' => 'fcms_detail_' . $optid ) );
		
		$this->view->pick( 'default/details' );
	}
	
	/**
	 * @author( author='New' )
	 * @date( date = '2015年11月16日' )
	 * @comment( comment = 'redis方法输出文章访问量' )
	 * @method( method = 'redisInput' )
	 * @op( op = '' )
	 */
	public function redisInputAction()
	{
		$optid = $this->dispatcher->getParam( 'id' );
		if( !$optid )
		{
			$this->response->redirect( 'index/index' );
			exit;
		}
		echo $this->nredis->incr( 'artical_' . $optid );
	}
	
}

?>
