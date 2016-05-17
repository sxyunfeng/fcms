<?php

namespace apps\cms\vos;

/**
 * 友情链接
 * @author Carey
 * @date 2015-10-23
 */
class FriendLinkVO {
	
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
	public $title;
	
	/**
	 * @var int
	 */
	public $nofollow;
	
	/**
	 * @var int
	 */
	public $target;
	
	/**
	 * @var string
	 */
	public $logo;
	
	/**
	 * @var string
	 */
	public $url;
	
	/**
	 * @var int
	 */
	public $sort;
	
	
// 	public function __construct( $id, $delsign, $addtime, $uptime, $descr, $name, $title, $nofollow, $target, $logo, $url, $sort )
// 	{
// 		$this->id		= $id;
// 		$this->delsign	= $delsign;
// 		$this->addtime	= $addtime;
// 		$this->uptime	= $uptime;
// 		$this->descr	= $descr;
// 		$this->name		= $name;
// 		$this->title	= $title;
// 		$this->nofollow = $nofollow;
// 		$this->target	= $target;
// 		$this->logo		= $logo;
// 		$this->url		= $url;
// 		$this->sort		= $sort;
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