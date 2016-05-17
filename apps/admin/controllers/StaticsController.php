<?php
namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\SystemEnums;
use apps\admin\enums\CachecfgEnums;
use apps\admin\models\StaticCache;
use libraries\FileUtils;
use apps\admin\models\Articles;
use apps\admin\models\ArticleCats;

/**
 * 全站静态化中心
 * @author Carey
 * @date( 2015-11-07 )
 */
class StaticsController  extends  AdminBaseController{
	
	
	public function initialze()
	{
		parent::initialize();
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-11-10' )
	 * @comment( comment = '静态化文章' )
	 * @method( method = 'artStaticAction' )
	 * @op( op = 'r' )
	 */
	public function artStaticAction()
	{
		$objRet = new \stdClass();
		
		$artid = $this->dispatcher->getParam( 'aid' );
		if( false == $artid )
		{
			$objRet->state = 1;
			$objRet->msg = '参数配置错误,程序运行被终止...';
			echo json_encode( $objRet );
			exit;
		}
		
		$where = array(
			'column'	=> 'id,delsign,uptime,status',
			'conditions'=> 'delsign=:del: and id=:sign:',
			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'sign' => $artid ),
		);
		$artInfo = Articles::find( $where );
		if( false == $artInfo || count( $artInfo ) <= 0 )
		{
			$objRet->state = 1;
			$objRet->msg  = '对不起,操作失败,信息未找到,请刷新后再试...';
			
			echo json_encode( $objRet );
			exit;
		}
		
		$where = array(
			'column'	=> 'id,delsign,name,cache_time,type,cfgtype,prefix',
			'conditions'=> 'delsign=:del: and cfgtype=:cfgtype:',
			'bind'		=> array( 'del'=> SystemEnums::DELSIGN_NO, 'cfgtype' => CachecfgEnums::STATIC_TYPE_DETAIL ),
		);
		$res = StaticCache::find( $where );
		if( false != $res && count( $res ) > 0 )
		{
			foreach( $res as $row )
			{
				if( 1 == $row->type )
				{//file
					$this->_optDirectory( $row->prefix );
					$state = $this->_staticStart( $artid, $row );
					if( false != $state )
					{
						$objRet->state = 0;
						$objRet->msg = '静态化成功...';
					}
					else
					{ 
						$objRet->state = 1;
						$objRet->msg = '对不起，静态化操作失败.请稍后重试...';
					}
				}
				else
				{//memcache
					
				}
			}	
		}
		else 
		{
			$objRet->state = 1;
			$objRet->msg = '对不起，操作失败,数据未找到.';
		}
		
		echo json_encode( $objRet );
	}
	
