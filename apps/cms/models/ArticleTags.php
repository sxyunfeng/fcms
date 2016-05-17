<?php

namespace apps\cms\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model;

/**
 * 文章标签 - tags
 * @author Carey
 * date 2015-10-15
 */
class ArticleTags  extends Model{
	
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
	public $seo;
	
	/**
	 * @var string
	 */
	public $seokey;
	
	/**
	 * @var string
	 */
	public $seodescr;
	
	/**
	 * @var int
	 */
	public $display;
	
	/**
	 * @var string
	 */
	public $pinyin;
	
	/**
	 * @var string
	 */
	public $fname;
	
	/**
	 * @var string
	 */
	public $linkurl;
	
	/**
	 * @var int
	 */
	public $sort;
	
	/**
	 * @var int
	 */
	public $aid; 
	
	
	public function columnMap()
	{
		return array(
			'id'        => 'id',
			'addtime'   => 'addtime',
			'uptime'    => 'uptime',
			'delsign'   => 'delsign',
			'descr'     => 'descr',
			'name'      => 'name',
			'seo'		=> 'seo',
			'seokey'	=> 'seokey',
			'seodescr'	=> 'seodescr',
			'display'	=> 'display',
			'pinyin'	=> 'pinyin',
			'fname'		=> 'fname',
			'linkurl'	=> 'linkurl',
			'sort'		=> 'sort',
			'aid'		=> 'aid',
		);
	}
	
	public function initialize()
	{
		$this->useDynamicUpdate( TRUE );
		
		$this->belongsTo( 'aid' , '\apps\admin\models\Articles' , 'id', array( 'alias' => 'articletags' ) );
		$this->setSource( 'xuxu_articles_tags' );
	}
	
}

?>