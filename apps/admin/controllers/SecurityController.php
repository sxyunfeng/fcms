<?php

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\FileSecurity;
use enums\SystemEnums;
use enums\DBEnums;
use libraries\TimeUtils;
/**
 * 文件安全管理
 * @author Carey
 *
 */
class SecurityController extends AdminBaseController{
	
	private $categorys = array();
	private $arrFiles  = array();
	private $arrNames  = array();
	
	public function initialze()
	{
		parent::initialize();
	}
	
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.9.1' )
	 * @comment( comment = '文件安全管理主页' )
	 * @method( method = 'fileAction' )
	 * @op( op = 'r' )
	 */
	public function fileAction()
	{
		//正常文件个数
		$allfile = array(
				'conditions' => 'delsign = :del:',
				'bind'		 => array( 'del' => SystemEnums::DELSIGN_NO ),
		);
		$res = FileSecurity::find( $allfile );
		$this->view->allfiles  = count( $res );
			
		//正常文件个数
		$nom_num = array(
				'conditions' => 'delsign = :del: and status = :status: ',
				'bind'		 => array( 'del' => SystemEnums::DELSIGN_NO , 'status' => SystemEnums::STUATUS_NOEMAL ),
		);
		$res = FileSecurity::find( $nom_num );
		$this->view->normal = count( $res );
			
		//异常文件
		$unnom_num = array(
				'conditions' => 'delsign = :del: and status = :status:',
				'bind'		 => array( 'del' => SystemEnums::DELSIGN_NO , 'status' => SystemEnums::STUATUS_UNNOEMAL ),
		);
		$res = FileSecurity::find( $unnom_num );
		$this->view->abnormal = count( $res );
		
	}
	
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.9.1' )
	 * @comment( comment = '扫描全站点' )
	 * @method( method = 'scanWebSiteAction' )
	 * @op( op = 'r' )
	 */
	public function scanWebSiteAction()
	{
		$objRet = new \stdClass();
		$dirPath = $_SERVER['DOCUMENT_ROOT'];
		//调用递归循环所有文件
		$this->_loopFile( $dirPath );
		
		if( isset( $this->arrFiles ) && !empty( $this->arrFiles ) )
		{
			$this->_emptyTable();
			foreach( $this->arrFiles as $val )
			{
				$filName = substr( $val , strrpos( $val , '/' ) + 1 );
				
				if( !is_dir( $val ) && '.' != $filName && '..' != $filName )
				{
					//文件路径存在汉字
					$hashName =  md5_file( iconv('UTF-8','GB2312', $val ) );
						
					$arrInsert = array(
							'delsign' 	=> SystemEnums::DELSIGN_NO,
							'addtime'	=> TimeUtils::getFullTime(),
							'filename'	=> $filName,
							'hashname'	=> $hashName,
							'filepath'	=> $val,
					);
					$insSecurity  = new FileSecurity;
					$insSecurity->save( $arrInsert );
					
					if( count( $insSecurity ) > 0 && $insSecurity->id != 0 )
						unset( $arrInsert );
					else
					{
						$objRet->state = 1;
						$objRet->msg = '数据库操作失败';
					}
				}
				
			}
			
			$objRet->state = 0;
			$objRet->msg = '系统扫描成功......';

			//总扫描文件
			$allfile = array(
					'conditions' => 'delsign = :del:',
					'bind'		 => array( 'del' => SystemEnums::DELSIGN_NO ),
			);
			$res = FileSecurity::find( $allfile );
			$objRet->allfiles = count( $res );
			
			//正常文件个数
			$nom_num = array(
				'conditions' => 'delsign = :del: and status = :status: ',
				'bind'		 => array( 'del' => SystemEnums::DELSIGN_NO , 'status' => SystemEnums::STUATUS_NOEMAL ),
			);
			$res = FileSecurity::find( $nom_num );
			$objRet->normal = count( $res );
			
			//异常文件
			$unnom_num = array(
					'conditions' => 'delsign = :del: and status = :status:',
					'bind'		 => array( 'del' => SystemEnums::DELSIGN_NO , 'status' => SystemEnums::STUATUS_UNNOEMAL ),
			);
			$res = FileSecurity::find( $unnom_num );
			$objRet->abnormal = count( $res );
		}
		else
		{
			$objRet->state = 1;
			$objRet->msg = '系统扫描出错,请稍后再试...';
		}
		
		echo json_encode( $objRet );
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.9.1' )
	 * @comment( comment = '异常扫描文件' )
	 * @method( method = 'scanAbnormalAction' )
	 * @op( op = 'r' )
	 */
	public function scanAbnormalAction()
	{
		$objRet = new \stdClass();
		
		$arrHash = array();
		$dirPath = $_SERVER['DOCUMENT_ROOT'];
		$this->_loopFile( $dirPath );
		
		foreach( $this->arrFiles as $val )
		{
			$filName = substr( $val , strrpos( $val , '/' ) + 1 );
				
			if( !is_dir( $val ) && '.' != $filName && '..' != $filName )
			{
				array_push( $arrHash ,  md5_file(  iconv('UTF-8','GB2312', $val )  ) );
			}
		}
		
		
		$where = array(
				'conditions' => 'delsign = :del:',
				'bind'		 => array( 'del' => SystemEnums::DELSIGN_NO ),
		);
		$res = FileSecurity::find( $where );
		if( count( $res ) > 0 )
		{
			$arrID = array();
			foreach( $res as $row )
			{
				if( isset( $arrHash ) && !empty( $arrHash ) )
				{
					if( !in_array( $row->hashname, $arrHash ) )
					{
						array_push( $arrID , $row->id );
					}
				}
			}
				
			//更新数据库  存在异常文件
			if( count( $arrID ) > 0 )
			{
				if( count( $arrID ) > 1 )
				{
					$ids = implode( ',' , $arrID );
					$up_where = array(
						'conditions'	=> "delsign=:del: and id in ($ids)",
						'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO )
					);
					
				}
				else if( count( $arrID ) == 1 )
				{
					$up_where = array(
							'conditions'	=> "delsign=:del: and id=:optid:",
							'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO , 'optid' =>  $arrID[0] )
					);
				}
				
				$security = FileSecurity::find( $up_where );
				foreach( $security as $row )
				{
					$row->status = SystemEnums::STUATUS_UNNOEMAL;
					$row->uptime = TimeUtils::getFullTime();
					$row->save();
				}
				
				$objRet->state = 0;
				if( count( $security ) > 0 )
					$objRet->msg = '有文件存在异常,请及时处理';
				else
					$objRet->msg = '暂无异常文件,请放心使用..';	
					
				//返回异常文件总数
				$objRet->abnormal = count( $security );
				
				//正常文件个数
				$nom_num = array(
						'conditions' => 'delsign = :del: and status = :status: ',
						'bind'		 => array( 'del' => SystemEnums::DELSIGN_NO , 'status' => SystemEnums::STUATUS_NOEMAL ),
				);
				$res = FileSecurity::find( $nom_num );
				$objRet->normal = count( $res );
				
			}
			else
			{
				$objRet->state = 1;
				$objRet->msg = '暂无异常文件';
			}
		}
		else
		{//提示全盘扫描
			$objRet->state = 1;
			$objRet->msg = '请先进行全站扫描,然后再进行异常文件扫描';
		}
		
		echo json_encode( $objRet );
	}
	
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.9.2' )
	 * @comment( comment = '异常文件列表' )
	 * @method( method = 'abnomalListAction' )
	 * @op( op = 'r' )
	 */
	public function abnomalListAction()
	{
		//返回异常文件列表
		$select_where = array(
				'conditions'	=> 'delsign=:del: and status=:status:',
				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO , 'status' =>SystemEnums::STUATUS_UNNOEMAL )
		);
		$abnomal = FileSecurity::find( $select_where );
		if( count( $abnomal ) > 0 )
		{
			$res = $abnomal->toArray();
			$i = 0;
			foreach( $res as $row )
			{
				$res[$i][ 'formatpath' ] = mb_substr( $row[ 'filepath' ] , intval( strlen( $_SERVER[ 'DOCUMENT_ROOT' ] ) + 1 ) );
				$i++;
			}
		}
		
		$this->view->res = $res;
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.9.2' )
	 * @comment( comment = '处理异常文件' )
	 * @method( method = 'handleAction' )
	 * @op( op = 'd' )
	 */
	public function handleAction()
	{
		$objRet = new \stdClass();
		
		$sign = $this->dispatcher->getParam( 'id' );
		if( 0 == $sign )
		{//全部处理
			$upDataWhere = array(
				'conditions'	=> 'delsign=:del: and status=:status:',
				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'status' => SystemEnums::STUATUS_UNNOEMAL ),
			);
			$res = FileSecurity::find( $upDataWhere );
			if( count( $res ) > 0 )
			{
				foreach( $res as $row )
				{
					$row->status 	= SystemEnums::STUATUS_NOEMAL;
					$row->opttime 	= TimeUtils::getFullTime();
					$row->hashname	= md5_file( iconv('UTF-8','GB2312', $row->filepath ) );
					$row->save();
				}
				
				$objRet->state = 0;
				$objRet->type = 'all';
				$objRet->msg = '批量处理异常文件已完成..';
			}
			else
			{
				$objRet->state = 1;
				$objRet->msg = '对不起,暂无异常文件,请刷新后再试.';
			}
		}
		else
		{//单个处理
			$upDataWhere = array(
					'conditions'	=> 'delsign=:del: and id=:optid:',
					'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $sign ),
			);
			
			$res = FileSecurity::findFirst( $upDataWhere );
			if( count( $res ) > 0 )
			{
				$res->status 	= SystemEnums::STUATUS_NOEMAL;
				$res->opttime 	= TimeUtils::getFullTime();
				$res->hashname	= md5_file( iconv('UTF-8','GB2312', $res->filepath ) );
				$res->save();
				
				$objRet->state = 0;
				$objRet->type  = 'signle';
				$objRet->optid = $sign;
				$objRet->msg   = '该异常文件已处理...';
			}
			else
			{
				$objRet->state = 1;
				$objRet->msg = '对不起,异常文件处理失败,请刷新后再试.';
			}
			
		}
		
		echo json_encode( $objRet );
		
	}
	
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.9.1' )
	 * @comment( comment = '递归循环文件 并返回' )
	 * @method( method = 'loopFile' )
	 * @op( op = '' )
	 */
	private function _loopFile( $dir )
	{
		$list = scandir( $dir );
		foreach( $list as $file )
		{
			if( 'cache' == $file || 'storage' == $file )
				continue;
			
			$location_dir = $dir . '/' . iconv('GB2312','UTF-8', $file );
				
			if( FALSE == stristr( $location_dir, '.gif' ) &&
					FALSE == stristr( $location_dir, '.JPG'  ) &&
					FALSE == stristr( $location_dir, '.PNG'  ) &&
					FALSE == stristr( $location_dir, '.svn-base' ) &&
					FALSE == stristr( $location_dir, '.buildpath' ) &&
					FALSE == stristr( $location_dir, '.project' ) &&
					FALSE == stristr( $location_dir, '.db' ) &&
					FALSE == stristr( $location_dir, '.prefs' )
			 )
			{
				$this->arrFiles[] =  $location_dir;
				$this->arrNames[] =  $file;
			}
				
			if( is_dir( $location_dir ) && '.' != $file && '..' != $file )
			{
				$this->_loopFile( $location_dir );
			}
		}
	}
	
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.9.1' )
	 * @comment( comment = '清空文件安全表中的数据信息' )
	 * @method( method = 'emptyTable' )
	 * @op( op = '' )
	 */
	private function _emptyTable()
	{
		$phql = 'delete from apps\admin\models\FileSecurity';
		$res = $this->modelsManager->executeQuery( $phql );
		if(  $res )
			return true;
		else
			return false;
	}
	
	/**
	 * @author( author='New' )
	 * @date( date = '2015.12.24' )
	 * @comment( comment = '预览错误文件内容' )
	 * @method( method = 'showFiles' )
	 * @op( op = '' )
	 */
	public function showFilesAction()
	{
	    $id = $this->dispatcher->getParam( 'id' );
	    if( !$id )
	    {
	        $this->error( '参数错误' );
	    }
	    else
       {
	        $res = FileSecurity::findFirst( array(
                'conditions' => 'id=?0 and delsign=?1',
                'bind'       => [ $id, 0 ],
                'columns'    => 'filepath'
	        ) );
	        if( !$res )
	        {
	            $this->error( '数据获取失败' );
	        }
            else
           {
               $data = file_get_contents( $res->filepath );
               $this->success( '', [ 'fileInfo' => htmlspecialchars( $data ) ] );
            }
	    }
	}
}

?>