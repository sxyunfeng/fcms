<?php
/**
 * 缓存数据分发中心
 * @author Carey
 * @date 2015-11-04
 */
namespace apps\admin\libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Controller;
use enums\SystemEnums;
use apps\admin\models\MenuCategory;
use apps\admin\models\Menu;
use apps\admin\vos\MenuVO;
use apps\admin\models\SiteSetting;
use apps\admin\vos\SitesVo;
use apps\admin\models\Articles;
use apps\admin\vos\ArticleVO;
use apps\admin\models\FriendLinks;
use apps\admin\vos\FriendLinkVO;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use apps\admin\models\Ad;
use apps\admin\vos\AdsVo;
use apps\admin\models\Sensitive;
use apps\admin\models\ArticleTags;
use apps\admin\vos\TagsVo;


class CacheDataCenter extends Controller{
	
	
	/**
	 * 获取站点配置信息
	 * @param unknown $type
	 * @param unknown $name
	 * @param unknown $lefttime
	 */
	public static function getSiteDatas( $di, $cacheInfo )
	{
		if( false == $cacheInfo )
			return false;
		
		$name = $cacheInfo->ename;
		$lefttime = intval( $cacheInfo->cache_time * 60 );
		$type = $cacheInfo->type;
	
		if( false == $type || false == $name )
			return  false;
	
		switch( $type )
		{
			case 0:
				$driver = $di['memCache'];
			break;
			case 1:
				$driver = $di['redisCache'];
			break;
			case 2:
				$driver = $di['mongodb'];
			break;
			case 3:
				$driver = $di['fileCache'];
			break;
			case 4:
				$driver = $di['memCached'];
			break;
			case 5:
				$driver = $di['apcCache'];
			break;
			case 6:
				$driver = $di['xcache'];
			break;
			case 7:
				$driver = $di['mongoCache'];
			break;
		}
	
		if( false == $driver )
			return false;
	
		if( $driver->exists( $name ) )
			return $driver->get( $name );
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
			$driver->save( $name , $site , $lefttime );
			return $site;
		}
	}
	
	/**
	 * 获取菜单导航缓存
	 * @param unknown $type
	 * @param unknown $name
	 * @param unknown $lefttime
	 */
	public static function getMenusDatas( $di, $cacheInfo )
	{
		if( false == $cacheInfo )
			return false;
		
		$name = $cacheInfo->ename;
		$lefttime = intval( $cacheInfo->cache_time * 60 );
		$type = $cacheInfo->type;
		
		if( false == $type || false == $name )
			return  false;
	
		switch( $type )
		{
			case 0:
				$driver = $di['memCache'];
			break;
			case 1:
				$driver = $di['redisCache'];
			break;
			case 2:
				$driver = $di['mongodb'];
			break;
			case 3:
				$driver = $di['fileCache'];
			break;
			case 4:
				$driver = $di['memCached'];
			break;
			case 5:
				$driver = $di['apcCache'];
			break;
			case 6:
				$driver = $di['xcache'];
			break;
			case 7:
				$driver = $di['mongoCache'];
			break;
		}
	
		if( false == $driver )
			return false;
	
		if( $driver->exists( $name ) )
			return $driver->get( $name );
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
						
					$driver->save( $name,  $arrMenus, $lefttime );
						
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
	 * 获取文章缓存数据 -- 首页最新动态文章
	 * @param unknown $type
	 * @param unknown $name
	 * @param unknown $lefttime
	 */
	public static function getLatesArtsDatas( $di, $cacheInfo , $limit, $cid )
	{
		if( false == $cacheInfo )
			return false;
		
		$name = $cacheInfo->ename;
		$lefttime = intval( $cacheInfo->cache_time * 60 );
		$type = $cacheInfo->type;
		
		if( false == $type || false == $name )
			return  false;
	
		switch( $type )
		{
			case 0:
				$driver = $di['memCache'];
			break;
			case 1:
				$driver = $di['redisCache'];
			break;
			case 2:
				$driver = $di['mongodb'];
			break;
			case 3:
				$driver = $di['fileCache'];
			break;
			case 4:
				$driver = $di['memCached'];
			break;
			case 5:
				$driver = $di['apcCache'];
			break;
			case 6:
				$driver = $di['xcache'];
			break;
			case 7:
				$driver = $di['mongoCache'];
			break;
		}
	
		if( false == $driver )
			return false;
	
		if( $driver->exists( $name . '_article_category_' . $cid ) )
			return $driver->get( $name . '_article_category_' . $cid );
		else if( $driver->exists( $name ) )
			return $driver->get( $name  );
		else
		{
			if( false == $cid )
				$where = array(
						'column'	=> 'id,delsign,addtime,uptime,title,description,cat_id,content,status,begin_time,end_time,top,author,keywords',
						'conditions'=> 'delsign=:del: and top=:top: ORDER BY uptime DESC LIMIT ' . $limit ,
						'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'top' => 1 ),
				);
			else 
				$where = array(
						'column'	=> 'id,delsign,addtime,uptime,title,description,cat_id,content,status,begin_time,end_time,top,author,keywords',
						'conditions'=> 'delsign=:del: and cat_id=:cid: ORDER BY top,uptime DESC LIMIT ' . $limit ,
						'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'cid' => $cid ),
				);
				
			$list = Articles::find( $where );
			if( count( $list )  > 0 )
			{
				$vo = new ArticleVO(); //设置文章 vo
				foreach ( $list as $row )
				{
					$row->description = mb_substr( $row->description , 0 , 10, 'UTF-8' );
					$vo->setData( $row );
				}
			}
			
			if( false != $cid )
				$driver->save( $name . '_article_category_' . $cid , $list, $lefttime );
			else 
				$driver->save( $name, $list, $lefttime );
				
			return  $list;
		}
	}
	
	/**
	 * 获取友情链接数据
	 * @param unknown $di
	 * @param unknown $cacheInfo
	 * @return boolean|\Phalcon\Mvc\Model\ResultsetInterface
	 */
	public static function getFriendLinkData( $di , $cacheInfo )
	{
		if( false == $cacheInfo )
			return false;
		
		$name = $cacheInfo->ename;
		$lefttime = intval( $cacheInfo->cache_time * 60 );
		$type = $cacheInfo->type;
		
		if( false == $type || false == $name )
			return  false;
		
		switch( $type )
		{
			case 0:
				$driver = $di['memCache'];
			break;
			case 1:
				$driver = $di['redisCache'];
			break;
			case 2:
				$driver = $di['mongodb'];
			break;
			case 3:
				$driver = $di['fileCache'];
			break;
			case 4:
				$driver = $di['memCached'];
			break;
			case 5:
				$driver = $di['apcCache'];
			break;
			case 6:
				$driver = $di['xcache'];
			break;
			case 7:
				$driver = $di['mongoCache'];
			break;
		}
		
		if( false == $driver )
			return false;
		
		if( $driver->exists( $name ) )
			return $driver->get( $name );
		else
		{
			
			$where = array(
					'column'	=> 'id,delsign,uptime,addtime,name,title,nofollow,target,logo,url,sort',
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
			
			$driver->save( $name, $res, $lefttime );
		
			return  $res;
		}
	}
	
	
	/**
	 * 获取单条广告信息
	 * @param unknown $di
	 * @param unknown $cacheInfo
	 * @param unknown $id
	 * @return void|boolean|\Phalcon\Mvc\Model
	 */
	public static function getAdDetail( $di , $cacheInfo , $id )
	{
		if( false == $cacheInfo || false == $id )
			return false;
	
		$name = $cacheInfo->ename;
		$lefttime = intval( $cacheInfo->cache_time * 60 );
		$type = $cacheInfo->type;
	
		if( false == $type || false == $name )
			return  false;
	
		switch( $type )
		{
			case 0:
				$driver = $di['memCache'];
			break;
			case 1:
				$driver = $di['redisCache'];
			break;
			case 2:
				$driver = $di['mongodb'];
			break;
			case 3:
				$driver = $di['fileCache'];
			break;
			case 4:
				$driver = $di['memCached'];
			break;
			case 5:
				$driver = $di['apcCache'];
			break;
			case 6:
				$driver = $di['xcache'];
			break;
			case 7:
				$driver = $di['mongoCache'];
			break;
		}
	
		if( false == $driver )
			return false;
	
		if( $driver->exists( $name ) )
			return $driver->get( $name );
		else
		{
			$where = array(
					'column'	=> 'id,delsign,addtime,uptime,media_type,name,url,begin_time,end_time,click_count,enabled,cat_id,sort_order,title,click_left,weight,cid,src,shopid,nofollow',
					'conditions'=> 'delsign=:del: and enabled=:abled: and id=:optid: ORDER BY sort_order DESC',
					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'abled' => 1 , 'optid' => $id ),
			);
			$ad = Ad::findFirst( $where );
			if( count( $ad ) > 0 && false != $ad )
			{
				//设置广告 vo
				$vo = new AdsVo();
				$vo->setData( $ad );
			}
				
			$driver->save( $name, $ad , $lefttime );
			return $ad;
		}
	}
	
	

	/**
	 * 获取文章列表/指定分类下的文章列表
	 * @param unknown $di
	 * @param unknown $cacheInfo
	 * @param unknown $cid
	 * @return boolean|\Phalcon\Paginator\Adapter\stdClass
	 */
	public static function getArticlesList( $di, $cacheInfo, $page, $cid = false )
	{
		if( false == $cacheInfo )
			return false;
		
		$name = $cacheInfo->ename;
		$lefttime = intval( $cacheInfo->cache_time * 60 );
		$type = $cacheInfo->type;
		
		if( false == $type || false == $name )
			return  false;
		
		switch( $type )
		{
			case 0:
				$driver = $di['memCache'];
			break;
			case 1:
				$driver = $di['redisCache'];
			break;
			case 2:
				$driver = $di['mongodb'];
			break;
			case 3:
				$driver = $di['fileCache'];
			break;
			case 4:
				$driver = $di['memCached'];
			break;
			case 5:
				$driver = $di['apcCache'];
			break;
			case 6:
				$driver = $di['xcache'];
			break;
			case 7:
				$driver = $di['mongoCache'];
			break;
		}
		
		if( false == $driver )
			return false;
		
		if( $driver->exists( $name . '_article_list_page_' . $page . '_catgory_' . $cid ) )
			return $driver->get( $name . '_article_list_page_' . $page . '_catgory_' . $cid  );
		else
		{
				
			if( false != $cid )
			{
				$where = array(
						'column'	=> 'id,delsign,addtime,uptime,title,description,cat_id,content,status,begin_time,end_time,top,author,keywords',
						'conditions'=> 'delsign=:del: and cat_id=:catid: ORDER BY top,uptime DESC',
						'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'catid' => $cid ),
				);
			}
			else
			{
				$where = array(
						'column'	=> 'id,delsign,addtime,uptime,title,description,cat_id,content,status,begin_time,end_time,top,author,keywords',
						'conditions'=> 'delsign=:del: ORDER BY top,uptime DESC',
						'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
				);
			}
			$list = Articles::find( $where );
			if( count( $list ) > 0 && false != $list )
			{
				$vo = new ArticleVO();
				foreach( $list as $row )
				{
					$vo->setData( $vo );
				}
			}
			$pagination = new PaginatorModel( array(
					'data'  => $list,
					'limit' => 10,
					'page'  => $page
			));
				
			$driver->save( $name . '_article_list_page_' . $page . '_catgory_' . $cid , $pagination->getPaginate(), $lefttime );
			
			return $pagination->getPaginate();
		}
		
	}
	
	/**
	 * 获取单条文章信息
	 * @param unknown $di
	 * @param unknown $cacheInfo
	 * @param unknown $id
	 * @return boolean|\Phalcon\Mvc\Model
	 */
	public static function getSingleArticle( $di , $cacheInfo , $id )
	{
		if( false == $cacheInfo || false == $id )
			return false;
		
		$name = $cacheInfo->ename;
		$lefttime = intval( $cacheInfo->cache_time * 60 );
		$type = $cacheInfo->type;
		
		if( false == $type || false == $name )
			return  false;
		
		switch( $type )
		{
			case 0:
				$driver = $di['memCache'];
			break;
			case 1:
				$driver = $di['redisCache'];
			break;
			case 2:
				$driver = $di['mongodb'];
			break;
			case 3:
				$driver = $di['fileCache'];
			break;
			case 4:
				$driver = $di['memCached'];
			break;
			case 5:
				$driver = $di['apcCache'];
			break;
			case 6:
				$driver = $di['xcache'];
			break;
			case 7:
				$driver = $di['mongoCache'];
			break;
		}
		
		if( false == $driver )
			return false;
		
		if( $driver->exists( $name . '_sign_' . $id  ) )
			return $driver->get( $name . '_sign_' . $id  );
		else
		{
			$where = array(
					'column'	=> 'id,delsign,addtime,uptime,title,description,cat_id,content,status,begin_time,end_time,top,author,keywords',
					'conditions'=> 'delsign=:del: and id=:optid:',
					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $id ),
			);
			$res = Articles::findFirst( $where );
			if( false != $res && count( $res ) > 0 )
			{
				$vo = new ArticleVO(); //设置文章 vo
				$vo->setData( $res );
					
				$arrFind = array();
				$arrRepalce = array();
				$senWhere = array(
						'column'	=> 'id,delsign,uptime,word,rword',
						'conditions'=> 'delsign=:del:',
						'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
				);
				$senWord = Sensitive::find( $senWhere );
				if( count( $senWord ) > 0 )
				{
					foreach( $senWord as $row )
					{
						array_push( $arrFind , trim( $row->word ) );
						array_push( $arrRepalce , $row->rword?$row->rword:$this->_di[ 'config' ][ 'sensitive_default_replace' ] );
					}
				}
				if( !empty( $arrFind ) && !empty( $arrRepalce ) )
					$res->content = str_replace( $arrFind , $arrRepalce, $res->content );
			
				
				$driver->save( $name . '_sign_' . $id , $res , $lefttime );
				return $res;
			}
		}
	}
	
	/**
	 * 获取单条文章的tags
	 * @param unknown $di
	 * @param unknown $cacheInfo
	 * @param unknown $aid
	 * @return boolean|\Phalcon\Mvc\Model\ResultsetInterface
	 */
	public static function getArticleTags( $di , $cacheInfo , $aid )
	{
		if( false == $cacheInfo || false == $aid )
			return false;
		
		$name = $cacheInfo->ename;
		$lefttime = intval( $cacheInfo->cache_time * 60 );
		$type = $cacheInfo->type;
		
		if( false == $type || false == $name )
			return  false;
		
		switch( $type )
		{
			case 0:
				$driver = $di['memCache'];
			break;
			case 1:
				$driver = $di['redisCache'];
			break;
			case 2:
				$driver = $di['mongodb'];
			break;
			case 3:
				$driver = $di['fileCache'];
			break;
			case 4:
				$driver = $di['memCached'];
			break;
			case 5:
				$driver = $di['apcCache'];
			break;
			case 6:
				$driver = $di['xcache'];
			break;
			case 7:
				$driver = $di['mongoCache'];
			break;
		}
		
		if( false == $driver )
			return false;
		
		if( $driver->exists( $name . '_article_' . $aid ) )
			return $driver->get( $name . '_article_' . $aid );
		else
		{
			$where = array(
					'column'	=> 'id,delsign,addtime,uptime,name,display,linkurl,aid,sort',
					'conditions'=> 'delsign=:del: and display=:dis: and aid=:articleid: ORDER BY sort DESC',
					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'dis' => 0 , 'articleid' => $aid ),
			);
			$tags = ArticleTags::find( $where );
			if( count( $tags ) > 0 && false != $tags )
			{
				$vo = new TagsVo();//设置tag vo
				$vo->setData( $tags );
			}
			$driver->save( $name . '_article_' . $aid , $tags , $lefttime );
			return $tags;
		}
	}
	
	
}

?>
