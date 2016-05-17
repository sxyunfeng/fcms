<?php

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use apps\admin\models\ArticleTags;
use libraries\TimeUtils;
use libraries\pin;
use apps\admin\models\Articles;

/**
 * 文章tags 管理
 * @author Carey
 * time 2015-10-14
 */
class ArticlestagsController extends AdminBaseController{
	
	public function initialize()
	{
		parent::initialize();
	}
	
	/**
     * @author( author='Carey' )
     * @date( date = '2015.10.14' )
     * @comment( comment = 'tags列表' )
     * @method( method = 'indexAction' )
     * @op( op = 'r' )
     */
	public function indexAction()
	{
		$pageNum = $this->request->getQuery( 'page', 'int' );
		$currentPage = $pageNum ? $pageNum : 1;
		
		$where = array(
			'column'	=> 'id,addtime,uptime,delsign,name,pinyin,display',
			'conditions'=> 'delsign=:del: ORDER BY uptime DESC,sort ASC',
			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
		);
		$res = ArticleTags::find( $where );
		$pagination = new PaginatorModel( array(
				'data' => $res,
				'limit' => 15,
				'page' => $currentPage
		));
		$page = $pagination->getPaginate();
		
		$this->view->page = $page;
		
	}
	
	
	/**
     * @author( author='Carey' )
     * @date( date = '2015.10.14' )
     * @comment( comment = '添加/更新 tags page' )
     * @method( method = 'indexAction' )
     * @op( op = 'r' )
     */
	public function optionPageAction()
	{
		$optid = $this->dispatcher->getParam( 'id' );
		if( false != $optid )
		{
			$where = array(
					'conditions'	=> 'delsign=:del: and id=:optid:',
					'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $optid ),
			);
			$tag  = ArticleTags::findFirst( $where );
			
			$this->view->res = $tag;
		}
	}
	
	
	/**
	 * @author( author='Carey' )
     * @date( date = '2015.10.14' )
     * @comment( comment = '保存tag信息' )
     * @method( method = 'saveAction' )
     * @op( op = 'r' )
	 */
	public function saveAction()
	{
		$Pinyin = new pin();
		
		$strTag = $this->request->getPost( 'tagname' );
		$strSEO = $this->request->getPost( 'seotitle' );
		$strSEOKey = $this->request->getPost( 'seokey' );
		$strSEODescr = $this->request->getPost( 'seodescr' );
		$iDisplay = $this->request->getPost( 'show' );
		$strPinyin = $this->request->getPost( 'pinyin' );
		$strFname  = $this->request->getPost( 'fname' );
		$strLinkurl = $this->request->getPost( 'linkurl' );
		$iSort = $this->request->getPost( 'sort' );
		$iId = $this->request->getPost( 'id' );
		
		if( false != $iId )
		{//更新
			$where = array(
				'conditions'	=> 'delsign=:del: and id=:optid:',
				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $iId ),
			);
			$tag  = ArticleTags::findFirst( $where );
			if( count( $tag ) > 0 )
			{
				$tag->name 	= $strTag;
				$tag->seo  	= $strSEO;
				$tag->seokey 	= $strSEOKey;
				$tag->seodescr = $strSEODescr;
				$tag->display = $iDisplay;
				$tag->pinyin  = $strPinyin?$strPinyin:$Pinyin->Pinyin( $strTag , 'UTF-8' );
				$tag->fname   = $strFname?$strFname:mb_substr( $Pinyin->Pinyin( $strTag , 'UTF-8' ), 0, 1, 'UTF-8' );
				$tag->linkurl = $strLinkurl?$strLinkurl:'http://www.huaer.dev';
				$tag->uptime = TimeUtils::getFullTime();
				$tag->sort  = $iSort;
				if( false != $tag->save() )
				{//成功
					$this->response->redirect( '/admin/ArticlesTags/index' );
				}
				else
				{//失败
					$this->response->redirect( '/admin/ArticlesTags/index' );
				}
				
				$this->view->disable();
			}
		}
		else 
		{//插入
			$tags = new ArticleTags();
			$tags->delsign = SystemEnums::DELSIGN_NO;
			$tags->name 	= $strTag;
			$tags->seo  	= $strSEO;
			$tags->seokey 	= $strSEOKey;
			$tags->seodescr = $strSEODescr;
			$tags->display = $iDisplay;
			$tags->pinyin  = $strPinyin?$strPinyin:$Pinyin->Pinyin( $strTag , 'UTF-8' );
			$tags->fname   = $strFname?$strFname:mb_substr( $Pinyin->Pinyin( $strTag , 'UTF-8' ), 0, 1, 'UTF-8' );
			$tags->linkurl = $strLinkurl?$strLinkurl:'http://www.huaer.dev';
			$tags->addtime = $tags->uptime = TimeUtils::getFullTime();
			$tags->sort  = $iSort;
			if( false != $tags->save() )
			{//成功
				$this->response->redirect( '/admin/ArticlesTags/index' );
			}
			else
			{//失败
				$this->response->redirect( '/admin/ArticlesTags/index' );
			}
			
			$this->view->disable();
		}
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.10.14' )
	 * @comment( comment = '删除tag信息' )
	 * @method( method = 'deleteAction' )
	 * @op( op = 'r' )
	 */
	public function deleteAction()
	{
		$objRet = new \stdClass();
		$optid = $this->dispatcher->getParam( 'id' );
		if( false == $optid )
		{
			$objRet->state = 1;
			$objRet->msg = '参数错误,请刷新后再试.';
			echo json_encode( $objRet );
			exit;
		}
		
		$where = array(
			'conditions'	=> 'delsign=:del: and id=:optid:',
			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $optid ),
		);
		$tag  = ArticleTags::findFirst( $where );
		if( count( $tag ) > 0 )
		{
			$tag->delete();
			$objRet->state = 0;
			$objRet->optid = $optid;
			$objRet->msg = '删除Tag标记成功.';
		}
		else
		{
			$objRet->state = 1;
			$objRet->msg = '操作失败,数据未找到.';
		}
		
