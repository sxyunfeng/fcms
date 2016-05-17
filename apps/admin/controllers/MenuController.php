<?php

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\SystemEnums;
use apps\admin\models\MenuCategory;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use libraries\TimeUtils;
use apps\admin\models\Menu;
use apps\admin\models\ArticleCats;
use apps\admin\models\PriPris;

/**
 * 菜单管理 （ 前/后 端菜单 ）
 * @author Carey
 * @time 2015-10-20
 */
class MenuController extends AdminBaseController{
	
	
	public function initialize()
	{
		parent::initialize();
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-20' )
	 * @comment( comment = '菜单分类' )
	 * @method( method = 'categoryAction' )
	 * @op( op = 'r' )
	 */
	public function categoryAction()
	{
		$pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;
        
		$where = array(
			'select'	=> 'id,delsign,uptime,addtime,name,is_main',
			'conditions'=> 'delsign=:del: ORDER BY is_main ASC, uptime DESC',
			'bind'		=>array( 'del' => SystemEnums::DELSIGN_NO ),
		);
		$res = MenuCategory::find( $where );
		$pagination = new PaginatorModel( array(
				'data'  => $res,
				'limit' => 15,
				'page'  => $currentPage
		) );
		$page = $pagination->getPaginate();
		$this->view->page = $page;
		
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-20' )
	 * @comment( comment = '添加菜单分类' )
	 * @method( method = 'addCategoryAction' )
	 * @op( op = 'r' )
	 */
	public function addCategoryAction()
	{
		
	}
	
	/**
	* @author( author='Carey' )
	* @date( date = '2015-10-20' )
	* @comment( comment = '更新菜单分类' )
	* @method( method = 'upcmenusAction' )
	* @op( op = 'r' )
	*/
	public function upcmenusAction()
	{
		$iOpt = $this->dispatcher->getParam( 'id' );
		if( false == $iOpt )
		{
			$this->response->redirect( '/admin/menu/category' );
			exit;
		}
		$where = array(
			'conditions'	=> 'delsign=:del: and id=:optid:',
			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $iOpt ),
		);
		$res = MenuCategory::findFirst( $where );
		if( count( $res ) > 0 )
		{
			$this->view->setVar( 'res' , $res );
			$this->view->pick( 'menu/addCategory' );
		}
		else
			$this->response->redirect( '/admin/menu/addCategory' );
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-20' )
	 * @comment( comment = '添加/更新 菜单分类业务' )
	 * @method( method = 'saveBizAction' )
	 * @op( op = 'r' )
	 */
	public function saveBizAction()
	{
		$catname = $this->request->getPost( 'name' );
		$iMain   = $this->request->getPost( 'is_main' )?0:1;
		$iSign 	 = $this->request->getPost( 'id' );
		if( 0 == $iMain )
			$descr = '主导航';
		else
			$descr = '';
		
		if( false != $iSign )
		{
			$where = array(
					'conditions'	=> 'delsign=:del: and id=:optid:',
					'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $iSign ),
			);
			$cate = MenuCategory::findFirst( $where );
			if( count( $cate ) > 0 )
			{
				if( 0 == $iMain && $cate != $iMain )
				{
					$res = MenuCategory::find( array( 'delsign'=> SystemEnums::DELSIGN_NO ) );
					if( count( $res ) > 0 )
					{
						foreach ( $res as $row )
						{
							$row->is_main = 1;
							$row->descr   = '';
							$row->save();
						}
					}
				}
				
				$cate->uptime = TimeUtils::getFullTime();
				$cate->name   = $catname;
				$cate->is_main = $iMain;
				$cate->descr   = $descr;
				if( $cate->save() )
					$this->response->redirect( '/admin/menu/category' );
				else
					$this->response->redirect( '/admin/menu/upcmenus' );
			}
			else 
				$this->response->redirect( '/admin/menu/upcmenus' );
		}
		else
		{
			if( 0 == $iMain )
			{
				$res = MenuCategory::find( array( 'delsign'=> SystemEnums::DELSIGN_NO ) );
				if( count( $res ) > 0 )
				{
					foreach ( $res as $row )
					{
						$row->is_main = 1;
						$row->descr   = '';
						$row->save();
					}
				}
			}
			$cate = new MenuCategory();
			$cate->delsign = SystemEnums::DELSIGN_NO;
			$cate->addtime = $cate->uptime = TimeUtils::getFullTime();
			$cate->name = $catname;
			$cate->is_main = $iMain;
			$cate->descr = $descr;
			if( $cate->save() )
				$this->response->redirect( '/admin/menu/category' );
			else
				$this->response->redirect( '/admin/menu/addCategory' );
		}
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-20' )
	 * @comment( comment = '删除 菜单分类业务' )
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
			$objRet->msg = '参数未配置正确,请稍后再试.';
			echo json_encode( $objRet );
			exit;
		}
		
		$where = array(
				'conditions'	=> 'delsign=:del: and id=:optid:',
				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $optid ),
		);
		$res = MenuCategory::findFirst( $where );
		if( count( $res ) > 0 )
		{
			$mnum = $res->getMenucate();
			foreach( $mnum as $row )
			{
				$row->delete();
			}
			$res->delete();
			
			$where = array(
				'conditions'	=> 'delsign=:del:',
				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO  ),
			);
			$result = MenuCategory::findFirst( $where );
			if( count( $result ) > 0 && false != $result )
			{
				$result->is_main = 0;
				$result->descr = '主导航';
				$result->save();
				
				$objRet->mainid = $result->id;
			}
			else 
				$objRet->mainid = 0;
			
			$objRet->state = 0;
			$objRet->msg = '操作成功.';
			$objRet->optid = $optid;
		}
		else
		{
			$objRet->state = 1;
			$objRet->msg   = '数据为查找到,请刷新后在试.';
		}
	
