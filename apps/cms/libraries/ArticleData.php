<?php

namespace apps\cms\libraries;

use Phalcon\DI\InjectionAwareInterface;
use enums\SystemEnums;
use apps\cms\models\Articles;
use apps\cms\vos\ArticleVO;
use apps\cms\models\ArticleCats;
use apps\cms\vos\ArticleCateVO;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use apps\cms\models\Sensitive;

class ArticleData implements InjectionAwareInterface{
	
	/* (non-PHPdoc)
	 * @see \Phalcon\DI\InjectionAwareInterface::setDI()
	 */
	private $_di;
	private $index_cache_name 	= 'f_cms_index_articles_list_cache';
	private $list_cache_name	= 'f_cms_list_article_list_cache';
	private $detail_cache_name 	= 'f_cms_article_detail_cache';
	private $tags_cache_name	= 'f_cms_article_tags_cache';
	
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
	 * 获取最新新闻/文章动态
	 * @param int $limit  获取条数
	 * @return object
	 */
	public function getLatestArts( $cid = 0 , $limit = 6 )
	{
		//缓存设置信息
		$cache = new CacheMagCenter();
		$cacheData = $cache->getCacheConfigs( $this->index_cache_name );
		if( false != $cacheData )
			return CacheDataCenter::getLatesArtsDatas( $this->_di,  $cacheData, $limit , $cid );
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
	
			return  $list;
		}
	}
	
	/**
	 * 获取文章列表/某分类下文章列表
	 * @param int $catid  -- 文章分类id
	 * @return object
	 */
	public function getCateArticles( $catid, $page )
	{
		$cache = new CacheMagCenter();
		$cacheData = $cache->getCacheConfigs( $this->list_cache_name );
		if( false != $cacheData )
			return CacheDataCenter::getArticlesList( $this->_di , $cacheData, $page , $catid );
		else
		{
			if( false != $catid )
			{
				$where = array(
						'column'	=> 'id,delsign,addtime,uptime,title,description,cat_id,content,status,begin_time,end_time,top,author,keywords',
						'conditions'=> 'delsign=:del: and cat_id=:catid: ORDER BY top,uptime DESC',
						'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'catid' => $catid ),
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
			return $pagination->getPaginate();
		}
	}

	/**
	 * 获取单篇文章
	 * @return object
	 */
	public function getSingleArticle( $id )
	{
		if( false == $id )
			return false;
		
		$cache = new CacheMagCenter();
		$cacheData = $cache->getCacheConfigs( $this->detail_cache_name );
		if( false != $cacheData )
			return CacheDataCenter::getSingleArticle( $this->_di , $cacheData, $id );
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
			
				return $res;
			} 
		}
	}
	
	/**
	 * 通过文章 获取该文章分类信息
	 * @param int $aid  -- 文章id
	 * @return object
	 */
	public function getCateInfo( $cid )
	{
		if( false == $cid )
			return false;
		
		$where = array(
				'column'	=> 'id,addtime,uptime,delsign,descr,name,title,keywords,type,description,nofollow,img,parent_id',
				'conditions'=> 'delsign=:del: and id=:cid:',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'cid' => $cid ),
		);
		$category = ArticleCats::findFirst( $where );
		if( count( $category ) > 0 && false != $category )
		{
			//设置 文章分类 vo
			$vo = new ArticleCateVO();
			$vo->setData( $category );
			
			return $category;
		}
		else
			return false;
			
	}
	
	/**
	 * 某分类下的新闻列表
	 * @param int $cid
	 * @return object
	 */
	public function getCatAndArtList( $catid, $limit=false )
	{
		if( false != $limit && false != $catid )
			$where = array(
				'column'	=> 'id,addtime,uptime,delsign,descr,name,title,keywords,type,description,nofollow,img,parent_id',
				'conditions'=> 'delsign=:del: and id=:cid: ORDER BY uptime DESC LIMIT ' . $limit,
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'cid' => $catid  ),
			);
		else if( false !=  $catid )
			$where = array(
				'column'	=> 'id,addtime,uptime,delsign,descr,name,title,keywords,type,description,nofollow,img,parent_id',
				'conditions'=> 'delsign=:del: and id=:cid: ORDER BY uptime DESC',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'cid' => $catid ),
			);
		else 
		    $where = array(
		                    'column'	=> 'id,addtime,uptime,delsign,descr,name,title,keywords,type,description,nofollow,img,parent_id',
		                    'conditions'=> 'delsign=:del: ORDER BY uptime DESC',
		                    'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
		    );
		
		$catinfo = ArticleCats::findFirst( $where );
		if( count( $catinfo ) > 0 && false != $catinfo )
		{
		    $arrResult[ 'cateinfo' ] = $catinfo;
			//设置 文章分类 vo
			$cvo = new ArticleCateVO();
			$cvo->setData( $catinfo );
			
			//设置 文章 vo
			$where = array(
				'column'    => 'id,cat_id,addtime,uptime,title',
			    'conditions'=> 'delsign=:del:',
			    'bind'      => array( 'del' => SystemEnums::DELSIGN_NO ),
			    'limit'     => 5,
			);
			$artList = $catinfo->getArticlelist( $where );
			if( count( $artList ) > 0 && false != $artList )
			{
			    $arrResult[ 'artlist' ] = $artList;
			    
				$avo = new ArticleVO();
				foreach( $artList as $row )
				{		
					$avo->setData( $row );
				}
			}
			
			return $arrResult;
		}
		else 
		   return false;
	}
	
	
	/**
	 * 提取文章tags
	 * @param int $aid -- 文章id
	 * @return object
	 */
	public function getArticleTags( $aid )
	{
		if( false == $aid )
			return false;
	
		$cache = new CacheMagCenter();
		$cacheData = $cache->getCacheConfigs( $this->tags_cache_name );
		
		return CacheDataCenter::getArticleTags( $this->_di, $cacheData , $aid );
	}
	
	/**
	 * 获取文章下图片列表
	 * @param int $aid  -- 文章id
	 * @return boolean
	 */
	public function getArticlePics( $aid )
	{
		if( false == $aid )
			return false;
	
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
					$url = '/cms/index/list';
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