	/**
	 * 创建对应的  module/controller/action
	 * @param unknown $prefix
	 * @return boolean
	 */
	private function _optDirectory( $prefix )
	{
		$path = APP_ROOT . 'public/static/';
		if( false == $prefix )
			return false;
		
		$arrPre = array_filter( explode( '/' , $prefix ) );
		if( count( $arrPre ) > 0 )
		{
			$iLen = count( $arrPre );
			for( $i=1; $i<=$iLen; $i++)
			{
				if( 1 == $i )
				{
					if( false == file_exists( $path . $arrPre[$i] ) )
						FileUtils::mkdir( $path , $arrPre[$i] );
				}
				else
				{
					$path .= $arrPre[$i-1] . '/';
					if( is_dir( $path ) && !file_exists( $path . $arrPre[$i] ) )
						FileUtils::mkdir( $path , $arrPre[$i] );
				}
			}
		}
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-11-09' )
	 * @comment( comment = '继续静态化' )
	 * @method( method = 'indexAction' )
	 * @op( op = 'r' )
	 */
	public function partAction()
	{
		$objRet = new \stdClass();
		//继续静态化 - 详细页
		$where = array(
			'column'	=> 'id,delsign,name,cache_time,type,cfgtype,prefix',
			'conditions'=> 'delsign=:del: and cfgtype=:cfgtype:',
			'bind'		=> array( 'del'=> SystemEnums::DELSIGN_NO, 'cfgtype' => CachecfgEnums::STATIC_TYPE_DETAIL ),
		);
		$detail = StaticCache::find( $where );
		if( count( $detail ) > 0 )
		{
			foreach( $detail as $row )
			{
				if( 1 == $row->type )
				{//file
					$basePath = APP_ROOT . 'public/static';
					$artIds = $this->_getIsStaticIds( $basePath ,  $row->prefix );
					if( count( $artIds ) > 0 )
					{//存在静态化文件
						$strIds = implode( ',' , $artIds );
							$artWhere = array(
									'column'	=> 'id,delsign,status',
									'conditions'=> 'delsign=:del: and id NOT IN('.$strIds.')',
									'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
							);
						}
						else
						{//没有静态化文件
							$artWhere = array(
									'column'	=> 'id,delsign,status',
									'conditions'=> 'delsign=:del:',
									'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
							);
						}
						$res = Articles::find( $artWhere );
						if( false != $res && count( $res ) > 0 )
						{
							foreach( $res as $art )
							{
								$this->_staticStart( $art->id , $row  );
							}
						}
				}
				else
				{//memcache
					
				}
			}
		}
	
		//继续静态化 - 列表页
		$where = array(
				'column'	=> 'id,delsign,name,cache_time,type,cfgtype,prefix',
				'conditions'=> 'delsign=:del: and cfgtype=:cfgtype:',
				'bind'		=> array( 'del'=> SystemEnums::DELSIGN_NO, 'cfgtype' => CachecfgEnums::STATIC_TYPE_LISR ),
		);
		$list = StaticCache::find( $where );
		if( false != $list &&  count( $list ) > 0 )
		{
			foreach( $list as $row )
			{
				if( 1 == $row->type )
				{//file
					$basePath = APP_ROOT . 'public/static';
					$artIds = $this->_getIsStaticIds( $basePath ,  $row->prefix , 'list' );
					$strIds = implode( ',' , $artIds );
					if( false != $strIds )
					{//存在静态化文件
						$artWhere = array(
							'column'	=> 'id,delsign,status',
							'conditions'=> 'delsign=:del: and id NOT IN('.$strIds.')',
							'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
						);
					}
					else
					{//没有静态化文件
						$artWhere = array(
							'column'	=> 'id,delsign,status',
							'conditions'=> 'delsign=:del:',
							'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
						);
					}
					$res = ArticleCats::find( $artWhere );//文章分类
					if( false != $res && count( $res ) > 0 )
					{
						foreach( $res as $cat )
						{
							//分页
							$strUri = $row->prefix .'/'. $cat->id.'/page';
							$this->_optDirectory( $strUri );
							
							$this->_staticStart( $cat->id , $row , $row->prefix ); //不存在分页
							
							$artList = $cat->getArticlelist();//某分类下所有文章
							if( false != $artList && count( $artList ) > 0 )
							{
								$iLen = count( $artList );
								$page = 1;
								for( $i = 1; $i<=$iLen; $i+=10 )
								{
									$this->_staticStart( $page , $row , $strUri );
									$page++;
								}
							}
							unset( $cat );
						}
					}
				}
				else 
				{//memcache
					
				}
			}
		}
		//继续静态化 -- 主页
		$where = array(
				'column'	=> 'id,delsign,name,cache_time,type,cfgtype,prefix',
				'conditions'=> 'delsign=:del: and cfgtype=:cfgtype:',
				'bind'		=> array( 'del'=> SystemEnums::DELSIGN_NO, 'cfgtype' => CachecfgEnums::STATIC_TYPE_COLUMN ),
		);
		$detail = StaticCache::find( $where );
		if( count( $detail ) > 0 )
		{
			foreach( $detail as $row )
			{
				if( 1 == $row->type )
				{//file
					$basePath = APP_ROOT . 'public/static';
					if( !file_exists(  $basePath . $row->prefix . '/index.html' ) )
					{//没有静态化文件
						$this->_optDirectory( $row->prefix );
					}
					
					$this->_staticStart( false, $row , $row->prefix );
				}
				else
				{//memcache
						
				}
			}
		}
		
		$objRet->state = 0;
		$objRet->msg = '继续静态化已完成...';
		
		echo json_encode( $objRet );
	}
	
	/**
	 * 获取已静态化文章id
	 * @param unknown $path
	 * @return boolean|multitype:
	 */
	private function _getIsStaticIds( $basepath, $path , $type = false )
	{
		if( false == is_dir( $basepath . $path ) )
			$this->_optDirectory( $path  );
		
		$files = scandir( $basepath . $path );
		$ids = array();
		foreach( $files as $file )
		{
			if( !is_dir( $file ) && '.' != $file && '..' != $file )
			{
				if( false != $type && 'list' == $type )
					array_push( $ids , basename( $file , '.html' ) );
				else 
				{
					$iPoint = stripos( $file , '.' );
					array_push( $ids , mb_substr( $file , 0 , $iPoint , 'UTF8' ) );
				}
			}
		}
		
		return $ids;
	}
	
	
	/**
	 * 静态化业务
	 * @param unknown $id
	 * @param unknown $data
	 * @return boolean
	 */
	private function _staticStart( $id , $data , $strUri = false )
	{
		if( false == $data )
			return false;
		
		if( false != $strUri )//存在分页
			$strLocalpath  	=  APP_ROOT . 'public/static' . $strUri;
		else //没有分页
			$strLocalpath  	=  APP_ROOT . 'public/static' . $data->prefix . '/';
		
		if( false != $id && false != $strUri )//存在标识 并为分页
			$url = 'http://' . $_SERVER[ 'HTTP_HOST' ] .  $strUri . '/' . $id;
		else if( false != $id )//详细页
			$url = 'http://' . $_SERVER[ 'HTTP_HOST' ] .  $data->prefix . '/' . $id;
		else//主页
			$url = 'http://' . $_SERVER[ 'HTTP_HOST' ] .  $data->prefix;
		
		$strNewContents = preg_replace( '/href(!:\\s)*=(!:\\s)*"([^"]*?)([0-9]+)(".*_fcms_static_)/', "href=\"/static$3$4.html$5",  file_get_contents( $url ) );
	
		if( false !=  $id )
			file_put_contents( $strLocalpath . '/' . $id . '.html' , $strNewContents );
		else 
		{
			file_put_contents( APP_ROOT.'public/index.html' , $strNewContents );
			file_put_contents( $strLocalpath.'/index.html' , $strNewContents );
		}
		
		return true;
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-11-09' )
	 * @comment( comment = '全站静态化' )
	 * @method( method = 'indexAction' )
	 * @op( op = 'r' )
	 */
	public function sitesAction()
	{
		$objRet = new \stdClass();
		// 静态化 - 主页
		$where = array(
				'column'	=> 'id,delsign,name,cache_time,type,cfgtype,prefix',
				'conditions'=> 'delsign=:del: and cfgtype=:cfgtype:',
				'bind'		=> array( 'del'=> SystemEnums::DELSIGN_NO, 'cfgtype' => CachecfgEnums::STATIC_TYPE_COLUMN ),
		);
		$detail = StaticCache::find( $where );
		if( count( $detail ) > 0 )
		{
			foreach( $detail as $row )
			{
				if( 1 == $row->type )
				{//file
					$basePath = APP_ROOT . 'public/static';
					if( !file_exists(  $basePath . $row->prefix . '/index.html' ) ) //没有静态化文件
						$this->_optDirectory( $row->prefix );
					
					$this->_staticStart( false, $row , $row->prefix );
				}
				else
				{//memcache
		
				}
			}
		}
		// 静态化 - 列表页
		$where = array(
				'column'	=> 'id,delsign,name,cache_time,type,cfgtype,prefix',
				'conditions'=> 'delsign=:del: and cfgtype=:cfgtype:',
				'bind'		=> array( 'del'=> SystemEnums::DELSIGN_NO, 'cfgtype' => CachecfgEnums::STATIC_TYPE_LISR ),
		);
		$list = StaticCache::find( $where );
		if( false != $list &&  count( $list ) > 0 )
		{
			foreach( $list as $row )
			{
				if( 1 == $row->type )
				{//file
					$artWhere = array(
							'column'	=> 'id,delsign,status',
							'conditions'=> 'delsign=:del:',
							'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
					);
					$res = ArticleCats::find( $artWhere );//文章分类
					if( false != $res && count( $res ) > 0 )
					{
						foreach( $res as $cat )
						{
							$strUri = $row->prefix .'/'. $cat->id.'/page';
							if( false == is_dir( $strUri ) )
								$this->_optDirectory( $strUri );
							
							$this->_staticStart( $cat->id , $row , $row->prefix ); //不存在分页
								
							$artList = $cat->getArticlelist();//某分类下所有文章
							if( false != $artList && count( $artList ) > 0 )
							{
								$iLen = count( $artList );
								$page = 1;
								for( $i = 1; $i<=$iLen; $i+=10 )
								{
									$this->_staticStart( $page , $row , $strUri );
									$page++;
								}
							}
							unset( $cat );
						}
					}
				}
				else
				{//memcache
						
				}
			}
		}
		// 静态化 - 详情页
		$where = array(
				'column'	=> 'id,delsign,name,cache_time,type,cfgtype,prefix',
				'conditions'=> 'delsign=:del: and cfgtype=:cfgtype:',
				'bind'		=> array( 'del'=> SystemEnums::DELSIGN_NO, 'cfgtype' => CachecfgEnums::STATIC_TYPE_DETAIL ),
		);
		$detail = StaticCache::find( $where );
		if( count( $detail ) > 0 )
		{
			foreach( $detail as $row )
			{
				if( 1 == $row->type )
				{//file
					$basePath = APP_ROOT . 'public/static';
					if( false == is_dir( $basePath . $row->prefix ) )
						$this->_optDirectory( $row->prefix );
					
					$artWhere = array(
						'column'	=> 'id,delsign,status',
						'conditions'=> 'delsign=:del:',
						'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
					);
					$res = Articles::find( $artWhere );
					if( false != $res && count( $res ) > 0 )
					{
						foreach( $res as $art )
						{
							$this->_staticStart( $art->id , $row  );
						}
					}
				}
				else
				{//memcache
						
				}
			}
		}
		$objRet->state = 0;
		$objRet->msg = '全站静态化已完成...';
		
		echo json_encode( $objRet );
	}
	
}

?>