		echo json_encode( $objRet );
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-20' )
	 * @comment( comment = '前台菜单' )
	 * @method( method = 'frontendAction' )
	 * @op( op = 'r' )
	 */
	public function frontendAction()
	{
		$where = array(
				'select'	=> 'id,name,delsign,is_name',
				'conditions'=> 'delsign=:del: and is_main=:main:',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'main' => 0 ),
		);
		$result = MenuCategory::findFirst( $where );
		if( false != $result && count( $result ) > 0 )
			$cid = $result->id;
		else 
			$cid = 0;
		
		$pageNum = $this->request->getQuery( 'page', 'int' );
		$currentPage = $pageNum ? $pageNum : 1;
	
		$where = array(
				'select'	=> 'id,delsign,uptime,addtime,cid,pid,name,url,target,icon,is_show,sort',
				'conditions'=> 'delsign=:del: and cid=:cid: ORDER BY pid ASC,sort DESC, uptime DESC',
				'bind'		=>array( 'del' => SystemEnums::DELSIGN_NO, 'cid' => $cid ),
		);
		$res = Menu::find( $where );
		$pagination = new PaginatorModel( array(
				'data'  => $res,
				'limit' => 15,
				'page'  => $currentPage
		) );
		$page = $pagination->getPaginate();
		foreach( $page->items as $row )
		{
			if( false == $row->pid )
				$row->pname = '/';
			else
			{
				$where = array(
						'conditions'=> 'delsign=:del: and id = :pid:',
						'bind'		=>array( 'del' => SystemEnums::DELSIGN_NO , 'pid' => $row->pid ),
				);
				$res = Menu::findFirst( $where );
				if( count( $res ) > 0 )
					$row->pname  = $res->name;
				else
					$row->pname  = '/';
			}
		}
		$this->view->page = $page;
		
