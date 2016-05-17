<?php

namespace apps\admin\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use \Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

/**
 * 单会员统计表
 * @author Carey
 *
 */
class StatMember extends Model{
	
	/**
	 *
	 * @var integer
	 */
	public $id;
	
	/**
	 *
	 * @var integer
	 */
	public $delsign;
	
	/**
	 * @var int
	 */
	public $u_id;
	
	/**
	 * @var decimal
	 */
	public $total_amt;
	
	/**
	 * @var int
	 */
	public $order_num;
	
	/**
	 * @var int
	 */
	public $unit;
	
	/**
	 *
	 * @var string
	 */
	public $p_time;
	
	/**
	 *
	 * @var string
	 */
	public $addtime;
	
	/**
	 *
	 * @var string
	 */
	public $uptime;
	
	/**
	 *
	 * @var string
	 */
	public $descr;
	
	
	public function columnMap()
	{
		return array(
				'id'          => 'id',
				'delsign'     => 'delsign',
				'u_id'		  => 'u_id',
				'total_amt'	  => 'total_amt',
				'order_num'   => 'order_num',
				'unit'		  => 'unit',
				'p_time'	  => 'p_time',
				'addtime'     => 'addtime',
				'uptime'      => 'uptime',
				'descr'       => 'descr',
		);
	}
	
	public function initialize()
	{
		$this->useDynamicUpdate( true );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
	}
	
	public function getSource()
	{
		return "stat_user";
	}
	
}

?>