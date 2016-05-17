<?php

namespace apps\admin\models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

/**
 * 文件安全
 * @author Carey
 * date 2015/9/2
 */
class FileSecurity extends Model{
	
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
	public $filename;
	
	/**
	 *
	 * @var string
	 */
	public $hashname;
	
	/**
	 * @var string
	 */
	public $filepath;
	
	/**
	 * @var tinyint
	 */
	public $status;
	
	/**
	 * @var string
	 */
	public $opttime;
	
	
	public function initialize()
	{
		$this->useDynamicUpdate( TRUE );
		
        $this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );

	}
	
	public function columnMap()
	{
		return array(
				'id' 		=> 'id',
				'addtime' 	=> 'addtime',
				'uptime' 	=> 'uptime',
				'delsign' 	=> 'delsign',
				'descr' 	=> 'descr',
				'filename' 	=> 'filename',
				'hashname' 	=> 'hashname',
				'filepath'	=> 'filepath',
				'status'	=> 'status',
				'opttime'	=> 'opttime',
		);
	}
	
	public function getSource()
	{
		return "sec_file";
	}
	
}

?>