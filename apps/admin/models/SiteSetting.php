<?php

namespace apps\admin\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

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
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
		
		$this->setSource( 'pri_site_setting' );
	}
}

?>