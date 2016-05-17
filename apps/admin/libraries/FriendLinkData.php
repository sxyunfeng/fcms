<?php

namespace apps\admin\libraries;

use Phalcon\DI\InjectionAwareInterface;
use enums\SystemEnums;
use apps\admin\models\FriendLinks;
use apps\admin\vos\FriendLinkVO;

class FriendLinkData implements InjectionAwareInterface{

	/* (non-PHPdoc)
	 * @see \Phalcon\DI\InjectionAwareInterface::setDI()
	*/
	private $_di;
	private $cache_friendlink = 'f_cms_friendlink_cache';
	
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
	 * 获取友情链接
	 * @return object
	 */
	public function getFriendLink()
	{
		//缓存设置信息
		$cache = new CacheMagCenter();
		$cacheData = $cache->getCacheConfigs( $this->cache_friendlink );
		if( false != $cacheData )
			return CacheDataCenter::getFriendLinkData( $this->_di , $cacheData );
		else
		{
			$where = array(
					'columns'	=> 'id,delsign,uptime,addtime,name,title,nofollow,icon,url,sort,target',
					'conditions'=> 'delsign=:del: ORDER BY sort,uptime DESC',
					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
			);
			$res = FriendLinks::find( $where );
			if( count( $res ) > 0 && false != $res )
			{
				$vo = new FriendLinkVO();//设置友链 vo
				foreach( $res as $row )
				{
					$vo->setData( $row );
				}
			}
			return  $res;
		}
	}
}
?>