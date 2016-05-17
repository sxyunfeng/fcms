<?php 
/**
 * 权限项页面
 * @author hfc
 * @since 2015-6-29
 */
namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\controllers\AdminBaseController;
use apps\admin\models\PriPris;
use enums\SystemEnums;
use libraries\TimeUtils;
use Phalcon\Paginator\Adapter\QueryBuilder;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class PrivilegeController extends AdminBaseController 
{
    public function initialize() 
    {
        parent::initialize();
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2016-1-18' )
    * @comment( comment = '权限项首页' )	
    * @method( method = 'indexAction' )
    * @op( op = 'r' )		
   */
    public function indexAction()
    {
        $num = $this->request->getQuery( 'page', 'int' );
        $currentPage = $num ? $num : 1;
        //只显示首页
        $builder = $this->modelsManager->createBuilder()
                    ->columns( 'id,name,display,src,apid, pid' )
                    ->from( 'apps\admin\models\PriPris' )
                    ->where( 'pid=1 and delsign=' . SystemEnums::DELSIGN_NO )
                    ->orderBy( 'sort,id');
        
        $paginator = new QueryBuilder( array( 
            'builder'  => $builder,
            'limit' => 20,
            'page'  => $currentPage
        ));
        
        $page = $paginator->getPaginate();
        $this->view->page = $page;
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2016-1-19' )
    * @comment( comment = '权限项删除' )	
    * @method( method = 'deleteAction' )
    * @op( op = 'd' )		
   */
    public function deleteAction()
    {
    	$this->csrfCheck();
    	
        $id = $this->request->getPost( 'id', 'int' );
        if( $id )
        {
            $data = [ 'delsign' => SystemEnums::DELSIGN_YES ];
            $pmodel = PriPris::findFirst( [ 'id=?0', 'bind' => [ $id ]] );
            if( $pmodel && $pmodel->update( $data ) )
            {
                //删除子权限项
                $subPri = PriPris::find( [ 'pid=?0', 'bind' => [ $id ]]);
                $subPri->update( $data );
                $this->success( '删除成功' );
            }
        }
        $this->error( '删除失败' );
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2016-1-19' )
    * @comment( comment = '获得权限' )	
    * @method( method = 'getSubAction' )
    * @op( op = 'r' )		
   */
    public function getSubAction()
    {
        $id = $this->request->getQuery( 'id', 'int' );
        if( $id )
        {
            $arr = PriPris::find( [  'pid=?0 and delsign=' . SystemEnums::DELSIGN_NO, 
                    'bind' => [ $id ], 'columns' => 'id,name,display' , 'order' => 'sort asc' ] )->toArray();
            if( $arr )
            {
                $this->success( '成功', [ 'data' => $arr ] );
            }
        }
        $this->error( '获取权限失败' );
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2016-1-19' )
    * @comment( comment = '编辑权限' )	
    * @method( method = 'editAction' )
    * @op( op = 'r' )		
   */
    public function editAction()
    {
        $id = $this->request->getQuery( 'id', 'int' );
        if( $id )
        {
            $pri = PriPris::findFirst( [  'id=?0', 'bind' => [ $id ], 'columns' => 'id,pid,name,display,descr,src, apid,type,sort,loadmode' ] );
            if( $pri )
            {
                if(  $pri->pid  ) //获得上级
                {
                    $parent = PriPris::findFirst( [  'id=' . $pri->pid, 'columns' => 'id,name' ] );
                    if( $parent )
                    {
                        $this->view->setVars( [ 'pid' =>  $pri->pid , 'pname' => $parent->name ] );
                    }
                }
                if( $pri->apid ) //获得module,controller
                {
                    $controller = PriPris::findFirst( [ 'id=' .$pri->apid . ' and type=' .SystemEnums::PRI_CONTROLLER,
                        'columns' => 'id,src,apid' ]); // controller
                    if( $controller )
                    {
                        $this->view->setVar( 'controller', $controller->toArray() );
                        $module = PriPris::findFirst( [ 'id=' . $controller->apid . ' and type=' . SystemEnums::PRI_MODULE, 'columns' => 'id, src' ]);
                        if( $module ) //module
                        {
                            $this->view->setVar( 'module', $module->toArray() );
                        }
                    }
                }
                
                $this->view->setVars( $pri->toArray() );
            }
        }
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2016-1-19' )
    * @comment( comment = '添加权限' )	
    * @method( method = 'addAction' )
    * @op( op = 'r' )		
   */
    public function addAction()
    {
        $pid = $this->request->getQuery( 'pid', 'int' );
        if( $pid )
        {
            $pri = PriPris::findFirst( [  'id=?0', 'bind' => [ $pid ], 'columns' => 'id,name' ] );
            if( $pri )
            {
                $this->view->setVars( [ 'pid' => $pid, 'pname' => $pri->name ] );
            }
        }
        $this->view->add = true;
        $this->view->pick( 'privilege/edit' );
    }
    
     /**
    * @author( author='hfc' )
    * @date( date = '2016-1-19' )
    * @comment( comment = '保存权限' )	
    * @method( method = 'saveAction' )
    * @op( op = 'u' )		
   */
    public function saveAction()
    {
        $this->csrfCheck();
        $id = $this->request->getPost( 'id', 'int' );
        $pid = $this->request->getPost( 'pid', 'int' );
        $data[ 'name' ] = $this->request->getPost( 'name', 'string' );
        $data[ 'apid' ] = $this->request->getPost( 'controllerId', 'int' );
        $moduleId = $this->request->getPost( 'moduleId', 'int' );
        $data[ 'src' ] = $this->request->getPost( 'src', 'string' );
        $data[ 'display' ] = $this->request->getPost( 'display', 'int');
        $data[ 'loadmode' ] = $this->request->getPost( 'loadmode', 'int' );
//        $data[ 'descr' ] = $this->request->getPost( 'descr', 'string' );
        $data[ 'type' ] = $this->request->getPost( 'type', 'int' );
        $sort = $this->request->getPost( 'sort', 'int' );
        $data[ 'sort' ] = $sort ? $sort : 0;
        $this->validation( $data );
        $data[ 'uptime' ] = TimeUtils::getFullTime();

        if( $id ) //编辑
        {
            if( $data[ 'type'] == SystemEnums::PRI_MENU ) //类型是纯菜单的话，src,apid不可更新
            {
                unset( $data[ 'apid' ], $data[ 'src'] );
            }
            unset( $data[ 'type'] );//类型不可更新
            $pri = PriPris::findFirst( [ 'id=?0 and delsign=' . SystemEnums::DELSIGN_NO , 'bind' => [ $id ]] );
            if( $pri && $pri->update( $data ))
                $this->success( '更新成功' );
        }
        else  //新建
        {
            $data[ 'pid' ] = $pid ?: 1;
            $data[ 'addtime' ] = $data[ 'uptime' ]; 
            $data[ 'delsign' ] = SystemEnums::DELSIGN_NO;
            
            //防止 action, controller, module 三者同时重复 
            $action = PriPris::findFirst( [ 'src=?0 and apid=?1 and delsign=' . SystemEnums::DELSIGN_NO, 
                'bind' => [$data[ 'src'], $data[ 'apid']], 'columns' => 'apid' ]);
            if( $action )
            {
                $controller = PriPris::findFirst( [ 'id=?0', 'bind' => [ $action->apid ], 'columns' => 'apid']);
                if( $controller && $controller->apid === $moduleId )
                    $this->error( '已经存在！请不要重复添加' );
            }
            
            //防止名字重复
            $isSame = PriPris::findFirst( [ 'name=?0 and pid=?1 and delsign=' . SystemEnums::DELSIGN_NO, 'bind' => [ $data[ 'name' ], $pid ], 'columns' => 'name' ]);
            if( $isSame )
                $this->error( '菜单名重复' );
            
            //如果只是菜单就自动生成 src
            if( $data['type'] == SystemEnums::PRI_MENU )
                $data = $this->generateOperation( $data );
            
            $pri = new PriPris();
            if( $pri->save( $data ))
                $this->success( '添加成功' );
        }
        $this->error( '保存失败' );
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2016-3-14' )
    * @comment( comment = '自动生成操作' )	
    * @method( method = 'generate' )
    * @op( op = '' )		
   */
    private function generateOperation(  $data )
    {
        //找默认的controller的id
        $defaultController = '_backmenu';
        $controller = PriPris::findFirst( [ 'src=?0', 'bind' => [ $defaultController ], 'columns' => 'id' ] );
        if( $controller )
        {
            $data[ 'apid' ] = $controller->id;
            $data[ 'src' ] = uniqid('_');
            return $data;
        }
        $this->error( '没有找到默认控制器，无法生成操作' );
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2016-1-20' )
    * @comment( comment = '验证' )	
    * @method( method = 'validation' )
    * @op( op = '' )		
   */
    private function validation( $data )
    {
        $validation = new Validation();
        $validation->add( 'name', new PresenceOf( [ 'message' => '菜单名必填']) );
        if( isset( $data[ 'type' ] ) && $data[ 'type' ] == SystemEnums::PRI_ACTION )
        {
            $validation->add( 'src', new PresenceOf( [ 'message' => '操作必填' ]) );
            $validation->add( 'apid', new PresenceOf( [ 'message' => '控制器必填' ]) );
        }
        $messages = $validation->validate( $data );
        
        if( count( $messages ))
        {
            $m = '';
            foreach( $messages as $msg )
            {
                $m .= $msg->getMessage() . '<br>'; 
            }
            $this->error( $m );
        }
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2016-3-10' )
    * @comment( comment = '获取所有的module' )	
    * @method( method = 'getModules' )
    * @op( op = '' )		
   */
    public function getModulesAction()
    {
        $modules = PriPris::find( [ 'delsign=' . SystemEnums::DELSIGN_NO . ' and type = ' . SystemEnums::PRI_MODULE, 'columns' => 'id, src' ])->toArray();
        echo json_encode( $modules );
        exit;
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2016-3-10' )
    * @comment( comment = '获取所有的controller' )	
    * @method( method = 'getControllers' )
    * @op( op = '' )		
    */
    public function getControllersAction()
    {
        $mid = $this->dispatcher->getParam( 'mid', 'int');
        if( $mid )
        {
            $controllers = PriPris::find( [ 'delsign=' . SystemEnums::DELSIGN_NO . ' and type = ' . SystemEnums::PRI_CONTROLLER 
                    . ' and apid=' . $mid, 'columns' => 'id, src' ])->toArray();
            echo json_encode( $controllers );
        }
        exit;
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2016-3-10' )
     * @comment( comment = '保存controller' )	
     * @method( method = 'saveController' )
     * @op( op = '' )	
     */
    public function saveControllerAction()
    {
    	$this->csrfCheck();
        $moduleId = $this->request->getPost( 'moduleId', 'int' );
        $src = $this->request->getPost( 'src', 'string'); 
        
        if( $moduleId && $src )
        {
            //控制器必须是小写
            $src = strtolower( $src );
            $date = TimeUtils::getFullTime();
            $model = new PriPris();
            $status = $model->save( [ 'apid' => $moduleId, 'src' => $src, 'uptime' => $date, 'addtime' => $date, 
                'delsign' => SystemEnums::DELSIGN_NO, 'type' => SystemEnums::PRI_CONTROLLER, 'display' => 0, 'loadmode' => 0, 'pid' => 0 ]);
            if( $status )
                $this->success( '保存成功', [ 'id' => $model->id ] );
        }
        $this->error( '保存失败' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2016-3-10' )
     * @comment( comment = '保存module' )	
     * @method( method = 'saveModule' )
     * @op( op = '' )	
     */
    public function saveModuleAction()
    {
    	$this->csrfCheck();
    	
        $src = $this->request->getPost( 'src', 'string');
        if( $src )
        {
            $date = TimeUtils::getFullTime();
            $model = new PriPris();
            $status = $model->save( [ 'apid' => 0, 'src' => $src, 'uptime' => $date, 'addtime' => $date,
               'delsign' => SystemEnums::DELSIGN_NO, 'type' => SystemEnums::PRI_MODULE, 'display' => 0, 'loadmode' => 0, 'pid' => 0 ]);
            if( $status )
                $this->success( '保存成功', [ 'id' => $model->id ] );
        }
        $this->error( '保存失败' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2016-3-10' )
     * @comment( comment = '判断是否module' )	
     * @method( method = 'isModule' )
     * @op( op = '' )	
     */
    public function isModuleAction()
    {
        $src = $this->request->getQuery( 'src', 'string' );
        if( $src )
        {
            $pri = PriPris::findFirst( [ 'src=?0 and type=' . SystemEnums::PRI_MODULE . ' and delsign=' . SystemEnums::DELSIGN_NO,
                'bind' => [ $src ], 'columns' => 'id' ] );
            if( $pri )
            {
                $this->success( '合法模块', $pri->toArray());
            }
        }
        $this->error( '非法模块' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2016-3-10' )
     * @comment( comment = '判断是否module' )	
     * @method( method = 'isModule' )
     * @op( op = '' )	
     */
    public function isControllerAction()
    {
        $src = $this->request->getQuery( 'src', 'string' );
        $moduleId = $this->request->getQuery( 'mid', 'int');
        if( $src && $moduleId)
        {
            $pri = PriPris::findFirst( [ 'src=?0 and type=' . SystemEnums::PRI_CONTROLLER . 
                ' and delsign=' . SystemEnums::DELSIGN_NO . ' and apid=' . $moduleId,
                'bind' => [ $src ], 'columns' => 'id' ] );
            if( $pri )
            {
                $this->success( '合法控制器', $pri->toArray());
            }
        }
        $this->error( '非法控制器' );
    }
}

