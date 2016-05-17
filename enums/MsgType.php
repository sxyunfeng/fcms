<?php
namespace enums;

class MsgType
{
    /**
     * message type email
     */
    const EMAIL_SEND = 'Email_send';
    
    /**
     *  email发送报告 （比如本周发送了多少email等）
     */
    const EMAIL_REPORT = 'Email_report';
    
    /**
     * message type short message
     */
    const SMS_SEND = 'Sms_send';
    
    /**
    * message type order 订单已付款，等待发货
    */
    const ORDER_WAIT_DELIVER = 'Order_waitDeliver';
    
    /**
     * message type order 商品已经发货，等待接收
     */
    const ORDER_WAIT_RECEIVE = 'Order_waitReceive';
    
    /**
     * message type order 商品申请退货，等待处理
     */
    const ORDER_APPLY_RETURN = 'Order_applyReturn';
    
    /**
     * message type backup database
     */
    const DB_BACKUP = 'Db_backup';
    
    /**
     * message type security scan
     */
    const SECURITY_SCANSCRIPTSFILES = 'Security_scanCriptsFiles';
    
    /**
     *  团购
     */
    const TEAMBUY_RECEIVE = 'TeamBuy_receive';
    
}









