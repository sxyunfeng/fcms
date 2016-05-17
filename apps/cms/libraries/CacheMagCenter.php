<?php

namespace apps\cms\libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\cms\models\CacheManage;
use enums\SystemEnums;
use Phalcon\Mvc\Controller;
use apps\admin\models\PageCache;
use Phalcon\Cache\Frontend\Output as OutputFrontend;
use Phalcon\Cache\Backend\Memcache as MemcacheBackend;
use Phalcon\Cache\Backend\Apc as ApcBackend; 
use Phalcon\Cache\Backend\File as FileBackend;

class CacheMagCenter extends Controller{
	
	/**
	 * 根据指定的配置项名称获取指定的缓存配置项
	 * @param string $cname  缓存配置项名称
	 * @return object $cacheInfo 缓存配置项详细信息
	 */
	public function getCacheConfigs( $cname )
	{
		$adapter = $this->config[ 'cacheAdapter' ];
		switch( $adapter )
		{
			case 'memcache': // 0  永久不失效
				if( false != $this->memCache->exists( 'per_'. $cname .'_cache' ) )
					$cacheInfo = $this->memCache->get( 'per_'. $cname .'_cache' );
				else
					$cacheInfo = $this->reSetCache( 'memCache', $cname );
				
				$driver = $this->memCache;
				$lefttime = 0;
			break;
			case 'redis': //在不指定生存时间时，生存时间是永久 
				if( $this->redisCache->exists( 'per_'. $cname .'_cache' ) )
					$cacheInfo = $this->redisCache->get( 'per_'. $cname .'_cache' );
				else
					$cacheInfo =  $this->reSetCache( 'redis', $cname , NULL );
				
				$driver = $this->redisCache;
				$lefttime = 0;
			break;
			case 'mongodb':
				if( $this->mongodb->exists( 'per_'. $cname .'_cache' ) )
					$cacheInfo = $this->mongodb->get( 'per_'. $cname .'_cache' );
				else
					$cacheInfo =  $this->reSetCache( 'mongodb', $cname, NULL );
				
				$driver = $this->mongodb;
				$lefttime = NULL;
			break;
			case 'file':
				if( $this->fileCache->exists( 'per_'. $cname .'_cache' ) )
					$cacheInfo = $this->fileCache->get( 'per_'. $cname .'_cache' );
				else 
					$cacheInfo = $this->reSetCache( 'fileCache' , $cname , -1 );
				
				$driver = $this->fileCache;
				$lefttime = -1;
			break;
			case 'memcached':
				if( $this->memCached->exists( 'per_'. $cname .'_cache' ) )
					$cacheInfo = $this->memCached->get( 'per_'. $cname .'_cache' );
				else
					$cacheInfo = $this->reSetCache( 'memCached' , $cname );
				
				$driver = $this->memCached;
				$lefttime = 0;
			break;
			case 'apc':
				if( $this->apcCache->exists( 'per_'. $cname .'_cache' ) )
					$cacheInfo = $this->apcCache->get( 'per_'. $cname .'_cache' );
				else 
					$cacheInfo = $this->reSetCache( 'apcCache' , $cname );
				
				$driver = $this->apcCache;
				$lefttime = 0;
			break;
			case 'xcache':
				if( $this->xcache->exists( 'per_'. $cname .'_cache' ) )
					$cacheInfo = $this->xcache->get( 'per_'. $cname .'_cache' );
				else
					$cacheInfo = $this->reSetCache( 'xcache' , $cname );
				
				$driver = $this->xcache;
				$lefttime = 0;
			break;
			case 'mongo':
				if( $this->mongoCache->exists( 'per_'. $cname .'_cache' ) )
					$cacheInfo = $this->mongoCache->get( 'per_'. $cname .'_cache' );
				else
					$cacheInfo = $this->reSetCache( 'mongoCache' , $cname, NULL );
				
				$driver = $this->mongoCache;
				$lefttime = NULL;
			break;
		}
		
		if( false == $cacheInfo )
		{
			$cWhere = array(
					'column'	=> 'id,addtime,uptime,delsign,descr,name,ename,ename_rule,cache_time,type,is_warm_up,module',
					'conditions'=> 'delsign=:del:',
					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
			);
			$caches = CacheManage::find( $cWhere );
			if( count( $caches ) > 0 && false != $caches )
			{
				foreach( $caches as $row )
				{
					if( false != $driver->exists( 'per_'. $row->ename .'_cache' ) )
						return;
					
					$driver->save( 'per_'. $row->ename .'_cache' , $row, $lefttime );
				}
				
				$cacheInfo = $driver->get( 'per_'. $cname .'_cache' );
			}
			
		}
		
		return $cacheInfo;
	}
	
