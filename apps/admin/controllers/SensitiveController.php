<?php

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use libraries\TimeUtils;
use apps\admin\models\Sensitive;

class SensitiveController extends AdminBaseController{
	
	public function initialize()
	{
		parent::initialize();
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.10.14' )
	 * @comment( comment = '敏感词列表' )
	 * @method( method = 'indexAction' )
	 * @op( op = 'r' )
	 */
	public function indexAction()
	{
		$pageNum = $this->request->getQuery( 'page', 'int' );
		$currentPage = $pageNum ? $pageNum : 1;
		
		$where = array(
				'column'	=> 'id,addtime,uptime,delsign,word,uid',
				'conditions'=> 'delsign=:del: ORDER BY id DESC',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
		);
		$res = Sensitive::find( $where );
		$pagination = new PaginatorModel( array(
				'data' => $res,
				'limit' => 15,
				'page' => $currentPage
		));
		$page = $pagination->getPaginate();
			
		$this->view->page = $page;
		$this->view->default = $this->config[ 'sensitive_default_replace' ];
		
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.10.14' )
	 * @comment( comment = '添加敏感词' )
	 * @method( method = 'addAction' )
	 * @op( op = 'r' )
	 */
	public function addAction()
	{
		
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.10.14' )
	 * @comment( comment = '保存敏感词' )
	 * @method( method = 'addAction' )
	 * @op( op = 'r' )
	 */
	public function saveAction()
	{
		$loginInfo = $this->session->get( 'userInfo' );
		$key = $this->request->getPost( 'key' );
		$arrKeys = explode( "\n", $key );
		if( count( $arrKeys ) > 0 )
		{
			foreach( $arrKeys as $val )
			{
				$sens = new Sensitive();
				$sens->delsign = SystemEnums::DELSIGN_NO;
				$sens->addtime = $sens->uptime = TimeUtils::getFullTime();
				$sens->word	   = $val;
				$sens->uid	   = $loginInfo[ 'id' ];
				$sens->save();			
			}
		}
		
		$this->response->redirect( '/admin/sensitive/index' );
	}
	
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.10.14' )
	 * @comment( comment = '删除敏感词' )
	 * @method( method = 'deleteAction' )
	 * @op( op = 'r' )
	 */
	public function deleteAction()
	{
		$objRet = new \stdClass();
		
		$optid = $this->dispatcher->getParam( 'id' );
		if( false == $optid )
		{
			$objRet->state  = 1;
			$objRet->msg	= '获取参数出错,请刷新后再试.';
			echo json_encode( $objRet );
			exit;
		}
		
		$where = array(
			'conditions'	=> 'delsign=:del: and id=:optid:',
			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $optid ),
		);
		$sens = Sensitive::findFirst( $where );
		if( count( $sens ) > 0 )
		{
			$sens->delete();
			
			$objRet->state = 0;
			$objRet->optid = $optid;
			$objRet->msg = '操作成功,该敏感词已被删除.';
		}
		else
		{
			$objRet->state = 1;
			$objRet->msg = '对不起,操作失败,未找到该条信息.';
		}
		
		echo json_encode( $objRet );
	 }
	 
	 /**
	 * @author( author='Carey' )
	 * @date( date = '2015.10.15' )
	 * @comment( comment = '设置敏感词替换词' )
	 * @method( method = 'replaceAction' )
	 * @op( op = 'u' )
	 */
	 public function replaceAction()
	 {
	 	$objRet = new \stdClass();
	 	
	 	$optid  = $this->dispatcher->getParam( 'id' );
	 	$reword = urldecode( $this->dispatcher->getParam( 'strreplace' ) );
	 	
	 	if( false == $optid || false == $reword )
	 	{
	 		$objRet->state = 1;
	 		$objRet->msg = '对不起,参数设置错误,请稍后重试.';
	 		echo json_encode( $objRet );
	 		
	 		exit;
	 	}
	 	
	 	$where = array(
	 		'conditions'	=> 'delsign=:del: and id=:optid:',
	 		'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO , 'optid' => $optid ),
	 	);
	 	$res = Sensitive::findFirst( $where );
	 	if( count( $res ) > 0 )
	 	{
	 		$res->rword = $reword;
			$res->save();

			$objRet->state = 0;
			$objRet->rword = $reword;
			$objRet->msg = '设置成功.';
	 	}
	 	else 
	 	{
	 		$objRet->state = 1;
	 		$objRet->msg = '信息为找到,设置失败.';
	 	}
	 	
	 	echo json_encode( $objRet );
	 }
}

?>