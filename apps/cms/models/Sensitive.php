<?php

namespace apps\cms\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model;

/**
 * 敏感词
 * @author Carey
 *
 */
class Sensitive extends Model{
	
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
	public $word;
	
	/**
	 * @var string
	 */
	public $rword;
	
	/**
	 * @var int
	 */
	public $uid;
	
	public function columnMap()
	{
		return array(
			'id'        => 'id',
			'addtime'   => 'addtime',
			'uptime'    => 'uptime',
			'delsign'   => 'delsign',
			'descr'     => 'descr',
			'word'      => 'word',
			'rword'		=> 'rword',
			'uid'		=> 'uid',
		);
	}
	
	public function initialize()
	{
		$this->useDynamicUpdate( TRUE );
		
		$this->belongsTo( 'uid' , '\apps\admin\models\PriUsers' , 'id' , array( 'alias' => 'adminuser' ) );
		
		$this->setSource( 'xuxu_sens_wd' );
	}
	
	
}

?>