	/**
	 * 重新设置失效的缓存配置项
	 * @param unknown $type
	 * @param unknown $name
	 * @param number $lefttime
	 * @return boolean|\Phalcon\Mvc\Model
	 */
	private function reSetCache( $type, $name, $lefttime = 0 )
	{
		if( false == $type || false == $name )
			return false;
		
		$where = array(
			'column'	=> 'id,addtime,uptime,delsign,descr,name,ename,ename_rule,cache_time,type,is_warm_up,module',
    		'conditions'=> 'delsign=:del: and ename=:name:',
    		'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'name' => trim( $name ) ),
		);
		$res = CacheManage::findFirst( $where );
		if( count( $res ) > 0 && false != $res )
		{
			$this->$type->save( 'per_'. $res->ename .'_cache', $res, $lefttime );
			
			return $res;
		}
		else 
			return false;
	}
	
	/**
	 * 获取页面缓存配置项
	 * @param string $cname 缓存项配置名称
	 */
	public function getPageCacheConf( $cname )
	{
		if( false == $cname )
			return false;
	
		$adapter = $this->config[ 'cacheAdapter' ];
		switch( $adapter )
		{
			case 'memcache': // 0  永久不失效
				if( false != $this->memCache->exists( 'per_' . $cname . '_cache' ) )
					$cacheInfo = $this->memCache->get( 'per_' . $cname . '_cache' );
				else
					$cacheInfo = $this->reSetPageCfg( $this->memCache, $cname );

				$driver = $this->memCache;
				$cacheTime = 0;
			break;
			case 'file': //-1   永久不失效
				if( false != $this->fileCache->exists( 'per_' . $cname . '_cache' ) )
					$cacheInfo = $this->fileCache->get( 'per_' . $cname . '_cache' );
				else
					$cacheInfo = $this->reSetPageCfg( $this->fileCache , $cname , -1 );
				
				$driver = $this->fileCache;
				$cacheTime = -1;
			break;
			case 'memory': // 0   永久不失效
				if( false !=  $this->memory->exists( 'per_' . $cname . '_cache' ) )
					$cacheInfo = $this->memory->get( 'per_' . $cname . '_cache' );
				else
					$cacheInfo = $this->reSetPageCfg( $this->memory, $cname );
				
				$driver = $this->memory;
				$cacheTime = 0;
			break;
			case 'apc': // 0  永久不失效
				if( false !=  $this->apcCache->exists( 'per_' . $cname . '_cache' ) )
					$cacheInfo = $this->apcCache->get( 'per_' . $cname . '_cache' );
				else
					$cacheInfo = $this->reSetPageCfg( $this->apcCache, $cname );

				$driver = $this->apcCache;
				$cacheTime = 0;
			break;
			case 'xcache': //0   永久不失效
				if( false !=  $this->xcache->exists( 'per_' . $cname . '_cache' ) )
					$cacheInfo = $this->xcache->get( 'per_' . $cname . '_cache' );
				else
					$cacheInfo = $this->reSetPageCfg( $this->xcache, $cname );
				
				$driver = $this->xcache;
				$cacheTime = 0;
			break;
			case 'mongo':
				if( false !=  $this->mongoCache->exists( 'per_' . $cname . '_cache' ) )
					$cacheInfo = $this->mongoCache->get( 'per_' . $cname . '_cache' );
				else
					$cacheInfo = $this->reSetPageCfg( $this->mongoCache, $cname, NULL );
				
				$driver = $this->mongoCache;
				$cacheTime = null;
			break;
		}
	
		if( false == $cacheInfo || count( $cacheInfo ) <= 0 )
		{
			$cWhere = array(
					'column'	=> 'id,addtime,uptime,delsign,descr,cname,cache_time,type,is_warm_up,module',
					'conditions'=> 'delsign=:del:',
					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
			);
			$caches = PageCache::find( $cWhere );
			if( count( $caches ) > 0 && false != $caches )
			{
				foreach( $caches as $row )
				{
					if( false != $driver->exists( 'per_'. $row->cname .'_cache' ) )
						return;
						
					$driver->save( 'per_'. $row->cname .'_cache' , $row, $cacheTime );
				}
				
				$cacheInfo = $driver->get( 'per_'. $cname .'_cache' );
			}
				
		}

		return $cacheInfo;
	}
	
	
	/**
	 * 重新设置失效的页面缓存
	 * @param unknown $type
	 * @param unknown $name
	 * @param unknown $lefttime
	 */
	private function reSetPageCfg( $driver, $name, $lefttime=0 )
	{
		if( false == $driver || false == $name )
			return false;
		
		$where = array(
				'conditions'=> 'delsign=:del: and cname=:name:',
				'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO, 'name'=> $name ),
		);
		$res = PageCache::findFirst( $where );
		if( count( $res ) > 0 && false != $res )
		{
			if( $driver->exists( 'per_'. $name . '_cache' ) )
				$driver->delete( 'per_'. $name . '_cache' );
			
			$driver->save( 'per_' . $res->cname . '_cache', $res, $lefttime );

			return $res;
		}
		else
			return false;
	
	}
	
	
	/**
	 * 设置页面缓存驱动
	 * @param unknown $itype
	 * @param unknown $strname
	 */
	public function settingPageCache( $itype , $strname )
	{
		if( false === $itype || false == $strname )
			return false;
	
		switch( $itype )
		{
			case 2:
				if( $this->memCache->exists( $strname ) )
				  $info =  $this->memCache->get( $strname );
				else 
				  $info = $this->reSetPageDriver( $strname );
				
				$this->di->set( 'viewCache', function() use( $info ){
					$frontCache = new OutputFrontend( array( 'lifetime'	=> intval( $info->cache_time * 60 )  ));
					$cache = new MemcacheBackend( $frontCache, $this->config['memcache'] );
					return $cache;
				});
			break;
			case 1:
				if( $this->fileCache->exists( $strname ) )
					$info =  $this->fileCache->get( $strname );
				else
					$info =  $this->reSetPageDriver( $strname );
				
				$this->di->set( 'viewCache', function() use( $info ){
					$frontCache = new OutputFrontend( array( 'lifetime'	=> intval( $info->cache_time * 60 ) ));
					$cache = new FileBackend( $frontCache, array( "prefix" => 'fcms', "cacheDir" => APP_ROOT . '/cache/fileCache'  ));
					return $cache;
				});
			break;
			case 3:
				if( $this->memory->exists( $strname ) )
					$info =  $this->memory->get( $strname );
				else
					$info =  $this->reSetPageDriver( $strname );
				
				$this->di->set( 'viewCache', function(){
					$frontCache = new \Phalcon\Cache\Frontend\Data();
					$cache = new \Phalcon\Cache\Backend\Memory($frontCache);
					return $cache;
				});
			break;
			case 0:
				if( $this->apcCache->exists( $strname ) )
					$info =  $this->apcCache->get( $strname );
				else
					$info =  $this->reSetPageDriver( $strname );
			
				$this->di->set( 'viewCache', function() use( $info ){
					$frontCache = new OutputFrontend( array( 'lifetime'	=> 	intval( $info->cache_time * 60 ) ));
					$cache = new ApcBackend( $frontCache, array( 'prefix' => 'fcms' ));
					return $cache;
				});
			break;
			case 5:
				if( $this->xcache->exists( $strname ) )
					$info = $this->xcache->get( $strname );
				else
					$info = $this->reSetPageDriver(  $strname );
				
				$this->di->set( 'viewCache', function() use( $info ){
					$frontCache = new \Phalcon\Cache\Frontend\Data(array( 'lifetime' => intval( $info->cache_time * 60 ) ) );
					$cache = new \Phalcon\Cache\Backend\Xcache($frontCache, array( 'prefix' => 'fcms' ) );
					return $cache;
				});
			break;
			case 4:
				if( $this->mongoCache->exists( $strname ) )
					$info = $this->mongoCache->get( $strname );
				else 
					$info =  $this->reSetPageDriver( $strname );
				
				$this->di->set( 'viewCache', function() use( $info ){
					$frontCache = new \Phalcon\Cache\Frontend\Base64(array( "lifetime" => intval( $info->cache_time * 60 ) ));
					$cache = new \Phalcon\Cache\Backend\Mongo($frontCache, $this->config[ 'mongodb' ] );
					return $cache;
				});
			break;
		}
		
		return true;	
		
	}
	