		$cWhere = array(
				'select'	=> 'id,name,delsign,is_name',
				'conditions'=> 'delsign=:del: ORDER BY is_main ASC',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
		);
		$cate = MenuCategory::find( $cWhere );
		$this->view->cates = $cate;
		
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-20' )
	 * @comment( comment = '添加菜单页面' )
	 * @method( method = 'addmenusAction' )
	 * @op( op = 'r' )
	 */
	public function addmenusAction()
	{
		//菜单分类
		$cWhere = array(
			'select'	=> 'id,name,delsign,is_name',
			'conditions'=> 'delsign=:del: ORDER BY is_main ASC',
			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
		);
		$cate = MenuCategory::find( $cWhere );
		$this->view->cates = $cate;
		
		//默认分类下的菜单
		$cateWhere = array(
			'select'	=> 'id,name,delsign,is_name',
			'conditions'=> 'delsign=:del: AND is_main=:main:',
			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'main' => 0 ),
		);
		$category = MenuCategory::findFirst( $cateWhere );
		$iCateid = 0;
		if( count( $category ) > 0 )
			$iCateid = $category->id;

// 		$arrMenus = array();
		$dWhere = array(
			'select'	=> 'id,delsign,name,cid,pid',
			'conditions'=> 'delsign=:del: and cid=:cid:',
			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'cid' => $iCateid ),
		);
		$menu = Menu::find( $dWhere );
// 		if( count( $menu ) > 0 )
// 		{
// 			if( count( $menu ) > 0 )
// 			{
// 				foreach( $menu as $row )
// 				{
// 					if( 0 == $row->parent_id )
// 						$arrMenus[] = $row;
// 					else
// 					{
// 						foreach( $arrMenus as $men )
// 						{
// 							if( $row->parent_id == $men->id )
// 								$men->sub = $row;
// 						}
// 					}
// 				}
// 			}
// 		}
		$this->view->menus = $menu;
		
		//文章分类列表
//		$articles = array();
		$artWhere = array(
			'select'	=> 'id,name,delsign,parent_id',
			'conditions'=> 'delsign=:del:',
			'bind'		=> array( 'del'=> SystemEnums::DELSIGN_NO ),
		);
		$artList = ArticleCats::find( $artWhere );
