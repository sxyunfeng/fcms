<?php

namespace apps\admin\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

/**
 * 页面缓存
 * @author Carey
 * @date 2015-10-30
 */
class StaticCache extends Model{
	
	/**
	 *
	 * @var integer
	 */
	public $id;
	
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
	 * @var integer
	 */
	public $delsign;
	
	/**
	 *
	 * @var string
	 */
	public $descr;
	
	
	/**
	 *
	 * @var string
	 */
	public $name;
	
	
	/**
	 *
	 * @var integer
	 */
	public $cache_time;
	
	/**
	 *
	 * @var integer
	 */
	public $type;
	
	/**
	 * @var string
	 * @return multitype:string
	 */
	public $cfgtype;
	
	/**
	 * @var string
	 * @return multitype:string
	 */
	public $prefix;
	
	
	public function columnMap()
	{
		return array(
			'id'         => 'id',
			'addtime'    => 'addtime',
			'uptime'     => 'uptime',
			'delsign'    => 'delsign',
			'descr'      => 'descr',
			'name'       => 'name',
			'cache_time' => 'cache_time',
			'type'       => 'type',
			'cfgtype'	 => 'cfgtype',
			'prefix'	 => 'prefix',
		);
	}
	
	public function initialize()
	{
		$this->useDynamicUpdate( TRUE );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
		
		$this->setSource( 'cache_static_manage' );
	}
	
	
}

?>