<?php

namespace apps\admin\models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

class StatUserDistrict  extends Model{
	
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
	 * @var varchar
	 */
	public $province;

	/**
	 * @var int
	 */
	public $city;
	
	/**
	 * @var int
	 */
	public $p_num;
	
	/**
	 * @var varchar
	 */
	public $percent;
	
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
	
	
	public function initialize()
	{
		$this->useDynamicUpdate( true );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
		
		$this->belongsTo( 'province' , '\apps\admin\models\CommonDistrictDic', 'id', array( 'alias' => 'district' ) );
		$this->belongsTo( 'city' , '\apps\admin\models\CommonDistrictDic', 'id', array( 'alias' => 'city_info' ) );
	}
	
	public function columnMap()
	{
		return array(
				'id'          => 'id',
				'delsign'     => 'delsign',
				'province'	  => 'province',
				'city'		  => 'city',
				'p_num'  	  => 'p_num',
				'percent'  	  => 'percent',
				'unit'		  => 'unit',
				'p_time'	  => 'p_time',
				'addtime'     => 'addtime',
				'uptime'      => 'uptime',
				'descr'       => 'descr',
		);
	}
	
	public function getSource()
	{
		return 'stat_user_district';
	}
	
}

?>