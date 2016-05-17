<?php

namespace apps\cms\libraries;

use Phalcon\DI\InjectionAwareInterface;
use enums\SystemEnums;
use apps\cms\models\SiteSetting;
use apps\cms\vos\SitesVo;

class SitesData implements InjectionAwareInterface{
	
	/* (non-PHPdoc)
	 * @see \Phalcon\DI\InjectionAwareInterface::setDI()
	 */
	private $_di;
	private $cname = 'f_cms_site_info_cache';
	
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
	 *  获取网站配置信息
	 *  @return object
	 */
	public function getWebSiteInfo()
	{
		
		//缓存设置信息
		$cache = new CacheMagCenter();
		$cacheData = $cache->getCacheConfigs( $this->cname );
		if( false != $cacheData )
			return CacheDataCenter::getSiteDatas( $this->_di, $cacheData );
		else 
		{
			$where = array(
					'column'	=> 'id,delsign,addtime,uptime,name,domain,logo,seokey,seodescr,copyright,static_code,is_main',
					'conditions'=> 'delsign=:del: and is_main=:main: ORDER BY uptime DESC',
					'bind'		=> array( 'del'=> SystemEnums::DELSIGN_NO, 'main' => 0 ),
			);
			$site = SiteSetting::findFirst( $where );
			if( count( $site ) > 0 && false != $site )
			{
				$vo = new SitesVo();//设置站点信息 vo
				$vo->setData( $site );
			}
			return $site;
		}
		
	}
}
?>