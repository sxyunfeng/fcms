<?php

namespace apps\cms\vos;

/**
 * 文章tags
 * @author Carey
 * @date 2015-10-22
 */
class TagsVo {
	
	/**
	 * tag id
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
	 * 名称
	 * @var string
	 */
	public $name;
	
	/**
	 * seo
	 * @var string
	 */
	public $seo;
	
	/**
	 * seo 关键字
	 * @var string
	 */
	public $seokey;
	
	/**
	 * seo 描述
	 * @var string
	 */
	public $seodescr;
	
	/**
	 * 是否启用
	 * @var int
	 */
	public $display;
	
	/**
	 * tag 拼音
	 * @var string
	 */
	public $pinyin;
	
	/**
	 * tag 首字母
	 * @var string
	 */
	public $fname;
	
	/**
	 * tag 链接地址
	 * @var string
	 */
	public $linkurl;
	
	/**
	 * tag 排序
	 * @var int
	 */
	public $sort;
	
	/**
	 * 文章id
	 * @var int
	 */
	public $aid;
	
// 	public function __construct($id, $delsign, $addtime, $uptime, $descr, $name, $seo, $seokey, $seodescr, $display, $pinyin, $fname, $linkurl, $aid, $sort)
// 	{
// 		$this->id		= $id;
// 		$this->delsign	= $delsign;
// 		$this->addtime	= $addtime;
// 		$this->uptime	= $uptime;
// 		$this->descr	= $descr;
// 		$this->name		= $name;
// 		$this->seo		= $seo;
// 		$this->seokey	= $seokey;
// 		$this->seodescr	= $seodescr;
// 		$this->display	= $display;
// 		$this->pinyin	= $pinyin;
// 		$this->fname	= $fname;
// 		$this->linkurl	= $linkurl; 
// 		$this->aid		= $aid;
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