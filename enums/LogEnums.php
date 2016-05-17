<?php
namespace enums;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

/**
 * @author 	zlw
 * @date 	2015.8.19
 * @desc	日志字典
 */
class LogEnums
{
	/**
	 * 后台操作日志
	 */
	const LOG_ADMIN_OPERATION_LOG  = 'Log_adminOperationLog';
	
	/**
	 * 前台操作日志
	 */
	const LOG_HOME_OPERATION_LOG = 'Log_homeOperationLog';
	
	/**
	 * 前台用户访问日志
	 */
	const LOG_HOME_VISIT_LOG = 'Log_homeVisitLog';
	
	/**
	 * 后台session安全验证
	 */
	const LOG_ADMIN_SESSION_LOG  = 'Log_adminSession';
	
	/**
	 * 前台session安全验证
	 */
	const LOG_MEM_SESSION_LOG = 'Log_homeSession';
	
	/**
	 * 前台登录日志
	 */
	const LOG_MEM_LOGIN_LOG = 'Log_memLoginLog';
	
	/**
	 * 记录异常信息
	 */
	const LOG_RECORDEXCEPTION = 'Log_recordException';
	
    /**
     * 添加操作
     */
	const OPERATION_TYPE_ADD = 1;
	
	/**
	 * 修改操作
	 */
	const OPERATION_TYPE_UPDATE = 2;
	
	/**
	 * 删除操作
	 */
	const OPERATION_TYPE_DELETE = 3;
	
	/**
	 * 后台控制器
	 */
	const ADMIN_CONTROLLER_PATH = 'apps\admin\controllers';
	
	/**
	 * 前台控制器
	 */
	const MEM_CONTROLLER_PATH = 'apps\home\controllers';
	
	/**
	 * 后台控制器命名空间
	 */
	const ADMIN_CONTROLLER_NAMESPACE = '\apps\admin\controllers\\';
	
	/**
	 * 前台控制器命名空间
	 */
	const MEM_CONTROLLER_NAMESPACE = '\apps\home\controllers\\';
	
	
}









