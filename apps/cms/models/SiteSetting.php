<?php

namespace apps\cms\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model;

/**
 * 站点配置表
 * @author Carey
 *
 */
class SiteSetting extends Model{
	
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
	public $domain;
	
	/**
	 * @var string
	 */
	public $logo;
	
	/**
	 * @var string
	 */
	public $seokey;
	
	/**
	 * @var string
	 */
	public $seodescr;
	
	/**
	 * @var string
	 */
	public $copyright;
	
	/**
	 * @var string
	 */
	public $static_code;
	
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
				'name'		=> 'name',
				'domain'	=> 'domain',
				'logo'		=> 'logo',
				'seokey'	=> 'seokey',
				'seodescr'	=> 'seodescr',
				'copyright'	=> 'copyright',
				'static_code'=>'static_code',
				'is_main'	=> 'is_main',
		);
	}
	
	public function initialize()
	{
		$this->useDynamicUpdate( true );
		
		$this->setSource( 'pri_site_setting' );
	}
}

?>