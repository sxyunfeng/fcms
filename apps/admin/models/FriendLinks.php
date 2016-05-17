<?php

namespace apps\admin\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

/**
 * 友情链接
 * 
 * @author Carey
 * date 2015/10/22
 */
class FriendLinks extends Model{
	
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
	 * @var string
	 */
	public $title;
	
	/**
	 * @var int
	 */
	public $nofollow;
	
	/**
	 * @var string
	 */
	public $url;
	
	/**
	 * @var int
	 */
	public $sort;
	
	/**
	 * @var string
	 */
	public $icon;
	
	/**
	 * @var int
	 */
	public $target;
	
	
	public function columnMap()
	{
		return array(
			'id' 		=> 'id',
			'addtime' 	=> 'addtime',
			'uptime' 	=> 'uptime',
			'delsign' 	=> 'delsign',
			'descr' 	=> 'descr',
			'name'		=> 'name',
			'title'		=> 'title',
			'nofollow'	=> 'nofollow',
			'target'	=> 'target',
			'url'		=> 'url',
			'icon'		=> 'icon',
			'sort'		=> 'sort',
		);
	}
	
	public function initialize()
	{
		$this->useDynamicUpdate( TRUE );
		
        $this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
		
		$this->setSource( 'xuxu_friendly_links' );
	}
}

?>