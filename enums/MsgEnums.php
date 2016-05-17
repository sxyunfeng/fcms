<?php

namespace enums;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

/**
 * message type enumerations
 * @author bruce
 *
 */
class MsgEnums
{
	/**
	 * 发送邮件
	 */
	const MSG_TYPE_SEND_MAIL = 0;
	
	/**
	 * 发送短信
	 */
	const MSG_TYPE_SEND_SMS = 1;
	
	/**
	 * 秒杀订单
	 */
	const MSG_TYPE_SECKILL = 2;
	
	/**
	 * 正常订单
	 */
	const MSG_TYPE_ORDER = 3;
	
	/**
	 * 团购订单
	 */
	const MSG_TYPE_GROUPON = 4;
}

?>