		echo json_encode( $objRet );
		
	}
	
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015.10.14' )
	 * @comment( comment = '对tag信息查询' )
	 * @method( method = 'searchAction' )
	 * @op( op = 'r' )
	 */
	public function searchAction()
	{
		$objRet = new \stdClass();
		
		$pageNum = $this->request->getQuery( 'page', 'int' );
		$currentPage = $pageNum ? $pageNum : 1;
		
		$keys = $this->dispatcher->getParam( 'key' );
		if( false == $keys )
		{
			$objRet->state = 1;
			$objRet->msg = '请输入文章标签或文章标题查找,查找内容不能为空.';
			
			echo json_encode( $objRet );
			exit;
		}
		
		//先找文章 列出 id
		$arrAtcIds = array();
		$arrArtWhere = array(
			'column'	=> 'id,title,delsign,status',
			'conditions'=> 'delsign=:del: and title like :tit:',
			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'tit' => '%'.$keys.'%' )
		);
		$art = Articles::find( $arrArtWhere );
		if( count( $art ) > 0 )
		{
			foreach ( $art as $row )
			{
				array_push( $arrAtcIds , $row->id );
			}
		}
		
		//tag 里匹配 - 拼音/首字母/tag名称
		if( isset( $arrAtcIds ) && !empty( $arrAtcIds ) )
		{
			$phsql = 'SELECT t.id as tid, t.delsign,t.name,t.pinyin,t.fname,t.addtime,t.uptime,t.aid,a.id,a.title FROM apps\admin\models\ArticleTags AS t JOIN apps\admin\models\Articles AS a ' .
					 'ON a.id = t.aid WHERE a.delsign='.SystemEnums::DELSIGN_NO.' AND ( a.title LIKE \'%'.$keys.'%\' OR t.name LIKE \'%'.$keys.'%\' OR t.pinyin LIKE \'%'.$keys.'%\' OR t.fname="'.$keys.'") ' .
					 'AND t.aid in ('.implode( $arrAtcIds, ',' ).')';
		}
		else
		{
			$phsql = 'SELECT t.id as tid, t.delsign,t.name,t.pinyin,t.fname,t.addtime,t.uptime,t.aid,a.id,a.title FROM apps\admin\models\ArticleTags AS t JOIN apps\admin\models\Articles AS a ' .
					'ON a.id = t.aid WHERE a.delsign='.SystemEnums::DELSIGN_NO.' AND (t.name LIKE \'%'.$keys.'%\' OR t.pinyin LIKE \'%'.$keys.'%\' OR t.fname="'.$keys.'") ';
		}
		$tags = $this->modelsManager->executeQuery( $phsql );
		if( count( $tags ) > 0 )
		{
			$objRet->state = 0;
			$data = array();
			foreach( $tags as $k=>$row )
			{
				$data[$k] = $row;
			}
			$objRet->res = $data;
		}
		else
		{
			$objRet->state = 1;
			$objRet->msg = '未找到相关信息';
		}
		$objRet->key = $keys;
		
		echo json_encode( $objRet );
	}
	
}

?>