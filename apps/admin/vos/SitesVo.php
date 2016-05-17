<?php

namespace apps\admin\vos;

/**
 * 站点配置
 * @author Carey
 * @date 2015-10-23
 */
class SitesVo {
	
	/**
	 *  id
	 * @var integer
	 */
	public $id;
	
	/**
	 * 添加时间
	 * @var string
	 */
	public $addtime;
	
	/**
	 * 更新时间
	 * @var string
	 */
	public $uptime;
	
	/**
	 * 删除标记
	 * @var integer
	 */
	public $delsign;
	
	/**
	 * 备注信息
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
	
// 	public function __construct( $id, $delsign, $addtime, $uptime, $descr, $name, $domian, $logo, $seokey, $seodescr, $copyright, $static_code, $is_main )
// 	{
// 		$this->id		=$id;
// 		$this->delsign	= $delsign;
// 		$this->addtime	= $addtime;
// 		$this->uptime	= $uptime;
// 		$this->descr	= $descr;
// 		$this->name		= $name;
// 		$this->domain	= $domian;
// 		$this->logo		= $logo;
// 		$this->seokey	= $seokey;
// 		$this->seodescr	= $seodescr;
// 		$this->copyright= $copyright;
// 		$this->static_code= $static_code;
// 		$this->is_main	= $is_main;
// 	}

	public function setData( $data )
	{
		if( false == $data || empty( $data ) )
			return false;
	
	
		foreach( $data as $key=>$row )
		{
			$this->$key = $row;
		}
	}
	
}

?>