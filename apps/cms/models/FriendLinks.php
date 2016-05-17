<?php

namespace apps\cms\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model;

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
	public $logo;
	
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
			'logo'		=> 'logo',
			'sort'		=> 'sort',
		);
	}
	
	public function initialize()
	{
		$this->useDynamicUpdate( true );
		
		$this->setSource( 'xuxu_friendly_links' );
	}
}

?>