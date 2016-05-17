<?php

namespace apps\install\listeners;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use \Phalcon\Events\Event;
use \Phalcon\Mvc\Dispatcher;
use \Phalcon\Mvc\User\Plugin;
use \Phalcon\Acl\Adapter\Memory;
use enums\LogEnums;

class DispatcherListener extends Plugin
{
	// protected $_module;
	
	// public function __construct($module)
	// {
	// $this->_module = $module;
	// }
		
	public function beforeExecuteRoute( Event $event, Dispatcher $dispatcher )
	{ // set acl
// 		$userInfo = $this->session->get( 'userInfo' );
		
// 		if( !$userInfo )
// 		{ // dispatch to login page
// 			return;
// 		}
		
// 		$groupInfo = $this->fileCache->get( 'aclCache_group_' . $userInfo->gid );
		
// 		if( $groupInfo === false || $groupInfo == null )
// 		{ // 若acl为空则重新设置
// 			$this->adminInfo->setGroupAcl( $userInfo );
// 			$groupInfo = $this->fileCache->get( 'aclCache_group_' . $userInfo->gid );
// 		}
// 		$acl = unserialize( base64_decode( $groupInfo ));
// 		exit( __FILE__ );
// 		if( $acl->isAllowed( "group" . $userInfo->gid, $dispatcher->getControllerName(), $dispatcher->getActionName() ) )
// 		{
// // 			$dispatcher->forward( array(
// // 					'module' => 'admin',
// // 					'controller' => 'Login',
// // 					'action' => 'index' 
// // 			) );
// exit( __LINE__ );
// 		}
// 		else
// 		{
// 			echo "Access denied :(";
// 			exit();
// 		}
	}

	public function beforeDispatch( Event $event, Dispatcher $dispatcher )
	{
		// echo $resource = $this->_module . '-' . $dispatcher->getControllerName(), PHP_EOL; // frontend-dashboard
		// echo $access = $dispatcher->getActionName(); // null
	}

	public function beforeException( Event $event, Dispatcher $dispatcher )
	{
		if( isset( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) )
		{ // ajax request
			return;
		}
		
		// if( $SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' );
		// strtolower(
		
		$dispatcher->forward( array(
				'module' => 'admin',
				'controller' => 'error',
				'action' => 'err404' 
		) );
		
		return false;
	}

	/**
	 * @author( author = 'Carey' )
	 * @date( date = '2015.8.31' )
	 * @comment( comment = 'session安全,后台用户操作日志' )
	 * @method( method = 'beforeDispatchLoop' )
	 * @op( op = '' )
	 */
	public function beforeDispatchLoop( Event $event, Dispatcher $dispatcher )
	{
		$keyParams = array();
		$params = $dispatcher->getParams();
		
		foreach( $params as $k => $v )
		{
			if( $k & 1 )
			{
				$keyParams[ $params[ $k - 1 ]] = $v;
			}
		}
		
		$dispatcher->setParams( $keyParams );
		
		
		//session 安全管理 ( 浏览器 + ip地址 )
		$adminUserInfo = $this->session->get( 'userInfo' );
		if( !$adminUserInfo )
		{
			//用户未登录或者访问用户session信息出错 
			return;
		}
		
		$strVerfiy = trim( trim( trim( $_SERVER[ 'HTTP_USER_AGENT' ] ) ) . trim( md5( $_SERVER[ 'SERVER_ADDR' ] ) ) );
		if( $adminUserInfo[ 'session_verfiy' ] != $strVerfiy )
		{//session_id + ip / session_id + browser 验证失败  写入日志
			$this->queue->put( array(
					'type' => LogEnums::LOG_ADMIN_SESSION_LOG,
					'body' => array(
							'userId' => $adminUserInfo['id'],
							'userName' => $adminUserInfo['loginname'],
							'addTime' => $_SERVER['REQUEST_TIME'],
							'url' 	=> $_SERVER['REQUEST_URI']
					)
			));
			return;
		}
			
		$adminRegTime = $this->config[ 'admin_regenrator_time_interval' ];
		$currTime = intval( $_SERVER[ 'REQUEST_TIME' ] - $adminUserInfo[ 'admin_regenrator_time' ] );
		if( $currTime >= $adminRegTime )
		{//过期   ---  重新生成
		
			session_regenerate_id();
			
			$strVerfiy = trim( trim( trim( $_SERVER[ 'HTTP_USER_AGENT' ] ) ) . trim( md5( $_SERVER[ 'SERVER_ADDR' ] ) ) );
			$adminUserInfo[ 'admin_regenrator_time' ]	= $_SERVER[ 'REQUEST_TIME' ];
			$adminUserInfo[ 'session_verfiy' ] 			= $strVerfiy;
			
			$this->session->set( 'userInfo', $adminUserInfo );
		}
		
		
		//记录后台操作日志
		$controller = strtolower( $dispatcher->getControllerName() ) . 'controller';
		$method = strtolower( $dispatcher->getActionName() ) . 'action';
		
		$annotation = $this->memCache->get( 'admin_' . $controller . '_' . $method . '_cache' );
		if( $annotation )
		{
			//注释信息读取失败 发送消息记录该异常消息 
			$this->queue->put( array(
					'type' => \enums\LogEnums::LOG_RECORDEXCEPTION,
					'body' => array(
							'message' => 'Error:[' . date("Y-m-d H:i:s",time()) . ']apps/admin/' 
								. $controller.'/'. $method . '注释信息读取出错'
					)
			));
			return;
		}
		
		//cud操作记录于用户操作日志 ; 其他则忽略
		$op = $annotation['op'];
		if( 'r' == $op || '' == $op )
		{
			return;
		}
		elseif( 'c' == $op || 'u' == $op || 'd' == $op )
		{
			$this->queue->put( array(
					'type' => \enums\LogEnums::LOG_ADMIN_OPERATION_LOG,
					'body' => array(
							'userId' => $adminUserInfo['id'],
							'userName' => $adminUserInfo['loginname'],
							'controller' => $controller,
							'action' => $method,
							'operation' => $op,
							'addTime' => $_SERVER['REQUEST_TIME'],
							'postContent' => $_POST,
							'url' => APP_ROOT . 'apps/' . $_SERVER['REQUEST_URI'] . 'Action'
					)
			));
		}
		else 
		{
			//注释信息op字段存在非法字字符
			$this->queue->put( array(
					'type' => \enums\LogEnums::LOG_RECORDEXCEPTION,
					'body' => array(
							'message' => 'Error:[' . date("Y-m-d H:i:s",time()) . ']/admin/' 
								. $controller.'/'. $method . '注释信息op字段存在非法字符'
					)
			));
			return;
		}
	}
	
}











