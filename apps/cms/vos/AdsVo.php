<?php

namespace apps\cms\vos;

/**
 * 广告
 * @author Carey
 * @date 2015-10-22
 */
class AdsVo {
	
	/**
	 * 广告id
	 * @var integer
	 */
	public $id;
	
	/**
	 * 
	 * @var integer
	 */
	public $media_type;
	
	/**
	 * 广告名称
	 * @var string
	 */
	public $name;
	
	/**
	 * 链接地址
	 * @var string
	 */
	public $url;
	
	/**
	 * 开始时间
	 * @var integer
	 */
	public $begin_time;
	
	/**
	 * 失效时间
	 * @var integer
	 */
	public $end_time;
	
	/**
	 * 点击次数
	 * @var integer
	 */
	public $click_count;
	
	/**
	 * 是否开启
	 * @var integer
	 */
	public $enabled;
	
	/**
	 *  分类id
	 * @var integer
	 */
	public $cat_id;
	
	/**
	 * 排序位置
	 * @var integer
	 */
	public $sort_order;
	
	/**
	 * 标题
	 * @var string
	 */
	public $title;
	
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
	 * 
	 * @var integer
	 */
	public $click_left;
	
	/**
	 * 
	 * @var int
	 */
	public $cid;
	
	/**
	 * 
	 * @var integer
	 */
	public $weight;
	
	/**
	 * 添加人id
	 * @var integer
	 */
	public $user_id;
	
	/**
	 * 描述
	 * @var string
	 */
	public $descr;
	
	/**
	 * 添加时间
	 * @var string
	 */
	public $addtime;
	
	/**
	 * 
	 * @var string
	 */
	public $src;
	
	/**
	 * 关联商铺id
	 * @var integer
	 */
	public $shopid;
	
	/**
	 * 是否允许追踪
	 * @var integer
	 */
	public $nofollow;
	
	
	
// 	public function __construct( $id, $delsign, $addtime, $uptime, $media_type, $name, $url, $begin_time, $end_time, $click_count, $enabled, $cat_id, $sort_order, $title, $click_left, $weight, $cid, $descr, $src, $shopid, $nofollow )
// 	{
// 		$this->id 			= $id;
// 		$this->delsign		= $delsign;
// 		$this->addtime		= $addtime;
// 		$this->uptime		= $uptime;
// 		$this->media_type	= $media_type;
// 		$this->name			= $name;
// 		$this->url			= $url;
// 		$this->begin_time	= $begin_time;
// 		$this->end_time		= $end_time;
// 		$this->click_count	= $click_count;
// 		$this->enabled		= $enabled;
// 		$this->cat_id		= $cat_id;
// 		$this->sort_order	= $sort_order;
// 		$this->title		= $title;
// 		$this->click_left	= $click_left;
// 		$this->weight		= $weight;
// 		$this->cid			= $cid;
// 		$this->descr		= $descr;
// 		$this->src			= $src;
// 		$this->shopid		= $shopid;
// 		$this->nofollow		= $nofollow;
		
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