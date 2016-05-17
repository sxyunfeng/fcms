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
class PageCache extends Model{
	
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
	public $cname;
	
	
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
	 *
	 * @var integer
	 */
	public $is_warm_up;
	
	/**
	 *
	 * @var integer
	 */
	public $module;
	
	
	public function columnMap()
	{
		return array(
			'id'         => 'id',
			'addtime'    => 'addtime',
			'uptime'     => 'uptime',
			'delsign'    => 'delsign',
			'descr'      => 'descr',
			'cname'      => 'cname',
			'cache_time' => 'cache_time',
			'type'       => 'type',
			'is_warm_up' => 'is_warm_up',
			'module'     => 'module'
		);
	}
	
	public function initialize()
	{
		$this->useDynamicUpdate( TRUE );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
		
		$this->setSource( 'cache_page_manage' );
	}
	
	
}

?>