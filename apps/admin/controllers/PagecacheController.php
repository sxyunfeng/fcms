<?php

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use apps\admin\models\PageCache;
use libraries\TimeUtils;
/**
 * 页面缓存 配置中心
 * @author Carey
 * @date 2015-10-30
 * 
 */
class PagecacheController extends AdminBaseController{
	
	public function initialize()
	{
		parent::initialize();
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-30' )
	 * @comment( comment = '页面缓存管理首页' )
	 * @method( method = 'indexAction' )
	 * @op( op = 'r' )
	 */
	public function indexAction()
	{
		$pageNum = $this->request->getQuery( 'page', 'int' );
		$currentPage = $pageNum ? $pageNum : 1;
		
		$where = array(
			'column'	=> 'delsign,addtime,uptime,cname,cache_time,type,is_warm_up,module',
			'conditions'=> 'delsign=:del: ORDER BY uptime DESC',
			'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO ),
		);
		$result = PageCache::find( $where );
		
		$pagination = new PaginatorModel( array(
				'data'  => $result,
				'limit' => 10,
				'page'  => $currentPage
		) );
		
		$page = $pagination->getPaginate();
		$this->view->page = $page;
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-30' )
	 * @comment( comment = '添加页面缓存项' )
	 * @method( method = 'addAction' )
	 * @op( op = 'r' )
	 */
	public function addAction()
	{
		
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-30' )
	 * @comment( comment = '页面缓存管理业务' )
	 * @method( method = 'saveAction' )
	 * @op( op = 'r' )
	 */
	public function saveAction()
	{
		$optid = $this->request->getPost( 'id' );
		$cname = $this->request->getPost( 'ename' );
		$type  = $this->request->getPost( 'type' );
		$ctime = $this->request->getPost( 'cache_time' );
		$is_warm_up = $this->request->getPost( 'is_warm_up' );
		$module = $this->request->getPost( 'module' );
		
		if( false != $optid )
		{
			$where = array(
				'column'	=> 'delsign,addtime,uptime,cname,cache_time,type,is_warm_up,module',
				'conditions'=> 'delsign=:del: and id=:optid: ',
				'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO, 'optid'=> $optid ),
			);
			$cache = PageCache::findFirst( $where );
			if( count( $cache ) > 0 && false != $cache )
			{
				$cache->cname	= $cname;
				$cache->cache_time = $ctime;
				$cache->type 	= $type;
				$cache->module	= $module;
				$cache->is_warm_up = $is_warm_up;
				$cache->uptime = TimeUtils::getFullTime();
				if( $cache->save() )
					$this->response->redirect( '/admin/pagecache/index' );
				else 
					$this->response->redirect( '/admin/pagecache/update/id/' . $optid );
			}
			else 
				$this->response->redirect( '/admin/pagecache/add' );
			
		}
		else
		{
			$cache = new PageCache();
			$cache->delsign = SystemEnums::DELSIGN_NO;
			$cache->addtime = $cache->uptime = TimeUtils::getFullTime();
			$cache->cname	= $cname;
			$cache->cache_time = $ctime;
			$cache->type 	= $type;
			$cache->module	= $module;
			$cache->is_warm_up = $is_warm_up;
			if( $cache->save() )
				$this->response->redirect( '/admin/pagecache/index' );
			else
				$this->response->redirect( '/admin/pagecache/add' );
		}
		
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-30' )
	 * @comment( comment = '修改页面缓存' )
	 * @method( method = 'updateAction' )
	 * @op( op = 'r' )
	 */
	public function updateAction()
	{
		$optid = $this->dispatcher->getParam( 'id' );
		if( false == $optid )
		{
			$this->response->redirect( '/admin/pagecache/index' );
			return false;
		}
		
		$where = array(
			'column'	=> 'delsign,addtime,uptime,cname,cache_time,type,is_warm_up,module',
			'conditions'=> 'delsign=:del: and id=:optid: ',
			'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO, 'optid'=> $optid ),
		);
		$cache = PageCache::findFirst( $where );
		if( count( $cache ) > 0  && false != $cache )
		{
			$this->view->setVar( 'res' , $cache );
			$this->view->pick( 'pagecache/add' );
		}
		else
			$this->response->redirect( '/admin/pagecache/index' );
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-30' )
	 * @comment( comment = '删除页面缓存配置项' )
	 * @method( method = 'deleteAction' )
	 * @op( op = 'r' )
	 */
	public function deleteAction()
	{
		$objRet = new \stdClass();
		$optid = $this->dispatcher->getParam( 'id' );
		if( false == $optid )
		{
			$objRet->state = 1;
			$objRet->msg = '参数配置错误,请刷新后重试...';
			
			echo json_encode( $objRet );
		}
		
		$where = array(
			'column'	=> 'delsign,addtime,uptime,cname,cache_time,type,is_warm_up,module',
			'conditions'=> 'delsign=:del: and id=:optid: ',
			'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO, 'optid'=> $optid ),
		);
		$cache = PageCache::findFirst( $where );
		if( count( $cache ) > 0  && false != $cache )
		{
			$this->optCacheManager( 'delete' , $cache );
			$cache->delete();
			$objRet->state = 0;
			$objRet->optid = $optid;
			$objRet->msg = '删除成功...';
		}
		else
		{
			$objRet->state = 1;
			$objRet->msg  = '数据未找到,或已被删除..';		
		}
		echo json_encode( $objRet );
	}
	
	
	/**
	 * 缓存项设置
	 * @param string $type
	 * @param object $data
	 * @return boolean
	 */
	private function optCacheManager( $type , $data )
	{
		$cacheAdapter = $this->config[ 'cacheAdapter' ];
		 
		switch( $cacheAdapter )
		{
			case 'memcache': // 0  永久不失效
				$driver = $this->memCache;
				$cacheTime = 0;
			break;
			case 'file': //-1   永久不失效
				$driver = $this->fileCache;
				$cacheTime = -1;
			break;
			case 'memory': // 0   永久不失效
				$driver = $this->memory;
				$cacheTime = 0;
			break;
			case 'apc': // 0  永久不失效
				$driver = $this->apcCache;
				$cacheTime = 0;
			break;
			case 'xcache': //0   永久不失效
				$driver = $this->xcache;
				$cacheTime = 0;
			break;
			case 'mongo':
				$driver = $this->mongoCache;
				$cacheTime = null;
			break;
		}
		if( false == $driver )
			return false;
		
		if( false == $type )
		{
			$where = array(
				'column'	=> 'delsign,addtime,uptime,cname,cache_time,type,is_warm_up,module',
				'conditions'=> 'delsign=:del: is_warm_up=:warm: ',
				'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO, 'warm' => 1 ),
			);
			$result = PageCache::find( $where );
			if( count( $result ) > 0 && false != $result )
			{
				foreach( $result as $row )
				{
					$driver->save( 'per_' . $row->cname . '_cache',  $row, $cacheTime ); 
				}
			}
			
			return;
		}
		
		switch( $type )
		{
			case 'update':
				if( false != $driver->exists( 'per_'. $data->cname .'_cache' ) )
				{
					$driver->delete( 'per_'. $data->cname .'_cache' );
					
					$driver->save( 'per_'. $data->cname .'_cache' , $data , $cacheTime );
				}
			break;
			case 'delete':
				if( false != $driver->exists( 'per_'. $data->cname .'_cache' ) )
    					$driver->delete( 'per_'. $data->cname .'_cache' );
			break;
			case 'insert':
				$driver->save( 'per_'. $data->cname .'_cache' , $data , $cacheTime );
			default:
			
			break;
		}
	}
}

?>