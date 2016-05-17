<?php

namespace apps\cms\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model;
/**
 * 前台菜单表
 * @author Carey
 * @date 2015-10-20
 */
class Menu extends Model{
	
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
	 * @var int
	 */
	public $cid;
	
	/**
	 * @var pid
	 */
	public $pid;
	
	/**
	 * @var String
	 */
	public $name;
	
	/**
	 * @var string
	 */
	public $url;
	
	/**
	 * @var int
	 */
	public $target;
	
	/**
	 * @var string
	 */
	public $icon;
	
	/**
	 * @var int
	 */
	public $is_show;
	
	/**
	 * @var int
	 */
	public $relid;
	
	/**
	 * @var int
	 */
	public $sort;
	
	public function columnMap()
	{
		return array(
				'id'        => 'id',
				'addtime'   => 'addtime',
				'uptime'    => 'uptime',
				'delsign'   => 'delsign',
				'descr'     => 'descr',
				'cid'		=> 'cid',
				'pid'		=> 'pid',
				'name'      => 'name',
				'url'		=> 'url',
				'target'	=> 'target',
				'icon'		=> 'icon',
				'is_show'	=> 'is_show',
				'relid'		=> 'relid',
				'sort'		=> 'sort',
		);
	}
	
	public function initialize()
	{
		$this->useDynamicUpdate( true );
		
		$this->belongsTo( 'cid' , '\apps\admin\models\MenuCategory', 'id', array( 'alias' => 'menu' ) );
		$this->belongsTo( 'relid' , '\apps\admin\models\ArticleCats', 'id', array( 'alias' => 'acate' ) );
		$this->setSource( 'xuxu_menu' );
	}
	
}

?>