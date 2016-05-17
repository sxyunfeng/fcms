<?php

namespace apps\cms\vos;

class ArticleCateVO {
	
	/**
	 * 主键
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
	 * 描述
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
	 * @var string
	 */
	public $keywords;
	
	/**
	 * @var int
	 */
	public $type;
	
	/**
	 * @var string
	 */
	public $description;
	
	/**
	 * @var int
	 */
	public $nofollow;
	
	/**
	 * @var string
	 */
	public $img;
	
	/**
	 * @var int
	 */
	public $parent_id;
	
	
	
// 	public function __construct( $id, $addtime, $uptime, $delsign, $descr, $name, $title, $keywords, $type, $description, $nofollow, $img, $parent_id )
// 	{
// 		$this->id		= $id;
// 		$this->addtime	= $addtime;
// 		$this->uptime	= $uptime;
// 		$this->delsign	= $delsign;
// 		$this->descr	= $descr;
// 		$this->name		= $name;
// 		$this->title	= $title;
// 		$this->keywords	= $keywords;
// 		$this->type		= $type;
// 		$this->description = $description;
// 		$this->nofollow	= $nofollow;
// 		$this->img		= $img;
// 		$this->parent_id = $parent_id;
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