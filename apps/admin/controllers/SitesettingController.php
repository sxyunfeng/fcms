<?php

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\SystemEnums;
use apps\admin\models\SiteSetting;
use libraries\TimeUtils;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
/**
 * 站点管理
 * @author Carey
 * @time 2015-9-16
 */
class SitesettingController extends AdminBaseController{
	
	public function initialize()
    {
        parent::initialize();
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.10.22' )
     * @comment( comment = '默认站点信息' )
     * @method( method = 'indexAction' )		
     * @op( op = 'r' )		
     */
    public function indexAction()
    {
    	$where = array(
    		'column'	=> 'id,addtime,uptime,delsign,name,domain,logo,seokey,seodescr,copyright,static_code,is_main',
    		'conditions'=> 'delsign=:del: and is_main=:main: ORDER BY uptime DESC',
    		'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'main'=>0 ),
    	);
    	$res = SiteSetting::findFirst( $where );
    	
    	$this->view->site = $res;
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.10.22' )
     * @comment( comment = '默认站点更新保存' )
     * @method( method = 'saveAction' )
     * @op( op = 'r' )
     */
    public function saveAction()
    {
    	$formData = $this->request->getPost( 'form' );
    	
    	if( !empty( $formData ) && false != $formData[ 'id' ] )
    	{
    		$formDate[ 'uptime' ] = TimeUtils::getFullTime();
    		
    		$site = SiteSetting::findFirst( $formData[ 'id' ] );
    		if( count( $site ) > 0 )
    		{
    			$site->update( $formData );
    		}
    		
    		$this->response->redirect( '/admin/sitesetting/index' );
    	}
    	else if( !empty( $formData ) && false == $formData[ 'id' ] )
    	{
    	    $where = array(
    	                    'conditions'=> 'delsign=:del: and is_main=:main:',
    	                    'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'main'=> 0 ),
    	    );
    	    $res = SiteSetting::find( $where );
    	    if( false != $res && count( $res ) > 0 )
    	    {
    	        foreach( $res as $row )
    	        {
    	            $row->is_main = 1;
    	            $row->save();
    	        }
    	    }
    	    
    	    $formData[ 'is_main' ] = 0;
    	    $formData[ 'addtime' ] = $formData[ 'uptime' ] = TimeUtils::getFullTime();
    	    $site = new SiteSetting();
    	    if( $site->save( $formData ) )
    	        $this->response->redirect( '/admin/sitesetting/index' );
    	    else
    	        $this->response->redirect( '/admin/sitesetting/index' );
    	}
    	else
    		$this->response->redirect( '/admin/sitesetting/index' );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.10.22' )
     * @comment( comment = '站点列表' )
     * @method( method = 'siteListAction' )
     * @op( op = 'r' )
     */
    public function siteListAction()
    {
    	$pageNum = $this->request->getQuery( 'page', 'int' );
    	$currentPage = $pageNum ? $pageNum : 1;
    	
    	$where = array(
    			'column'	=> 'id,addtime,uptime,delsign,name,domain,logo,seokey,seodescr,copyright,static_code,is_main',
    			'conditions'=> 'delsign=:del: ORDER BY is_main ASC',
    			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
    	);
    	$res = SiteSetting::find( $where );
    	
    	$pagination = new PaginatorModel( array(
    			'data' => $res,
    			'limit' => 15,
    			'page' => $currentPage
    	) );
    	
    	$page = $pagination->getPaginate();
    	
    	$this->view->page = $page;
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.10.22' )
     * @comment( comment = '添加站点' )
     * @method( method = 'siteListAction' )
     * @op( op = 'r' )
     */
    public function addsiteAction()
    {
    	$this->view->pick( 'sitesetting/siteopt' );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.10.22' )
     * @comment( comment = '修改站点' )
     * @method( method = 'siteListAction' )
     * @op( op = 'r' )
     */
    public function upsiteinfoAction()
    {
    	$optid = $this->dispatcher->getParam( 'id' );
    	if( false == $optid )
    		$this->response->redirect( '/admin/sitesetting/siteList' );
    	
    	$arrWhere = array(
    		'conditions'=> 'delsign=:del: and id=:optid:',
    		'bind'		=>array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $optid ),
    	);
    	$site = SiteSetting::findFirst( $arrWhere );
    	if( count( $site ) > 0 )
    	{
    		if( 0 != $site->is_main )
    		{
    			$this->view->setVar( 'site', $site );		
	    		$this->view->pick( 'sitesetting/siteopt' );
    		}
    		else 
    			$this->response->redirect( '/admin/sitesetting/siteList' );
    	}
    	else
    		$this->response->redirect( '/admin/sitesetting/siteList' );
    	
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.10.22' )
     * @comment( comment = '保存站点信息' )
     * @method( method = 'saveBizAction' )
     * @op( op = 'r' )
     */
    public function saveBizAction()
    {
    	$formData = $this->request->getPost( 'form' );
    	if( !empty( $formData ) )
    	{
    		if( false != $formData[ 'id' ] )
    		{
    			$formData[ 'uptime' ] = TimeUtils::getFullTime();
    			$where = array(
    				'conditions'=> 'delsign=:del: and id=:optid:',
    				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'optid' => $formData[ 'id' ] ),
    			);
    			$site = SiteSetting::findFirst( $where );
    			if( count( $site ) > 0 )
    			{
    				//是否设置为默认主站
    				if( 0 == $formData[ 'is_main' ] && $formData[ 'is_main' ] != $site->is_main  )
    				{
    					$where = array(
    							'conditions'=> 'delsign=:del: and is_main=:main:',
    							'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'main'=> 0 ),
    					);
    					$res = SiteSetting::find( $where );
    					if( count( $res ) > 0 )
    					{
    						foreach( $res as $row )
    						{
    							$row->is_main = 1;
    							$row->save();
    						}
    					}
    				}
    				
    				if( $site->save( $formData ) )
    					$this->response->redirect( '/admin/sitesetting/siteList' );
    				else 
    					$this->response->redirect( '/admin/sitesetting/upsiteinfo/id/' . $formData[ 'id' ] );
    			}
    			else
    				$this->response->redirect( '/admin/sitesetting/addsite' );
    			
    		}
    		else
    		{
    			//是否设置为默认主站
    			if( 0 == $formData[ 'is_main' ] )
    			{
    				$where = array(
    					'conditions'=> 'delsign=:del: and is_main=:main:',
    					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'main'=> 0 ),	
    				);
    				$res = SiteSetting::find( $where );
    				if( false != $res && count( $res ) > 0 )
    				{
    					foreach( $res as $row )
    					{
    						$row->is_main = 1;
    						$row->save();
    					}
    				}
    			}
    			
    			$formData[ 'addtime' ] = $formData[ 'uptime' ] = TimeUtils::getFullTime();
    			$site = new SiteSetting();
    			if( $site->save( $formData ) )
    				$this->response->redirect( '/admin/sitesetting/siteList' );
    			else 
    				$this->response->redirect( '/admin/sitesetting/addsite' );
    			
    		}
    	}
    	else
    		$this->response->redirect( '/admin/sitesetting/siteList' );
    	
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.10.22' )
     * @comment( comment = '站点删除' )
     * @method( method = 'deleteAction' )
     * @op( op = 'r' )
     */
    public function deleteAction()
    {
    	$objRet = new \stdClass();
    	
    	$optId = $this->dispatcher->getParam( 'id' );
    	if( false == $optId )
    	{
    		$objRet->state = 1;
    		$objRet->msg = '参数设置错误,请稍后再试.';
    		
    		echo json_encode( $objRet );
    		exit;
    	}
    	
    	$where = array(
    		'conditions'=> 'delsign=:del: and id=:optid:',
    		'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $optId ),
    	);
    	$site = SiteSetting::findFirst( $where );
    	if( count( $site ) > 0 && false != $site )
    	{
    		if( 0 == $site->is_main )
    		{
    			$objRet->state = 1;
    			$objRet->msg = '该站点为默认站点,不能删除.';
    		}
    		else
    		{
    			$site->delete();
    			$objRet->state = 0;
    			$objRet->msg = '删除站点成功.';
    			$objRet->optid = $optId;
    		}
    	}
    	else
    	{
    		$objRet->state = 1;
    		$objRet->msg   = '数据未找到,删除失败.';
    	}
    	echo json_encode( $objRet );
    }
    
}

?>