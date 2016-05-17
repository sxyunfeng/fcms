<?php
namespace apps\admin\controllers;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\SystemEnums;
use apps\admin\models\SysIndeCfg;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use libraries\TimeUtils;
use apps\admin\models\PriGroups;

/**
 * 系统主页配置中心
 * @author Carey
 * time 2015-11-18
 */
class SysindexController extends AdminBaseController{
	
	public function initialize()
	{
		parent::initialize();
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.11.18' )
	 * @comment( comment = '系统主页配置项列表' )
	 * @method( method = 'indexAction' )
	 * @op( op = 'r' )
	 */
	public function indexAction()
	{
		$pageNum = $this->request->getQuery( 'page', 'int' );
		$currentPage = $pageNum ? $pageNum : 1;
		
		$where = array(
				'column'	=> 'id,delsign,addtime,uptime,name,icon,color,line,size,display,sort,groupid',
				'conditions'=> 'delsign=:del: ORDER BY groupid, sort,uptime DESC',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
		);
		$res = SysIndeCfg::find( $where );
		$pagination = new PaginatorModel( array(
				'data'  => $res,
				'limit' => 10,
				'page'  => $currentPage
		));
		$page = $pagination->getPaginate();
		$this->view->page = $page;
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.11.18' )
	 * @comment( comment = '系统主页配置项添加/修改' )
	 * @method( method = 'optAction' )
	 * @op( op = 'r' )
	 */
	public function optAction()
	{
		
		$where = array(
			'column'	=> 'id,delsign,name',
			'conditions'=> 'delsign=:del:',
			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
		);
		$groups = PriGroups::find( $where );
		$this->view->groups = $groups;
		
		$optid = $this->dispatcher->getParam( 'id' );
		if( false != $optid )
		{
			$where = array(
				'column'	=> 'id,delsign,addtime,uptime,name,icon,color,line',
				'conditions'=> 'delsign=:del: and id=:optid:',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'optid' => $optid ),
			);
			$res = SysIndeCfg::findFirst( $where );
			if( false != $res && count( $res ) > 0 )
				$this->view->res = $res;
		}
		
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.11.18' )
	 * @comment( comment = '系统主页配置项业务处理' )
	 * @method( method = 'saveAction' )
	 * @op( op = 'r' )
	 */
	public function saveAction()
	{
		$name = $this->request->getPost( 'name' );
		$icon = $this->request->getPost( 'icon' );
		$color= $this->request->getPost( 'color' );
		$line = $this->request->getPost( 'line' );
		$size = intval( $this->request->getPost( 'size' ) );
		if( false != $size && $size <=0 )
			$size = 1;
		else if( false != $size && $size > 12 )
			$size = 12;
		else  if( false == $size )
			$size = 1;
		
		$descr = $this->request->getPost( 'cont' );
		$display = $this->request->getPost( 'display' );
		$groupid = $this->request->getPost( 'groupid' );
		$sort	 = $this->request->getPost( 'sort' );
		$optid = $this->request->getPost( 'id' , 'int' );
		
		if( false != $optid )
		{
			$where = array(
					'column'	=> 'id,delsign,addtime,uptime,name,icon,color,line',
					'conditions'=> 'delsign=:del: and id=:optid:',
					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'optid' => $optid ),
			);
			$res = SysIndeCfg::findFirst( $where );
			if( false != $res && count( $res ) > 0 )
			{
				$res->uptime = TimeUtils::getFullTime();
				$res->name = trim( $name );
				$res->icon = $icon;
				$res->color = $color;
				$res->line	= $line;
				$res->size 	= $size;
				$res->groupid = $groupid;
				$res->sort  = $sort;
				$res->display= $display;
				$res->descr = $descr;
				if( $res->save() )
					$this->response->redirect( '/admin/sysindex/index' );
				else
					$this->response->redirect( '/admin/sysindex/opt/id/' . $optid );
			}
			else
				$this->response->redirect( '/admin/sysindex/opt' );
		}
		else 
		{
			$cfg = new SysIndeCfg();
			$cfg->delsign = SystemEnums::DELSIGN_NO;
			$cfg->addtime = $cfg->uptime = TimeUtils::getFullTime();
			$cfg->name = trim( $name );
			$cfg->icon = $icon;
			$cfg->color = $color;
			$cfg->line	= $line;
			$cfg->size 	= $size;
			$cfg->groupid = $groupid;
			$cfg->sort	= $sort;
			$cfg->display= $display;
			$cfg->descr = $descr;
			if( $cfg->save() )
				$this->response->redirect( '/admin/sysindex/index' );
			else 
				$this->response->redirect( '/admin/sysindex/opt' );
		}
		
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.11.18' )
	 * @comment( comment = '删除系统主页配置项' )
	 * @method( method = 'deleteAction' )
	 * @op( op = 'r' )
	 */
	public function deleteAction()
	{
		$objRet = new \stdClass();
		$optid = $this->dispatcher->getParam( 'id' );
		if( false == $optid )
		{
			$objRet->state = 1;
			$objRet->msg = '对不起,参数配置失败,请刷新页面后重试.';
			
			echo json_encode( $objRet );
			exit;
		}
		
		$where = array(
				'column'	=> 'id,delsign,addtime,uptime,name,icon,color,line',
				'conditions'=> 'delsign=:del: and id=:optid:',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'optid' => $optid ),
		);
		$res = SysIndeCfg::findFirst( $where );
		if( false != $res && count( $res ) > 0 )
		{
			$res->delete();
			$objRet->state = 0;
			$objRet->msg = '删除成功';
			$objRet->optid = $optid;
		}
		else
		{
			$objRet->state = 1;
			$objRet->msg = '对不起,未找到相关配置信息,无法删除.';
		}
		
		echo json_encode( $objRet );
	}
	
}

?>