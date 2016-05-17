<?php

namespace apps\admin\models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

/**
 * 静态缓存配置
 * @author Carey
 * @date  2015-11-09
 */
class CacheMgrConfig extends Model{
	
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
	 * @var string
	 */
	public $index;
	
	/**
	 * @var string
	 */
	public $list;
	
	/**
	 * @var string
	 */
	public $detail;
	
	/**
	 * @var int
	 */
	public $type;
	
	public function columnMap()
	{
		return array(
			'id'         => 'id',
			'addtime'    => 'addtime',
			'uptime'     => 'uptime',
			'delsign'    => 'delsign',
			'descr'      => 'descr',
			'index'      => 'index',
			'list'     	 => 'list',
			'detail'	 => 'detail',
			'type'		 => 'type',
		);
	}
	
	public function initialize()
	{
		$this->useDynamicUpdate( TRUE );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
		
		$this->setSource( 'cache_manage_config' ); 
	}
	
	
}

?>