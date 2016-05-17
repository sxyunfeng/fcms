<?php

namespace apps\cms\vos;

class MenuVO {
	
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
	 * @var int
	 */
	public $cid;
	
	/**
	 * @var int
	 */
	public $pid;
	
	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $url;
	
	/**
	 * @var int
	 */
	public $relid;
	
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
	
// 	public function __construct( $id, $uptime, $addtime, $delsign, $descr, $cid, $pid, $name, $url, $relid, $target, $icon, $is_show )
// 	{
// 		$this->id		= $id;
// 		$this->uptime	= $uptime;
// 		$this->addtime	= $addtime;
// 		$this->delsign	= $delsign;
// 		$this->descr	= $descr;
// 		$this->cid		= $cid;
// 		$this->pid		= $pid;
// 		$this->name		= $name;
// 		$this->url		= $url;
// 		$this->relid	= $relid;
// 		$this->target	= $target;
// 		$this->icon		= $icon;
// 		$this->is_show	= $is_show;
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