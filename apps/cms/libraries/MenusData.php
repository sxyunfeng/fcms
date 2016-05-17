<?php

namespace apps\cms\libraries;

use Phalcon\DI\InjectionAwareInterface;
use enums\SystemEnums;
use apps\cms\models\MenuCategory;
use apps\cms\models\Menu;
use apps\cms\vos\MenuVO;

class MenusData implements InjectionAwareInterface{
	
	/* (non-PHPdoc)
	 * @see \Phalcon\DI\InjectionAwareInterface::setDI()
	 */
	private $_di;
	private $cache_name = 'f_cms_menu_info_cache';
	
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
	 * 获取首页导航
	 * @return array
	 */
	public function getMenus()
	{
		//缓存设置信息
		$cache = new CacheMagCenter();
		$cacheData = $cache->getCacheConfigs( $this->cache_name );
		if( false != $cacheData )
			return CacheDataCenter::getMenusDatas( $this->_di, $cacheData );
		else
		{
			//主导航
			$arrMenus = array();
			$where = array(
					'column'	=> 'id,delsign,is_main',
					'conditions'=> 'delsign=:del: and is_main=:main:',
					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'main' => 0 ),
			);
			$menuCate = MenuCategory::findFirst( $where );
			if( count( $menuCate ) > 0 && false != $menuCate )
			{//存在主导航
			$arrWhere = array(
					'column'	=> 'id,delsign,pid,cid,name,url,relid,target,is_show',
					'conditions'=> 'delsign=:del: and cid=:cateid: and is_show=:show: ORDER BY pid ASC,sort DESC,uptime ASC',
					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'cateid' => $menuCate->id, 'show' => 0 ),
			);
			$menu = Menu::find( $arrWhere );
			if( count( $menu ) > 0 )
			{//存在菜单项
			$vo = new MenuVO(); //设置菜单vo
			foreach( $menu as $row )
			{
				$arrAlias = array( 'id' => $row->id, 'delsign' => $row->delsign, 'pid' => $row->pid, 'cid' => $row->cid, 'name' => $row->name, 'url' => $row->url, 'relid' => $row->relid, 'target' => $row->target, 'is_show' => $row->is_show );
				if( 0 == $row->pid )
				{
					$vo->setData( $row );
					if( 0 == $row->target && false != $row->url )
					{
					    $iStatr = strrpos( $row->url , '/' );
					    $arrAlias[ 'relartid' ] = mb_substr( $row->url , intval( $iStatr + 1 ) , strlen( $row->url ) , 'UTF8' );
					}
					array_push( $arrMenus, $arrAlias );
				}
				else
				{
					$i = 0;
					foreach( $arrMenus as $item )
					{
						if( $item['id'] == $row->pid )
						{
						    $iStatr = strrpos( $row->url , '/' );
							$arrAlias[ 'relartid' ] = mb_substr( $row->url , intval( $iStatr + 1 ) , strlen( $row->url ) , 'UTF8' );
							$arrMenus[$i]['children'][] = $arrAlias;
							$vo->setData( $row );
						}
						$i++;
					}
				}
				unset( $arrAlias );
			}
			return $arrMenus;
			}
			else
				return false;
			}
			else
				return false;
		}
	}
	
	
	/**
	 * 获取 url跳转链接
	 * @param string $type  类型
	 * @param number $catid 分类id
	 * @return string $url 当前链接地址
	 */
	public function getListLink( $type=false, $id=0 )
	{
		switch ( $type )
		{
			case 'artcate':
				if( false != $id )
					$url = '/cms/index/list/cid/' . $id ;
				else
					$url = 'http://' . $_SERVER[ 'HTTP_HOST' ];
			break;
			case 'article':
				if( false != $id )
					$url = '/cms/index/detail/id/' . $id ;
				else
					$url = 'http://' . $_SERVER[ 'HTTP_HOST' ];
			break;
			default:
				$url = 'http://' . $_SERVER[ 'HTTP_HOST' ];
			break;
		}
	
		return $url;
	}
	
}

?>