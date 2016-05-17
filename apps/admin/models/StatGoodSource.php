<?php

namespace apps\admin\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

class StatGoodSource extends Model{
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
	
	/**
	 * @var int
	 */
	public $baidu;
	
	/**
	 * @var int
	 */
	public $sougou;
	
	/**
	 * @var int
	 */
	public $google;
	
	/**
	 * @var int
	 */
	public $qihu;
	
	/**
	 * @var int
	 */
	public $g_id;
	
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
				'unit'		  => 'unit',
				'p_time'	  => 'p_time',
				'addtime'     => 'addtime',
				'uptime'      => 'uptime',
				'descr'       => 'descr',
				'baidu'		  => 'baidu',
				'sougou'	  => 'sougou',
				'google'	  => 'google',
				'qihu'		  => 'qihu',
				'g_id'		  => 'g_id',
		);
	}
	
	public function getSource()
	{
		return 'stat_source_good';
	}
	
}

?>