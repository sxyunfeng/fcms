<?php

namespace apps\admin\libraries;

use Phalcon\DI\InjectionAwareInterface;
use enums\SystemEnums;
use apps\admin\models\OrdersSub;
use apps\admin\models\GoodsTechan;
use apps\admin\models\OrdersReturns;

class GoodsDatas implements InjectionAwareInterface{
	
	private $_di;
	
	public function setDI(\Phalcon\DiInterface $dependencyInjector) {
		// TODO Auto-generated method stub
		$this->_di = $dependencyInjector;
	}
	
	/* (non-PHPdoc)
	 * @see \Phalcon\DI\InjectionAwareInterface::getDI()
	*/
	public function getDI() {
		// TODO Auto-generated method stub
		return $this->_di;
	}
	
	/**
	 * 获取订单信息
	 * @return \stdClass
	 */
	public function getorders()
	{
		$userInfo = $this->_di['session']->get( 'userInfo' );
		$where = 'delsign=' . SystemEnums::DELSIGN_NO . ' and shop_id =' . $userInfo[ 'shopid' ];
		$order = OrdersSub::count( $where);
		
		return $order;
	}
	
	/**
	 * 待发货订单
	 * @return number
	 */
	public function getwaitorders()
	{
		$userInfo = $this->_di['session']->get( 'userInfo' );
		$where = 'delsign=' . SystemEnums::DELSIGN_NO . ' and shop_id =' . $userInfo[ 'shopid' ];
		$wait_order = OrdersSub::count( $where . ' and status =' . SystemEnums::ORDER_WAIT_SELLER_SEND_GOODS );
		
		return $wait_order;
	}
	
	/**
	 * 商品的统计
	 * @return \stdClass
	 */
	public function getgoodsnum()
	{
		$userInfo = $this->_di['session']->get( 'userInfo' );
		
		$where = 'delsign=' . SystemEnums::DELSIGN_NO . ' and shop_id =' . $userInfo[ 'shopid' ];
		$goods = GoodsTechan::count( $where);
		
		return $goods;
	}
	
	/**
	 * 商品的库存量
	 * @return \stdClass
	 */
	public function getalertgoods()
	{
		$userInfo = $this->_di['session']->get( 'userInfo' );
	
		$where = 'delsign=' . SystemEnums::DELSIGN_NO . ' and shop_id =' . $userInfo[ 'shopid' ];
		$alert_goods = GoodsTechan::count( $where . ' and skuleft = 0'  );
	
		return $alert_goods;
	}
	
	/**
	 * 退货的统计
	 * @return \stdClass
	 */
	public function getreturn()
	{
		$userInfo = $this->_di['session']->get( 'userInfo' );
		
		$where = 'delsign=' . SystemEnums::DELSIGN_NO . ' and shop_id =' . $userInfo[ 'shopid' ];
		$order_return = OrdersReturns::count( $where . ' and status=' . SystemEnums::REFUND_PROCESS );
		
		return $order_return;
	}
	
}

?>