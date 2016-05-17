<?php

namespace enums;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class SystemEnums {

	/**
	 * delsign delete
	 * 删除 1 ----- 冻结帐户
	 */
	const DELSIGN_YES = 1;
	
	/**
	 * delsign not delete 
	 * 不删除   0 ---- 正常帐户
	 */
	const DELSIGN_NO = 0;
	
	
	/**
	 * 状态 正常  0
	 */
	const STUATUS_NOEMAL = 0;
	
	/**
	 * 状态 异常 1
	 */
	const STUATUS_UNNOEMAL = 1;
	
	
	/**
	 * 超级管理员账户
	 */
	const SUPER_ADMIN_ID = 1;
	
	/**
	 * 系统自带模块
	 */
	const DEFAULT_MODEL_ID = 0;
	
	/**
	 * 不展示模块
	 */
	const IS_MENU_NO = 0;

	/**
	 * 展示模块
	 */
	const IS_MENU_YES = 1;
	
	/**
	 * 默认pid
	 */
	const DEFAULT_PID = 0;
	
	/**
	 * 菜单级别  一级菜单
	 */
	const CAT_LEVEL_FIRST = 1;
	
	/**
	 * 菜单级别  二级菜单
	 */
	const CAT_LEVEL_SECOND = 2;
	
	/**
	 * 菜单级别  三级菜单
	 */
	const CAT_LEVEL_THIRD = 3;
	
	/**
	 * 用户当前状态 正常
	 */
	const USER_STATE_NORMAL = 0;
	
	/**
	 * 用户当前状态 暂停使用
	 */
	const USER_STATE_PAUSE = 1;
	
	/**
	 * 用户当前状态 密码丢失
	 */
	const USER_STATE_LOST = 2;
	
	/**
	 * 用户当前状态 锁定
	 */
	const USER_STATE_LOCK = 3;
    
    /**
	 * 用户当前状态 账号激活
	 */
	const USER_STATE_ACTIVE = 4;
	
	/**
	 * 未读系统通知
	 */
	const UNREAD_NOTICE = 1;
	
	/**
	 * 已读系统通知
	 */
	const READ_NOTICE = 2;
    
    /**
	 * 商品上架
	 */
	const GOODS_SHELVE = 1;
    
     /**
	 * 商品下架
	 */
	const GOODS_UNSHELVE = 0;
    
     /**
	 * 订单待支付
	 */
	const ORDER_WAIT_BUYER_PAY = 1;
    
    /**
	 * 订单待发货
	 */
	const ORDER_WAIT_SELLER_SEND_GOODS = 2;
    
     /**
	 * 订单待收货
	 */
	const ORDER_WAIT_BUYER_CONFIRM_GOODS = 3;
    
    /**
	 * 订单买家付款成功
	 */ 
	const ORDER_TRADE_SUCCESS = 4;
	
     /**
	 * 订单完成
	 */ 
	const ORDER_TRADE_FINISH = 4;
    
     /**
	 * 订单取消
	 */
	const ORDER_TRADE_CLOSED = 5;
    
    /**
    * 订单退款
    */ 
	const ORDER_REFUND = 6;
    
     /**
     * 退换货 处理中
     */
    const REFUND_PROCESS = 0;
    
    /**
     * 同意退换货
     */
    const REFUND_AGREE = 1;
    
    /**
     * 拒绝
     */
    const REFUND_REFUSE = 2;
    
    /**
     * 买家已发货
     */
    const REFUND_BUYER_SEND_GOODS = 3;
    
    /**
     * 卖家已发货
     */
    const REFUND_SELLER_SEND_GOODS = 4;
    
    /**
     * 退款成功
     */
    const REFUND_SUCCESS = 5;
    
    /**
     * 退换货完成
     */
    const REFUND_FINISH = 6;
    /**
     *  图片服务器
     */
    const PIC_HOST = 'http://www.huaer.dev';
}
?>