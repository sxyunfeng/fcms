<?php

namespace apps\admin\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

/**
 * 前台菜单分类
 * @author Carey
 * @date 2015-10-20
 */
class MenuCategory extends Model{
	
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
	public $name;
	
	/**
	 * @var int
	 */
	public $is_main;
	
	
	
	public function columnMap()
	{
		return array(
			'id'        => 'id',
			'addtime'   => 'addtime',
			'uptime'    => 'uptime',
			'delsign'   => 'delsign',
			'descr'     => 'descr',
			'name'      => 'name',
			'is_main'	=> 'is_main',
		);
	}
	
	public function initialize()
	{
		$this->useDynamicUpdate( true );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
		
		$this->hasMany( 'id' , '\apps\admin\models\Menu' , 'cid' , array( 'alias' => 'menucate' ) );
		$this->setSource( 'xuxu_menu_category' );
	}
	
}

?>