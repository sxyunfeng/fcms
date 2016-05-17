<?php

/**
 * 缓存管理
 * @author yyl
 * time 2015-9-16
 */

namespace apps\admin\controllers;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\CacheManage;
use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class CacheController extends AdminBaseController
{

    public function initialze()
    {
        parent::initialize();
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.16' )
     * @comment( comment = '缓存管理首页' )
     * @method( method = 'indexAction' )		
     * @op( op = 'r' )		
     */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;

        $phql = 'select * from apps\admin\models\CacheManage  '
                . '   where delsign=' . SystemEnums::DELSIGN_NO . ' order by id desc';

        $list = $this->modelsManager->executeQuery( $phql );
        
        $pagination = new PaginatorModel( array(
            'data'  => $list,
            'limit' => 10,
            'page'  => $currentPage
                ) );

        $page = $pagination->getPaginate();
        $this->view->page = $page;
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.17' )
     * @comment( comment = '添加缓存页' )
     * @method( method = 'addAction' )		
     * @op( op = 'r' )		
     */
    public function addAction()
    {
        
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.17' )
     * @comment( comment = '编辑缓存页' )
     * @method( method = 'editAction' )		
     * @op( op = 'r' )		
     */
    public function editAction()
    {
        $Id = $this->request->getQuery( 'id', 'int' );
        $cache = CacheManage::findFirst( array( 'id=?0', 'bind' => array( $Id ), 'columns' => '*' ) );

        if( $cache )
        {
            $this->view->CacheMgr = $cache->toArray();
        }
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.17' )
     * @comment( comment = '添加缓存信息' )
     * @method( method = 'insertAction' )		
     * @op( op = 'c' )		
     */
    public function insertAction()
    {
//        $this->csrfCheck();

        $data[ 'ename' ] = $this->request->getPost( 'ename', 'string' );
        $data[ 'ename_rule' ] = $this->request->getPost( 'ename_rule', 'string' );
        $data[ 'name' ] = $this->request->getPost( 'name', 'string' );
        $data[ 'type' ] = $this->request->getPost( 'type', 'int' );
        $data[ 'cache_time' ] = $this->request->getPost( 'cache_time', 'string' );
        $data[ 'is_warm_up' ] = $this->request->getPost( 'is_warm_up', 'int' );
        $data[ 'module' ] = $this->request->getPost( 'module', 'int' );
        $data[ 'addtime' ] = date( 'Y-m-d H:i:s' );
        $data[ 'delsign' ] = 0;

        $cacheManage = new CacheManage();
        if( $cacheManage->save( $data ) )
        {
        	if( false !=  $data[ 'is_warm_up' ] )
        	{
        		$where = array(
        			'column'	=> 'id,addtime,uptime,delsign,descr,name,ename,ename_rule,cache_time,type,is_warm_up,module',
        			'conditions'=> 'delsign=:del: and id=:optid:',
        			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $cacheManage->id ),
        		);
        		$cache = CacheManage::findFirst( $where );
        		$this->cacheManagerCenter( $cache ,  'insert' ); //添加缓存的缓存项
        	}
            $this->success( '保存成功', array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
        }
        else
       {
            $this->error( '保存失败', array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
        }
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.17' )
     * @comment( comment = '更新缓存信息' )
     * @method( method = 'updateAction' )		
     * @op( op = 'u' )		
     */
    public function updateAction()
    {
        $data[ 'id' ] = $this->request->getPost( 'id', 'int' );
        $data[ 'ename' ] = $this->request->getPost( 'ename', 'string' );
        $data[ 'ename_rule' ] = $this->request->getPost( 'ename_rule', 'string' );
        $data[ 'name' ] = $this->request->getPost( 'name', 'string' );
        $data[ 'type' ] = $this->request->getPost( 'type', 'int' );
        $data[ 'cache_time' ] = $this->request->getPost( 'cache_time', 'string' );
        $data[ 'is_warm_up' ] = $this->request->getPost( 'is_warm_up', 'int' );
        $data[ 'module' ] = $this->request->getPost( 'module', 'int' );
        $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );

        if( $this->shopId ) //只有本店的才可以操作广告
        {
            $this->error( '你没有权限更新' );
        }

        $cacheManage = new CacheManage();
        $status = $cacheManage->updateCache( $data );
        if( $status )
        {
        	if(  false != $data[ 'is_warm_up' ] )
        	{
        		$where = array(
        				'column'	=> 'id,addtime,uptime,delsign,descr,name,ename,ename_rule,cache_time,type,is_warm_up,module',
        				'conditions'=> 'delsign=:del: and id=:optid:',
        				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $data['id'] ),
        		);
        		$cache = CacheManage::findFirst( $where );
        		$this->cacheManagerCenter( $cache ,  'update' );//更新缓存的缓存项
        	}
        	
            $this->success( '更新成功' );
        }
        else
        {
            $this->error( '更新失败' );
        }
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.17' )
     * @comment( comment = '删除缓存信息' )
     * @method( method = 'deleteAction' )		
     * @op( op = 'd' )		
     */
    public function deleteAction()
    {
        $data[ 'id' ] = $this->request->getPost( 'id', 'int' );
        $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
        if( $this->shopId ) //只有本店的才可以操作广告
        {
            $this->error( '你没有权限删除' );
        }

        $delWhere = array(
        	'column'	=> 'id,addtime,uptime,delsign,descr,name,ename,ename_rule,cache_time,type,is_warm_up,module',
    		'conditions'=> 'delsign=:del: and id=:optid:',
    		'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $data['id'] ),
        );
        $cache = CacheManage::findFirst( $delWhere );
        if( count( $cache ) > 0 && false != $cache )
	        $this->cacheManagerCenter( $cache ,  'delete' ); //删除缓存的缓存项
        
        $CacheManage = new CacheManage();
        $status = $CacheManage->deleteCache( $data );
        if( $status )
        {
            $this->success( '删除成功' );
        }
        else
        {

            $this->error( '删除失败' );
        }
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.17' )
     * @comment( comment = '缓存搜索' )	
     * @method( method = 'searchAction' )
     * @op( op = 'r' )		
     */
    public function searchAction()
    {
        $name = $this->request->getQuery( 'name', 'trim' );
        $module = $this->request->getQuery( 'module', 'trim' );
        $cache = new CacheManage();
        $arr = $cache->searchCache( $name, $module );
        if( $arr )
        {
            $data[ 'goods' ] = $arr;
            $this->success( '查询成功', $data );
        }
        $this->error( '无该类型数据' );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.10.28' )
     * @param array $data
     * @param string $type
     */
    private function cacheManagerCenter( $data , $type )
    {//预热数据才会永久缓存
    	
    	$cacheAdapter = $this->config[ 'cacheAdapter' ];
    	
    	switch( $cacheAdapter )
    	{
    		case 'memcache': // 0  永久不失效
    			$driver = $this->memCache;
    			$cacheTime = 0;
    		break;
    		case 'redis': //在不指定生存时间时，生存时间是永久
    			$driver = $this->redisCache;
    			$cacheTime = null;
    		break;
    		case 'mongodb':
    			$driver = $this->mongodb;
    			$cacheTime = null;
    		break;
    		case 'file': //-1   永久不失效
    			$driver = $this->fileCache;
    			$cacheTime = -1;
    		break;
    		case 'memcached': // 0   永久不失效
    			$driver = $this->memCached;
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
    	
    	if( false == $data || false == $type )
    	{//缓存全部
    		$cWhere = array( 
    			'column'	=> 'id,addtime,uptime,delsign,descr,name,ename,ename_rule,cache_time,type,is_warm_up,module',
    			'conditions'=> 'delsign=:del: and is_warm_up=:warm:',
    			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'warm' => 1 ),
    		);
    		$caches = CacheManage::find( $cWhere );
    		if( count( $caches ) > 0 && false != $caches )
    		{
    			foreach( $caches as $row )
    			{
    				if( false != $driver->exists( 'per_'. $row->ename .'_cache' ) )
    					return;
    				
    				$driver->delete( 'per_'. $row->ename .'_cache' );
	    			$driver->save( 'per_'. $row->ename .'_cache' ,  $row, $cacheTime );
    			}
    		}
    	}
    	else
    	{//操作一条数据
    		
    		switch( $type )
    		{
    			case 'update':
    				if( false != $driver->exists( 'per_'. $data->ename .'_cache' ) )
    				{
    					$driver->delete( 'per_'. $data->ename .'_cache' );
    					
    					$driver->save( 'per_'. $data->ename .'_cache' , $data, $cacheTime );
    				}
    			break;
    			case 'delete':
    				if( false != $driver->exists( 'per_'. $data->ename .'_cache' ) )
    					$driver->delete( 'per_'. $data->ename .'_cache' );
    			break;
    			case 'insert':
    			default:
    				if( false != $data->is_warm_up )
    					$driver->save( 'per_'. $data->ename .'_cache', $data, $cacheTime );
    			break;
    		}
    	}
    }
    
}
