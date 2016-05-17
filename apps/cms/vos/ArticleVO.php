<?php
namespace apps\cms\vos;

/**
 * 文章
 * @author Carey
 * @date 2015-10-22
 */
class ArticleVO 
{
	/**
	 * 文章主键
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
	 * 文章标题
	 * @var string
	 */
	public $title;
	
	/**
	 * 文章描述
	 * @var string
	 */
	public $description;
	
	/**
	 * 分类id
	 * @var integer
	 */
	public $cat_id;
	
	/**
	 * 文章内容
	 * @var string
	 */
	public $content;
	
	/**
	 * 文章状态
	 * @var integer
	 */
	public $status;
	
	/**
	 * 开始时间
	 * @var string
	 */
	public $begin_time;
	
	/**
	 * 结束时间
	 * @var string
	 */
	public $end_time;
	
	/**
	 * 是否置顶
	 * @var integer
	 */
	public $top;
	
	/**
	 * 文章作者
	 * @var string
	 */
	public $author;
	
	/**
	 * 文章关键字
	 * @var string
	 */
	public $keywords;
	
	/**
	 * 文章 face
	 */
	public $face;
	
	
// 	public function __construct( $id, $uptime, $addtime, $delsign, $descr, $title, $description, $cat_id, $content, $status, $begin_time, $end_time, $top, $author, $keywords, $face )
// 	{
// 		$this->id		= $id;
// 		$this->uptime	= $uptime;
// 		$this->addtime	= $addtime;
// 		$this->delsign	= $delsign;
// 		$this->descr	= $descr;
// 		$this->title	= $title;
// 		$this->description = $description;
// 		$this->cat_id	= $cat_id;
// 		$this->content	= $content;
// 		$this->status	= $status;
// 		$this->begin_time = $begin_time;
// 		$this->end_time	  = $end_time;
// 		$this->top		= $top;
// 		$this->author	= $author;
// 		$this->keywords = $keywords;
// 		$this->face		= $face;
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