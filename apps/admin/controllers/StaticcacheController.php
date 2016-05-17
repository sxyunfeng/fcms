<?php

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use apps\admin\models\StaticCache;
use libraries\TimeUtils;
use apps\admin\models\CacheMgrConfig;
use apps\admin\enums\CachecfgEnums;

/**
 * 页面静态化配置中心
 * @author Carey
 * @date 2015-10-30
 */
class StaticcacheController extends AdminBaseController{
	
	public function initialize()
	{
		parent::initialize();
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '静态化默认配置页面' )
	 * @method( method = 'addAction' )
	 * @op( op = 'r' )
	 */
	public function indexAction()
	{
		//基本配置
		$baseWhere = array(
			'column'	=> 'id,delsign,index,type,list,detail',
			'conditions'=> 'delsign=:del: and type=:type: ORDER BY uptime DESC',
			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'type' => CachecfgEnums::CACHE_CONFIG_BASE ),
		);
		$base = CacheMgrConfig::findFirst( $baseWhere );
		$this->view->base = $base;
		//驱动配置
		$driverWhere = array(
			'column'	=> 'id,delsign,index,type,list,detail',
			'conditions'=> 'delsign=:del: and type=:type: ORDER BY uptime DESC',
			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'type' => CachecfgEnums::CACHE_CONFIG_DRIVER ),
		);
		$driver = CacheMgrConfig::findFirst( $driverWhere );
		$this->view->driver = $driver;
		//存储配置
		$storageWhere = array(
			'column'	=> 'id,delsign,index,type,list,detail',
			'conditions'=> 'delsign=:del: and type=:type: ORDER BY uptime DESC',
			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'type' => CachecfgEnums::CACHE_CONFIG_STORAGE ),
		);
		$storage = CacheMgrConfig::findFirst( $storageWhere );
		$this->view->storage = $storage;
		
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '静态缓存配置项管理业务' )
	 * @method( method = 'saveAction' )
	 * @op( op = 'r' )
	 */
	public function saveAction()
	{
		$objRet = new \stdClass();
		$type	= $this->request->getPost( 'type' );
		if( false == $type )
		{
			$objRet->state =1;
			$objRet->msg = '对不起,参数未配置正确,请稍后再试...';
			
			echo json_encode( $objRet );
			exit;
		}
		
		switch( $type )
		{
			case 1://基本配置
				$index_cache_time 	= $this->request->getPost( 'ctime' );
				$list_cache_time	= $this->request->getPost( 'ltime' );
				$detail_cache_time	= $this->request->getPost( 'dtime' );
				$time_id			= $this->request->getPost( 'sign' );
				if( false != $time_id )
				{
					$where = array(
						'column'	=> 'id,delsign,index,type,list,detail',
						'conditions'=> 'delsign=:del: and id=:sign: and type=:type:',
						'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'sign' => $time_id , 'type' => CachecfgEnums::CACHE_CONFIG_BASE ),
					);
					$res = CacheMgrConfig::findFirst( $where );
					if( false != $res || count( $res ) > 0 )
					{
						$res->uptime	= TimeUtils::getFullTime();
						$res->index	= $index_cache_time;
						$res->list		= $list_cache_time;
						$res->detail	= $detail_cache_time;
						if( false == $res->save() )
						{
							$objRet->state = 1;
							$objRet->msg = '对不起,更新失败,请稍后刷新后重试...';
						}
						else
						{
							$objRet->state = 0;
							$objRet->msg = '操作成功...';
							$objRet->optdata = $res;
						}
					}
					else 
					{
						$objRet->state = 1;
						$objRet->msg = '对不起,操作失败,请稍后再试...';
					}
				}
				else 
				{
					$cachecfg = new CacheMgrConfig();
					$cachecfg->delsign	= SystemEnums::DELSIGN_NO;
					$cachecfg->addtime	= $cachecfg->uptime	= TimeUtils::getFullTime();
					$cachecfg->index	= $index_cache_time;
					$cachecfg->list		= $list_cache_time;
					$cachecfg->detail	= $detail_cache_time;
					$cachecfg->type		= CachecfgEnums::CACHE_CONFIG_BASE;
					if( false == $cachecfg->save() )
					{
						$objRet->state = 1;
						$objRet->msg = '对不起,操作失败,请稍后再试...';
					}
					else
					{
						$objRet->state = 0;
						$objRet->msg = '操作成功...';
						$objRet->optdata = $cachecfg;
					}
				}
				echo json_encode( $objRet );
			break;
			case 2://驱动配置
				$index_cache_driver 	= $this->request->getPost( 'cdriver' );
				$list_cache_driver		= $this->request->getPost( 'ldriver' );
				$detail_cache_driver	= $this->request->getPost( 'ddriver' );
				$driver_id			= $this->request->getPost( 'sign' );
				if( false != $driver_id )
				{
					$where = array(
							'column'	=> 'id,delsign,index,type,list,detail',
							'conditions'=> 'delsign=:del: and id=:sign: and type=:type:',
							'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'sign' => $driver_id , 'type' => CachecfgEnums::CACHE_CONFIG_DRIVER ),
					);
					$res = CacheMgrConfig::findFirst( $where );
					if( false != $res || count( $res ) > 0 )
					{
						$res->uptime	= TimeUtils::getFullTime();
						$res->index	= $index_cache_driver;
						$res->list		= $list_cache_driver;
						$res->detail	= $detail_cache_driver;
						if( false == $res->save() )
						{
							$objRet->state = 1;
							$objRet->msg = '对不起,更新失败,请稍后刷新后重试...';
						}
						else
						{
							$objRet->state = 0;
							$objRet->msg = '操作成功...';
							$objRet->optdata = $res;
						}
					}
					else
					{
						$objRet->state = 1;
						$objRet->msg = '对不起,操作失败,请稍后再试...';
					}
				}
				else
				{
					$cachecfg = new CacheMgrConfig();
					$cachecfg->delsign	= SystemEnums::DELSIGN_NO;
					$cachecfg->addtime	= $cachecfg->uptime	= TimeUtils::getFullTime();
					$cachecfg->index	= $index_cache_driver;
					$cachecfg->list		= $list_cache_driver;
					$cachecfg->detail	= $detail_cache_driver;
					$cachecfg->type		= CachecfgEnums::CACHE_CONFIG_DRIVER;
					if( false == $cachecfg->save() )
					{
						$objRet->state = 1;
						$objRet->msg = '对不起,操作失败,请稍后再试...';
					}
					else
					{
						$objRet->state = 0;
						$objRet->msg = '操作成功...';
						$objRet->optdata = $cachecfg;
					}
				}
				echo json_encode( $objRet );
			break;
			case 3://存储配置
				$index_cache_storage 	= $this->request->getPost( 'cstorage' );
				$list_cache_storage		= $this->request->getPost( 'lstorage' );
				$detail_cache_storage	= $this->request->getPost( 'dstorage' );
				$storage_id				= $this->request->getPost( 'sign' );
				if( false != $storage_id )
				{
					$where = array(
							'column'	=> 'id,delsign,index,type,list,detail',
							'conditions'=> 'delsign=:del: and id=:sign: and type=:type:',
							'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'sign' => $storage_id , 'type' => CachecfgEnums::CACHE_CONFIG_STORAGE ),
					);
					$res = CacheMgrConfig::findFirst( $where );
					if( false != $res || count( $res ) > 0 )
					{
						$res->uptime	= TimeUtils::getFullTime();
						$res->index		= $index_cache_storage;
						$res->list		= $list_cache_storage;
						$res->detail	= $detail_cache_storage;
						if( false == $res->save() )
						{
							$objRet->state = 1;
							$objRet->msg = '对不起,操作失败,请稍后再试...';
						}
						else
						{
							$objRet->state = 0;
							$objRet->msg = '操作成功...';
							$objRet->optdata = $res;
						}
					}
					else
					{
						$objRet->state = 1;
						$objRet->msg = '对不起,操作失败,请稍后再试...';
					}
				}
				else
				{
					$cachecfg = new CacheMgrConfig();
					$cachecfg->delsign	= SystemEnums::DELSIGN_NO;
					$cachecfg->addtime	= $cachecfg->uptime	= TimeUtils::getFullTime();
					$cachecfg->index	= $index_cache_storage;
					$cachecfg->list		= $list_cache_storage;
					$cachecfg->detail	= $detail_cache_storage;
					$cachecfg->type		= CachecfgEnums::CACHE_CONFIG_STORAGE;
					if( false == $cachecfg->save() )
					{
						$objRet->state = 1;
						$objRet->msg = '对不起,操作失败,请稍后再试...';
					}
					else
					{
						$objRet->state = 0;
						$objRet->msg = '操作成功...';
						$objRet->optdata = $cachecfg;
					}
				}
				echo json_encode( $objRet );
			break;
		}
	}
	
	
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '静态化栏目/首页配置页面' )
	 * @method( method = 'addAction' )
	 * @op( op = 'r' )
	 */
	public function columnAction()
	{
		$pageNum = $this->request->getQuery( 'page', 'int' );
		$currentPage = $pageNum ? $pageNum : 1;
		
		$where = array(
				'column'	=> 'delsign,addtime,uptime,name,cache_time,type,cfgtype',
				'conditions'=> 'delsign=:del: and cfgtype=:cfgtype: ORDER BY uptime DESC',
				'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO , 'cfgtype' => 1 ),
		);
		$result = StaticCache::find( $where );
		
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
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '静态化栏目/首页配置操作页面' )
	 * @method( method = 'optColumnAction' )
	 * @op( op = 'r' )
	 */
	public function optColumnAction()
	{
		$optid = $this->dispatcher->getParam( 'id' );
		if( false != $optid )
		{
			$where = array(
				'column'	=> 'id,delsign,uptime,addtime,cfgtype,type',
				'conditions'=> 'delsign=:del: and id=:optid: and cfgtype=:cfgtype:',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'optid' => $optid , 'cfgtype' => 1 ),
			);
			$res = StaticCache::findFirst( $where );
			if( false != $res && count( $res ) > 0 )
				$this->view->res = $res;
			
		}
		
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '静态化栏目/首页配置操作业务' )
	 * @method( method = 'saveColumnActin' )
	 * @op( op = 'r' )
	 */
	public function saveColumnAction()
	{
		$optid = $this->request->getPost( 'id' );
		$name	= $this->request->getPost( 'name' );
		$prename  = $this->request->getPost( 'pre_name' );
		$type	= $this->request->getPost( 'type' );
		$cacheTime = $this->request->getPost( 'cache_time' );
		
		if( false != $optid )
		{
			$where = array(
				'column'	=> 'delsign,addtime,uptime,cname,cache_time,type,is_warm_up,module',
				'conditions'=> 'delsign=:del: and id=:optid: ',
				'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO, 'optid'=> $optid ),
			);
			$res = StaticCache::findFirst( $where );
			if( count( $res ) > 0 && false != $res )
			{
				$res->uptime = TimeUtils::getFullTime();
				$res->name	= $name;
				$res->prefix = $prename;
				$res->type   = $type;
				$res->cache_time = $cacheTime?$cacheTime:0;
				if( $res->save() )
					$this->response->redirect( '/admin/staticcache/column' );
				else 
					$this->response->redirect( '/admin/staticcache/optcolumn/id/' . $optid );
			}
			else 
				$this->response->redirect( '/admin/staticcache/column' );
		}
		else
		{
			$res = new StaticCache();
			$res->delsign = SystemEnums::DELSIGN_NO;
			$res->addtime = $res->uptime = TimeUtils::getFullTime();
			$res->name	= $name;
			$res->prefix = $prename;
			$res->type   = $type;
			$res->cache_time = $cacheTime?$cacheTime:0;
			$res->cfgtype	= 1;
			if( $res->save() )
				$this->response->redirect( '/admin/staticcache/column' );
			else 
				$this->response->redirect( '/admin/staticcache/optcolumn' );
		}
		
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '删除静态缓存配置项' )
	 * @method( method = 'deleteAction' )
	 * @op( op = 'r' )
	 */
	public function delColumnAction()
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
				'column'	=> 'delsign,addtime,uptime,name,cache_time,cfgtype,type',
				'conditions'=> 'delsign=:del: and id=:optid: and cfgtype=:cfgtype: ',
				'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO, 'optid'=> $optid , 'cfgtype' => 1 ),
		);
		$cache = StaticCache::findFirst( $where );
		if( count( $cache ) > 0  && false != $cache )
		{
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
	 * @author( author='Carey' )
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '静态化列表页配置页面' )
	 * @method( method = 'addAction' )
	 * @op( op = 'r' )
	 */
	public function listAction()
	{
		$pageNum = $this->request->getQuery( 'page', 'int' );
		$currentPage = $pageNum ? $pageNum : 1;
		
		$where = array(
				'column'	=> 'delsign,addtime,uptime,name,cache_time,type,cfgtype',
				'conditions'=> 'delsign=:del: and cfgtype=:cfgtype: ORDER BY uptime DESC',
				'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO , 'cfgtype' => 2 ),
		);
		$result = StaticCache::find( $where );
		
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
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '静态化列表页配置项操作页面' )
	 * @method( method = 'optListAction' )
	 * @op( op = 'r' )
	 */
	public function optListAction()
	{
		$optid = $this->dispatcher->getParam( 'id' );
		if( false != $optid )
		{
			$where = array(
					'column'	=> 'id,delsign,uptime,addtime,cfgtype,type',
					'conditions'=> 'delsign=:del: and id=:optid: and cfgtype=:cfgtype:',
					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'optid' => $optid , 'cfgtype' => 2 ),
			);
			$res = StaticCache::findFirst( $where );
			if( false != $res && count( $res ) > 0 )
				$this->view->res = $res;
				
		}
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '静态化列表页配置业务' )
	 * @method( method = 'addAction' )
	 * @op( op = 'r' )
	 */
	public function saveListAction()
	{
		$optid = $this->request->getPost( 'id' );
		$name	= $this->request->getPost( 'name' );
		$prename  = $this->request->getPost( 'pre_name' );
		$type	= $this->request->getPost( 'type' );
		$cacheTime = $this->request->getPost( 'cache_time' );
		
		if( false != $optid )
		{
			$where = array(
					'column'	=> 'delsign,addtime,uptime,cname,cache_time,type,is_warm_up,module',
					'conditions'=> 'delsign=:del: and id=:optid: ',
					'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO, 'optid'=> $optid ),
			);
			$res = StaticCache::findFirst( $where );
			if( count( $res ) > 0 && false != $res )
			{
				$res->uptime = TimeUtils::getFullTime();
				$res->name	= $name;
				$res->prefix = $prename;
				$res->type   = $type;
				$res->cache_time = $cacheTime?$cacheTime:0;
				if( $res->save() )
					$this->response->redirect( '/admin/staticcache/list' );
				else
					$this->response->redirect( '/admin/staticcache/optlist/id/' . $optid );
			}
			else
				$this->response->redirect( '/admin/staticcache/list' );
		}
		else
		{
			$res = new StaticCache();
			$res->delsign = SystemEnums::DELSIGN_NO;
			$res->addtime = $res->uptime = TimeUtils::getFullTime();
			$res->name	= $name;
			$res->prefix = $prename;
			$res->type   = $type;
			$res->cache_time = $cacheTime?$cacheTime:0;
			$res->cfgtype	= 2;
			if( $res->save() )
				$this->response->redirect( '/admin/staticcache/list' );
			else
				$this->response->redirect( '/admin/staticcache/optlist' );
		}
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '静态化列表删除' )
	 * @method( method = 'delListAction' )
	 * @op( op = 'r' )
	 */
	public function delListAction()
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
				'column'	=> 'delsign,addtime,uptime,name,cache_time,cfgtype,type',
				'conditions'=> 'delsign=:del: and id=:optid: and cfgtype=:cfgtype: ',
				'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO, 'optid'=> $optid , 'cfgtype' => 2 ),
		);
		$cache = StaticCache::findFirst( $where );
		if( count( $cache ) > 0  && false != $cache )
		{
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
	 * @author( author='Carey' )
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '静态化详情页配置页面' )
	 * @method( method = 'detailAction' )
	 * @op( op = 'r' )
	 */
	public function detailAction()
	{
		$pageNum = $this->request->getQuery( 'page', 'int' );
		$currentPage = $pageNum ? $pageNum : 1;
		
		$where = array(
				'column'	=> 'delsign,addtime,uptime,name,cache_time,type,cfgtype',
				'conditions'=> 'delsign=:del: and cfgtype=:cfgtype: ORDER BY uptime DESC',
				'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO , 'cfgtype' => 3 ),
		);
		$result = StaticCache::find( $where );
		
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
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '静态化详情页配置页面' )
	 * @method( method = 'optDetailAction' )
	 * @op( op = 'r' )
	 */
	public function optDetailAction()
	{
		$optid = $this->dispatcher->getParam( 'id' );
		if( false != $optid )
		{
			$where = array(
					'column'	=> 'id,delsign,uptime,addtime,cfgtype,type,name,type',
					'conditions'=> 'delsign=:del: and id=:optid: and cfgtype=:cfgtype:',
					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'optid' => $optid , 'cfgtype' => 3 ),
			);
			$res = StaticCache::findFirst( $where );
			if( false != $res && count( $res ) > 0 )
				$this->view->res = $res;
			
		}

	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '静态化详情页配置业务' )
	 * @method( method = 'saveDetailAction' )
	 * @op( op = 'r' )
	 */
	public function saveDetailAction()
	{
		$optid = $this->request->getPost( 'id' );
		$name	= $this->request->getPost( 'name' );
		$prename  = $this->request->getPost( 'pre_name' );
		$type	= $this->request->getPost( 'type' );
		$cacheTime = $this->request->getPost( 'cache_time' );
		
		if( false != $optid )
		{
			$where = array(
					'column'	=> 'delsign,addtime,uptime,cname,cache_time,type,is_warm_up,module',
					'conditions'=> 'delsign=:del: and id=:optid: ',
					'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO, 'optid'=> $optid ),
			);
			$res = StaticCache::findFirst( $where );
			if( count( $res ) > 0 && false != $res )
			{
				$res->uptime = TimeUtils::getFullTime();
				$res->name	= $name;
				$res->prefix = $prename;
				$res->type   = $type;
				$res->cache_time = $cacheTime?$cacheTime:0;
				if( $res->save() )
					$this->response->redirect( '/admin/staticcache/detail' );
				else
					$this->response->redirect( '/admin/staticcache/optdetail/id/' . $optid );
			}
			else
				$this->response->redirect( '/admin/staticcache/detail' );
		}
		else
		{
			$res = new StaticCache();
			$res->delsign = SystemEnums::DELSIGN_NO;
			$res->addtime = $res->uptime = TimeUtils::getFullTime();
			$res->name	= $name;
			$res->prefix = $prename;
			$res->type   = $type;
			$res->cache_time = $cacheTime?$cacheTime:0;
			$res->cfgtype	= 3;
			if( $res->save() )
				$this->response->redirect( '/admin/staticcache/detail' );
			else
				$this->response->redirect( '/admin/staticcache/optdetail' );
		}
	}
	
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-11-07' )
	 * @comment( comment = '删除静态化详情页配置' )
	 * @method( method = 'delDetailAction' )
	 * @op( op = 'r' )
	 */
	public function delDetailAction()
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
				'column'	=> 'delsign,addtime,uptime,name,cache_time,cfgtype,type',
				'conditions'=> 'delsign=:del: and id=:optid: and cfgtype=:cfgtype: ',
				'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO, 'optid'=> $optid , 'cfgtype' => 3 ),
		);
		$cache = StaticCache::findFirst( $where );
		if( count( $cache ) > 0  && false != $cache )
		{
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
}

?>