	/**
	 * 重新设置失效的页面缓存
	 * @param unknown $type
	 * @param unknown $name
	 * @param unknown $lefttime
	 */
	private function reSetPageDriver( $name )
	{
		if( false == $name )
			return false;
	
		$where = array(
				'column'	=> 'delsign,addtime,uptime,cname,cache_time,type,is_warm_up,module',
				'conditions'=> 'delsign=:del: and cname=:name: ',
				'bind'		=> array( 'del'=>SystemEnums::DELSIGN_NO, 'name'=> trim($name) ),
		);
		$res = PageCache::findFirst( $where );
		if( count( $res ) > 0 && false != $res )
		{
			$strCacheTime = intval( $res->cache_time * 60 );
			switch( $res->type )
			{
				case 2:
					$this->memCache->save( $res->cname , $res , $strCacheTime );
				break;
				case 1:
					$this->fileCache->save( $res->cname , $res, $strCacheTime  );
				break;
				case 3:
					$this->memory->save( $res->cname, $res , $strCacheTime );
				break;
				case 0:
					$this->apcCache->save( $res->cname, $res , $strCacheTime );
				break;
				case 5:
					$this->xcache->save( $res->cname, $res , $strCacheTime );
				break;
				case 4:
					$this->mongoCache->save( $res->cname, $res , $strCacheTime );
				break;
			}
			return $res;
		}
		else
			return false;
		
	}
	
	
}

?>
