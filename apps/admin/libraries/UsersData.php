<?php

namespace apps\admin\libraries;

use Phalcon\DI\InjectionAwareInterface;
use enums\SystemEnums;
use apps\admin\models\PriUsers;
use apps\admin\models\Orders;

class UsersData implements InjectionAwareInterface{
	
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
	 * 会员信息
	 * @return \stdClass
	 */
	public function getusers()
	{
		$objRet = new \stdClass();
		$userInfo = $this->_di['session']->get( 'userInfo' );
		$where = 'delsign=' . SystemEnums::DELSIGN_NO  ;
		if( $userInfo['id'] == SystemEnums::SUPER_ADMIN_ID )
			//会员的统计
			$user = PriUsers::count( $where );
		else
			$user = 0;
		
		return $user;
	}
	
	/**
	 * 会员订单
	 */
	public function getuserorder()
	{
		$objRet = new \stdClass();
		$userInfo = $this->_di['session']->get( 'userInfo' );
		$where = 'delsign=' . SystemEnums::DELSIGN_NO  ;
		if( $userInfo['id'] == SystemEnums::SUPER_ADMIN_ID )
		{
			//会员的统计
			$order_user = Orders::count( array( $where, 'distinct' => 'mem_id' ) );
		}
		else
		{
			$order_user = 0;
		}
	
		return $order_user;
	}
}

?>