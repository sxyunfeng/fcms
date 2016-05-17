<?php
namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\SystemEnums;
use apps\admin\models\Slide;
use apps\admin\models\SlideGroup;
use libraries\TimeUtils;
use apps\admin\enums\SlideEnums;
use Phalcon\Paginator\Adapter\QueryBuilder;

/**
 * 幻灯片
 * @author nzw
 * time 2016-03-15
 */
class SlideController extends AdminBaseController
{
    
    public function initialize()
    {
        parent::initialize();
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2016-3-16' )
     * @comment( comment = '显示幻灯片管理主页' )
     * @method( method = 'index' )
     * @op( op = '' )
     */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ?: 1;
        
    	$builder = $this->modelsManager->createBuilder()
    	           ->from( 'apps\admin\models\Slide' )
    	           ->where( "delsign=" . SystemEnums::DELSIGN_NO );
    	
    	$pagination = new QueryBuilder( [
	        'builder' => $builder,
	        'limit'   => 10,
	        'page'    => $currentPage
    	] );
    	$page = $pagination->getPaginate();
    	$this->view->slides = $page;
    	
    }
    /**
     * @author( author='New' )
     * @date( date = '2016-3-16' )
     * @comment( comment = '显示幻灯片添加页' )
     * @method( method = 'add' )
     * @op( op = 'r' )
     */
    public function addAction()
    {
        $where = [
        	'conditions' => 'delsign=?0',
            'bind' => [ SystemEnums::DELSIGN_NO ]
        ];
    	$groups = SlideGroup::find( $where );
		$this->view->groups = count( $groups ) > 0 ? $groups : false;
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2016-3-16' )
     * @comment( comment = '显示幻灯片修改页' )
     * @method( method = 'edit' )
     * @op( op = 'r' )
     */
    public function editAction()
    {
        if( $id = $this->dispatcher->getParam( 'id', 'int' ) )
        {
        	$slideWhere = [
            	'conditions' => 'delsign=?0 and id=?1',
                'bind' => [ SystemEnums::DELSIGN_NO, $id ]
            ];
        	if( $slide = Slide::findFirst( $slideWhere ) )
        	{
        		$this->view->slide = $slide;
        	}
        }
        
        $groupWhere = [
            'conditions' => 'delsign=?0',
            'bind' => [ SystemEnums::DELSIGN_NO ]
        ];
        $groups = SlideGroup::find( $groupWhere );
        $this->view->groups = count( $groups ) > 0 ? $groups : false;
        
        $this->view->pick( 'slide/add' );
    }
    
    public function insertAction()
    {
        $this->csrfCheck();
        
    	if( $this->request->getPost() )
    	{
    		$groupId = $this->request->getPost( 'groupid', 'int' );//必有
    		$title = $this->request->getPost( 'title', 'trim' );
    		$content = $this->request->getPost( 'content', 'trim' );
    		$url = $this->request->getPost( 'url', 'trim' );
    		$alt = $this->request->getPost( 'alt', 'trim' );
    		$type = $this->request->getPost( 'type', 'int' );//必有（图片是1）
    		$width = $this->request->getPost( 'width', 'int' );
    		$height = $this->request->getPost( 'height', 'int' );
    		$size = $this->request->getPost( 'size', 'int' );//必有（至少是0）
    		$sort = $this->request->getPost( 'sort', 'int' );//必有
    		$dir = $this->request->getPost( 'dir', 'trim' );//必有
    		$isLimit = $this->request->getPost( 'islimit', 'int' );//必有
    		$isShow = $this->request->getPost( 'isshow' )?1:0;//必有
    		
    		if( !$isLimit )
    		{
    		    if( $imgArr = getimagesize( APP_ROOT . 'public' . $dir ) )
    		    {
    		        $width = $imgArr[ 0 ];//宽
    		        $height = $imgArr[ 1 ];//高
    		    }
    		}
    		$slideModel = new Slide();
    		
    		$slideModel->addtime = TimeUtils::getFullTime();
    		$slideModel->uptime = TimeUtils::getFullTime();
    		$slideModel->title = $title;
    		$slideModel->content = $content;
    		$slideModel->delsign = SystemEnums::DELSIGN_NO;
    		$slideModel->sort = $sort;
    		$slideModel->groupid =$groupId;
    		$slideModel->width = $width;
    		$slideModel->height = $height;
    		$slideModel->addtime = $height;
    		$slideModel->dir = $dir;
    		$slideModel->url = $url;
    		$slideModel->alt = $alt;
    		$slideModel->nofollow = 1;
    		$slideModel->isshow = $isShow;
    		
    		if( $slideModel->save() )
    		{
    			$ret[ 'state' ] = 0;//添加成功
    		}
    		else
    		{
                $ret[ 'state' ] = 1;//添加失败
    		}
    	}
    	else
    	{
    		$ret[ 'state' ] = 2;//幻灯片信息传递失败
    	}
    	$ret[ 'key' ] = $this->security->getTokenKey();
    	$ret[ 'token' ] = $this->security->getToken();
    	echo json_encode( $ret );
    }
    
    public function updateAction()
    {
    	$this->csrfCheck();
        
    	if( $this->request->getPost() )
    	{
    	    $id = $this->request->getPost( 'id', 'int' );//必有
    		$groupId = $this->request->getPost( 'groupid', 'int' );//必有
    		$title = $this->request->getPost( 'title', 'trim' );
    		$content = $this->request->getPost( 'content', 'trim' );
    		$url = $this->request->getPost( 'url', 'trim' );
    		$alt = $this->request->getPost( 'alt', 'trim' );
    		$type = $this->request->getPost( 'type', 'int' );
    		$width = $this->request->getPost( 'width', 'int' );
    		$height = $this->request->getPost( 'height', 'int' );
    		$size = $this->request->getPost( 'size', 'int' );//必有（至少是0）
    		$sort = $this->request->getPost( 'sort', 'int' );//必有
    		$dir = $this->request->getPost( 'dir', 'trim' );//必有
    		$isLimit = $this->request->getPost( 'islimit', 'int' );//必有
    		$isShow = $this->request->getPost( 'isshow' )?1:0;//必有
    		
    		if( !$isLimit )
    		{
    		    if( $imgArr = getimagesize( APP_ROOT . $dir ) )
    		    {
    		        $width = $imgArr[ 0 ];//宽
    		        $height = $imgArr[ 1 ];//高
    		    }
    		}
    		$where = [
    			'conditions' => 'delsign=?0 and id=?1',
    		    'bind' => [ SystemEnums::DELSIGN_NO, $id ],
    		];
    		$slideModel = Slide::findFirst( $where );
    		
    		$slideModel->uptime = TimeUtils::getFullTime();
    		$slideModel->title = $title;
    		$slideModel->content = $content;
    		$slideModel->delsign = SystemEnums::DELSIGN_NO;
    		$slideModel->sort = $sort;
    		$slideModel->groupid =$groupId;
    		$slideModel->width = $width;
    		$slideModel->height = $height;
    		$slideModel->addtime = $height;
    		$slideModel->dir = $dir;
    		$slideModel->url = $url;
    		$slideModel->alt = $alt;
    		$slideModel->nofollow = 1;
    		$slideModel->isshow = $isShow;
    		
    		if( $slideModel->save() )
    		{
    			$ret[ 'state' ] = 0;//添加成功
    		}
    		else
    		{
                $ret[ 'state' ] = 1;//添加失败
    		}
    	}
    	else
    	{
    		$ret[ 'state' ] = 2;//幻灯片信息传递失败
    	}
    	$ret[ 'key' ] = $this->security->getTokenKey();
    	$ret[ 'token' ] = $this->security->getToken();
    	echo json_encode( $ret );
    }
    
    public function getGroupsAction()
    {
    	$groupId = $this->dispatcher->getParam( 'id', 'int' );
    	$where = [
    		'conditions' => 'delsign=?0 and id=?1',
	        'bind'       => [ SystemEnums::DELSIGN_NO, $groupId ]
    	];
    	$group = SlideGroup::findFirst( $where );
    	if( $group )
    	{
    		echo json_encode( $group );
    	}
    }
    
    
    public function getInfoAction()
    {
    	$dir = $this->request->getPost( 'dir', 'trim' );
    	
    	if( $dir )
    	{
    		if( $imgArr = getimagesize( APP_ROOT . 'public' . $dir ) )
    		{
    		    $ret[ 'state' ] = 0;
    			$ret[ 'width' ] = $imgArr[ 0 ];
    			$ret[ 'height' ] = $imgArr[ 1 ];
    		}
    		else
    		{
    			$ret[ 'state' ] = 2;//图片信息不存在
    		}
    	}
    	else
    	{
    	    $ret[ 'state' ] = 1;//信息丢失，请重试
    	}
    	echo json_encode( $ret );
    }
    
    
    public function getDirAction()
    {
    	if( $id = $this->dispatcher->getParam( 'id', 'int' ) )
    	{
    		$where = [ 
    			'columns' => 'dir',
    		    'conditions' => 'delsign=?0 and id=?1',
    		    'bind' => [ SystemEnums::DELSIGN_NO, $id ],
    		];
    		if( $slide = Slide::findFirst( $where ) )
    		{
    			$ret[ 'dir' ] = $slide->dir;
    			$ret[ 'state' ] = 0;
    		}
    		else
    		{
    			$ret[ 'state' ] = 1;//未找到该幻灯片
    		}
    	}
    	else
    	{
    		$ret[ 'state' ] = 2;//信息传递失败
    	}
    	echo json_encode( $ret );
    }
    
    /**
     * @author( author='nzw' )
     * @date( date = '2016.03.24' )
     * @comment( comment = 'ajax请求删除幻灯片' )
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )
     */
    public function deleteAction()
    {
        $this->csrfCheck(); //csrf检验
    
        $id = $this->request->getPost( 'id', 'int' );
        $slide = slide::findFirst( array( 'id=?0', 'bind' => array( $id ) ) );
        if( $slide )
        {
            $state = $slide->update( array( 'delsign' => SystemEnums::DELSIGN_YES, 'uptime' => date( 'Y-m-d H:i:s' ) ) );
            if( $state )
            {
                $this->success( '删除成功' );
            }
            else
           {
                $this->error( '删除失败' );
            }
        }
        else
       {
            $this->error( '未找到该条数据' );
        }
    }
    
}
