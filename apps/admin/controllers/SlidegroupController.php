<?php
namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\SystemEnums;
use apps\admin\models\Slide;
use apps\admin\models\SlideGroup;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use libraries\TimeUtils;
use Phalcon\Paginator\Adapter\QueryBuilder;

/**
 * 幻灯片
 * @author nzw
 * time 2016-03-15
 */
class SlidegroupController extends AdminBaseController
{
    
    public function initialize()
    {
        parent::initialize();
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2016-3-16' )
     * @comment( comment = '显示幻灯片组管理主页' )
     * @method( method = 'index' )
     * @op( op = 'r' )
     */
    public function indexAction()
    {
        $pageNum     = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ?: 1;
        
        $builder = $this->modelsManager->createBuilder()
                    ->columns( 'id,delsign,name,type,width,height,size,islimit' )
                    ->from( 'apps\admin\models\SlideGroup' )
                    ->where( "delsign =" . SystemEnums::DELSIGN_NO );
        
        $pagination = new QueryBuilder( [
        	'builder' => $builder,
            'limit' => 10,
	        'page'  => $currentPage
        ] );
        $page = $pagination->getPaginate();
        $this->view->groups = $page;
        
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2016-3-16' )
     * @comment( comment = '显示幻灯片组添加页' )
     * @method( method = 'edit' )
     * @op( op = '' )
     */
    public function addAction()
    {
    	
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2016-3-16' )
     * @comment( comment = '显示幻灯片组修改页' )
     * @method( method = 'edit' )
     * @op( op = '' )
     */
    public function editAction()
    {
    	$id = $this->request->getQuery( 'id', 'int' );
    	$where = [
    	    'conditions' => 'delsign=?0 and id=?1',
	        'bind' => [ SystemEnums::DELSIGN_NO, $id ]
    	];
    	$group = SlideGroup::findFirst( $where );
    	if( count( $group ) > 0 && false != $group )
    		$this->view->group = $group;
    	
	    $this->view->pick( 'slidegroup/add' );
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2016-3-16' )
     * @comment( comment = '将幻灯片组信息写入数据库' )
     * @method( method = 'edit' )
     * @op( op = 'r' )
     */
    public function insertAction()
    {
        $this->csrfCheck();
        
        if( $this->request->getPost() )
        {
            $groupName = $this->request->getPost( 'name', 'trim' );
            $groupType = $this->request->getPost( 'type', 'int' );
            $groupIsLimit = $this->request->getPost( 'islimit', 'string' )?1:0;//1表示选中（限制），0表示未选中（未选中）
            $groupWidth = $this->request->getPost( 'width', 'int' );
            $groupHeight = $this->request->getPost( 'height', 'int' );
            $groupSize = $this->request->getPost( 'size', 'int' );
            
            $where = [
            	'conditions' => 'delsign=?0 and name=?1',
                'bind' => [ SystemEnums::DELSIGN_NO, $groupName ]
            ];
            $groups = SlideGroup::findFirst( $where );
            if( count( $groups ) > 0 && false != $groups )
            {
                $ret[ 'state' ] = 3;
                $ret[ 'key' ] = $this->security->getTokenKey();
                $ret[ 'token' ] = $this->security->getToken();
                echo json_encode( $ret );
                exit;
            }
            
            $groupModel = new SlideGroup();
            $groupModel->addtime = $groupModel->uptime = TimeUtils::getFullTime();
            $groupModel->name = $groupName;
            $groupModel->type = $groupType;
            $groupModel->islimit = $groupIsLimit;
            $groupModel->size = $groupSize;
            $groupModel->width = $groupWidth;
            $groupModel->height = $groupHeight;
            $groupModel->delsign = SystemEnums::DELSIGN_NO;
            
            if( $groupModel->save() )
            {
                $ret[ 'state' ] = 0;
            }
            else
           {
                $ret[ 'state' ] = 1;
            }
        }
        else
        {
            $ret[ 'state' ] = 2;
        }
        $ret[ 'key' ] = $this->security->getTokenKey();
        $ret[ 'token' ] = $this->security->getToken();
        echo json_encode( $ret );
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2016-3-17' )
     * @comment( comment = '更新幻灯片组信息' )
     * @method( method = 'update' )
     * @op( op = 'r' )
     */
    public function updateAction()
    {
        $this->csrfCheck();
    	if( $this->request->getPost() )
    	{
    	    $groupId = $this->request->getPost( 'id', 'int' );
    	    $groupName = $this->request->getPost( 'name', 'trim' );
    	    $groupType = $this->request->getPost( 'type', 'int' );
    	    $groupIsLimit = $this->request->getPost( 'islimit', 'string' )?1:0;//1表示选中（限制），0表示未选中（未选中）
    	    $groupWidth = $this->request->getPost( 'width', 'int' );
    	    $groupHeight = $this->request->getPost( 'height', 'int' );
    	    $groupSize = $this->request->getPost( 'size', 'int' );
    	    
    	    $where = [
    	            'conditions' => 'delsign=?0 and id=?1',
    	            'bind' => [ SystemEnums::DELSIGN_NO, $groupId ]
    	    ];
    	    $groups = SlideGroup::findFirst( $where );
    	    if( count( $groups ) > 0 && false != $groups )
    	    {
                $groups->name = $groupName;
                $groups->type = $groupType;
                $groups->islimit = $groupIsLimit;
                $groups->width = $groupWidth;
                $groups->height = $groupHeight;
                $groups->size = $groupSize;
                $groups->uptime = TimeUtils::getFullTime();
                
                if( $groups->save() )
                {
                    $ret[ 'state' ] = 0;//更新成功
                }
                else
               {
                    $ret[ 'state' ] = 1;//更新失败
                }
    	    }
    	    else
           {
    	        $ret[ 'state' ] = 3;//该条记录在数据库中不存在
    	    }
        }
	    else
       {
	        $ret[ 'state' ] = 2;//信息传递失败，请重试
	    }
	    $ret[ 'key' ] = $this->security->getTokenKey();
	    $ret[ 'token' ] = $this->security->getToken();
	    echo json_encode( $ret );
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2016-3-17' )
     * @comment( comment = '删除幻灯片组信息' )
     * @method( method = 'delete' )
     * @op( op = 'r' )
     */
    public function deleteAction()
    {
        $this->csrfCheck(); //csrf检验
        
        $id = $this->request->getPost( 'id', 'int' );
        $slideGroup = SlideGroup::findFirst( array( 'id=?0', 'bind' => array( $id ) ) );
        if( $slideGroup )
        {
            $where = [
            	'conditions' => 'delsign=?0 and groupid=?1',
                'bind' => [ SystemEnums::DELSIGN_NO, $id ]
            ];
            $slide = slide::find( $where );
            if( $slideNums = count( $slide ) )
            {
            	for( $i = 0; $i < $slideNums; $i++ )
            	{
            		$slide[ $i ]->delete();
            	}
            }
            $state = $slideGroup->update( array( 'delsign' => SystemEnums::DELSIGN_YES, 'uptime' => date( 'Y-m-d H:i:s' ) ) );
            if( $state )
            {
                $ret[ 'state' ] = 0;//删除成功
            }
            else
           {
                $ret[ 'state' ] = 1;//删除失败
            }
        }
        else
       {
            $ret[ 'state' ] = 2;//未找到该条数据
        }
        $ret[ 'key' ] = $this->security->getTokenKey();
        $ret[ 'token' ] = $this->security->getToken();
        echo json_encode( $ret );
    }
    
    
}
