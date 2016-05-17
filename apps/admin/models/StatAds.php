<?php

namespace apps\admin\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

/**
 * 广告点击率表
 * @author Carey
 *
 */
class StatAds extends Model{
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
	public $click_num;
	
	/**
	 * @var int
	 */
	public $all_mem;
	
	/**
	 * @var int
	 */
	public $female_num;
	
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
	
	
	public function initialize()
	{
		$this->useDynamicUpdate( true );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
	}
	
	public function columnMap()
	{
		return array(
				'id'          => 'id',
				'delsign'     => 'delsign',
				'click_num'	  => 'click_num',
				'female_num'  => 'female_num',
				'all_mem'  	  => 'all_mem',
				'unit'		  => 'unit',
				'p_time'	  => 'p_time',
				'addtime'     => 'addtime',
				'uptime'      => 'uptime',
				'descr'       => 'descr',
		);
	}
	
	public function getSource()
	{
		return 'stat_ads';
	}
}

?>