// 		if( count( $artList ) > 0 )
// 		{
// 			foreach( $artList as $row )
// 			{
// 				if( 0 == $row->parent_id )
// 					$articles[] = $row;
// 				else 
// 				{
// 					foreach( $articles as $art )
// 					{
// 						if( $row->parent_id == $art->id )
// 							$art->sub = $row;
// 					}
// 				}
// 			}
// 		}
		$this->view->art_cat = $artList;
		
		//单页面列表
		
		
		$pid = $this->dispatcher->getParam( 'pid' );
		$this->view->parentid = $pid?$pid:0;
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-21' )
	 * @comment( comment = '更新菜单信息' )
	 * @method( method = 'upmenusAction' )
	 * @op( op = 'r' )
	 */
	public function upmenusAction()
	{
		$optid = $this->dispatcher->getParam( 'id' );
		if( false == $optid )
		{
			$this->response->redirect( '/admin/menu/addmenus' );
			exit;
		}
		
		$where = array(
				'conditions'=> 'delsign=:del: and id=:optid:',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'optid' => $optid ),
		);
		$res = Menu::findFirst( $where );
		if( count( $res ) > 0 )
			$this->view->setVar( 'res' , $res );

		//菜单分类
		$cWhere = array(
				'select'	=> 'id,name,delsign,is_name',
				'conditions'=> 'delsign=:del: ORDER BY is_main ASC',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO ),
		);
		$cate = MenuCategory::find( $cWhere );
		$this->view->setVar( 'cates', $cate );
		
		//默认分类下的菜单
		$cateWhere = array(
				'select'	=> 'id,name,delsign,is_name',
				'conditions'=> 'delsign=:del: AND is_main=:main:',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'main' => 0 ),
		);
		$category = MenuCategory::findFirst( $cateWhere );
		$iCateid = 0;
		if( count( $category ) > 0 )
			$iCateid = $category->id;
		
		$dWhere = array(
				'select'	=> 'id,delsign,name,cid,pid',
				'conditions'=> 'delsign=:del: and cid=:cid:',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'cid' => $iCateid ),
		);
		$menu = Menu::find( $dWhere );
		$this->view->setVar( 'menus', $menu );
		
		//文章分类列表
		$artWhere = array(
				'select'	=> 'id,name,delsign,parent_id',
				'conditions'=> 'delsign=:del:',
				'bind'		=> array( 'del'=> SystemEnums::DELSIGN_NO ),
		);
		$artList = ArticleCats::find( $artWhere );
		$this->view->setVar( 'art_cat', $artList );
		
		//单页面列表
		
		$this->view->setVar( 'parentid', false );
		$this->view->pick( 'menu/addmenus' );
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-21' )
	 * @comment( comment = '保存菜单信息' )
	 * @method( method = 'saveAction' )
	 * @op( op = 'r' )
	 */
	public function saveAction()
	{
		$cid = $this->request->getPost( 'catid' );
		$pid = $this->request->getPost( 'parentid' );
		$mname = $this->request->getPost( 'name' );
		$iSort  = $this->request->getPost( 'sort' );
		
		$isChk = $this->request->getPost( 'url' );
		$wirteUrl = $this->request->getPost( 'wirte_url' );
		$selectUrl = $this->request->getPost( 'select_url' );
		
		if( isset( $isChk ) &&  false != $wirteUrl )
		{
			$url = $wirteUrl;
			$relid = NULL;
		}
		else if( isset( $isChk ) && false !== $selectUrl )
		{
			$url = NULL;
			$relid = $selectUrl;
		}
		else
		{
			$url = NULL;
			$relid = NULL;
		}
		$target = $this->request->getPost( 'url_target' );
		$icon   = $this->request->getPost( 'icon' );
		$iShow  = $this->request->getPost( 'is_show' );
		$iSign  = $this->request->getPost( 'id' );
		if( false != $iSign )
		{
			$where = array(
				'conditions'=> 'delsign=:del: and id=:optid:',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'optid' => $iSign ),
			);
			$menu = Menu::findFirst( $where );
			if( count( $menu ) > 0 )
			{
				$menu->cid		= $cid;
				$menu->pid		= $pid;
				$menu->name		= $mname;
				$menu->url		= $url;
				$menu->relid	= $relid;
				$menu->target	= $target;
				$menu->icon		= $icon;
				$menu->is_show	= $iShow;
				$menu->sort		= $iSort;
				$menu->uptime	= TimeUtils::getFullTime();
				if( $menu->save() )
					$this->response->redirect( '/admin/menu/frontend' );
				else
					$this->response->redirect( '/admin/menu/upmenus/id/' . $iSign );
			}
			else
				$this->response->redirect( '/admin/menu/addmenus' );
		}
		else
		{
			$menu = new Menu();
			$menu->delsign	= SystemEnums::DELSIGN_NO;
			$menu->cid		= $cid;
			$menu->pid		= $pid;
			$menu->name		= $mname;
			$menu->url		= $url;
			$menu->relid	= $relid;
			$menu->target	= $target;
			$menu->icon		= $icon;
			$menu->is_show	= $iShow;
			$menu->sort		= $iSort;
			$menu->addtime	= $menu->uptime	= TimeUtils::getFullTime();
			if( $menu->save() )
				$this->response->redirect( '/admin/menu/frontend' );
			else
				$this->response->redirect( '/admin/menu/addmenus' );
		}
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-21' )
	 * @comment( comment = '前台菜单根据分类查找' )
	 * @method( method = 'searchAction' )
	 * @op( op = 'r' )
	 */
	public function searchAction()
	{
		$objRet = new \stdClass();
		$cid = $this->dispatcher->getParam( 'cid' );
		if( false == $cid )
		{
			$objRet->state 	= 1;
			$objRet->msg	= '参数未配置正确,请稍后再试.';
			echo json_encode( $objRet );
			
			exit;
		}
		$where = array(
				'select'	=> 'id,delsign,uptime,addtime,cid,pid,name,url,target,icon,is_show',
				'conditions'=> 'delsign=:del: and cid=:cid: ORDER BY pid ASC,uptime DESC',
				'bind'		=>array( 'del' => SystemEnums::DELSIGN_NO, 'cid' => $cid ),
		);
		$res = Menu::find( $where );
		if( count( $res ) > 0 )
		{
			$objRet->state = 0;
			$objRet->cid = $cid;
			foreach( $res as $key=>$row )
			{
				if( false == $row->pid )
					$row->pname = '/';
				else 
				{
					$where = array(
							'conditions'=> 'delsign=:del: and pid=:pid:',
							'bind'		=>array( 'del' => SystemEnums::DELSIGN_NO, 'pid' => $row->pid )
					);
					$result = Menu::findFirst( $where );
					if( count( $result ) > 0 )
						$row->pname = $result->name;
					else
						$row->pname = '/';
				}
				
				$data[] = $row;
			}
			$objRet->data = $data;
		}
		else
		{
			$objRet->state  = 1;
			$objRet->msg 	= '该分类下暂无菜单，切换失败.';
		}
		
		echo json_encode( $objRet );
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-21' )
	 * @comment( comment = '删除前台菜单' )
	 * @method( method = 'deleteMenuAction' )
	 * @op( op = 'r' )
	 */
	public function deleteMenuAction()
	{
		$objRet = new \stdClass();
		
		$optid = $this->dispatcher->getParam( 'id' );
		if( false == $optid )
		{
			$objRet->state = 1;
			$objRet->msg	= '参数未配置正确,请稍后再试.';
			echo json_encode( $objRet );
			exit;
		}
		
		$where = array(
			'conditions'=> 'delsign=:del: and id=:optid:',
			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'optid' => $optid ),
		);
		$res  = Menu::findFirst( $where );
		if( count( $res ) > 0 )
		{
			$allWhere = array(
				'conditions'=> 'delsign=:del: and pid=:pid:',
				'bind'		=>array( 'del' => SystemEnums::DELSIGN_NO , 'pid' => $res->id ),
			);
			$result = Menu::find( $allWhere );
			if( count( $result ) > 0 )
			{
				$objRet->state = 1;
				$objRet->msg   = '该菜单下还有子菜单,删除失败.';
			}
			else
			{
				$res->delete();
				$objRet->state = 0;
				$objRet->msg = '删除菜单成功.';
				$objRet->optid  = $optid;
			}
		}
		else
		{
			$objRet->state = 1;
			$objRet->msg   = '数据未找到,删除失败.';
		}
		
		echo json_encode( $objRet );
	}
	
	/**
	 * @author( author='Carey' )
	 * @date( date = '2015-10-20' )
	 * @comment( comment = '后台菜单' )
	 * @method( method = 'backendAction' )
	 * @op( op = 'r' )
	 */
	public function backendAction()
	{
		$pageNum = $this->request->getQuery( 'page', 'int' );
		$currentPage = $pageNum ? $pageNum : 1;
		
		$where = array(
			'select'	=> 'id,delsign,addtime,uptime,name,pid,display,src,module,sort',
			'conditions'=> 'delsign=:del: and pid=:pid: ORDER BY sort',
			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'pid' => 1 ),
		);
		$menus = PriPris::find( $where );
		$pagination = new PaginatorModel( array(
				'data'  => $menus,
				'limit' => 15,
				'page'  => $currentPage
		) );
		$page = $pagination->getPaginate();
		$this->view->page = $page;
	}
}

?>