<?php

/**
 * 分组管理
 * @author hfc
 * time 2015-7-5
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\PriGroups;
use apps\admin\models\PriGroupsRoles;
use apps\admin\models\PriRoles;
use apps\admin\models\ShopDept;
use enums\SystemEnums;
use Phalcon\Mvc\Model\Resultset;

class DepartmentsController extends AdminBaseController{
    
    public function initialize()
    {                
        parent::initialize();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '部门的首页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction()
    {
        $where = 'delsign=' . SystemEnums::DELSIGN_NO . ' and shop_id=' . $this->shopId;
        $dept = ShopDept::find( array( $where, 'columns' => 'id,name,status', 'order'=> 'sort', 'hydration' => Resultset::HYDRATE_ARRAYS ) );
        if( $dept )
        {
            $this->view->deptList = $dept;
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-9-21' )
     * @comment( comment = '编辑部门界面显示' )	
     * @method( method = 'editAction' )
     * @op( op = '' )		
    */
    public function editAction()
    {
        $id =  $this->request->getQuery( 'id', 'int' );
    
        $where = 'id =' . $id . ' and shop_id=' . $this->shopId;
       
        $dept = ShopDept::findFirst( array( $where, 'columns' => 'id,name,status,sort', 'order'=> 'sort') );
        if( $dept )
        {
            $this->view->dept = $dept->toArray();
        }
        
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '添加用户界面显示' )	
     * @method( method = 'addAction' )
     * @op( op = '' )		
    */
    public function addAction()
    {
       
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 更新部门' )	
     * @method( method = 'updateAction' )
     * @op( op = 'u' )		
    */
    public function updateAction()
    {
        $this->csrfCheck();
        
        $id = $this->request->getPost( 'id', 'int' );
        $data[ 'name' ] = $this->request->getPost( 'name', 'string' );
        if( ! $data[ 'name' ] )
        {
            $this->error( '部门名必须填写' );
        }
        
        $data[ 'sort' ] = $this->request->getPost( 'sort', 'int' );
        $status = $this->request->getPost( 'status' );
        $data[ 'status' ] = $status == 'on' ? 0 : 1;
        $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
        $shopDept = ShopDept::findFirst( array( 'id=?0', 'bind' => array( $id ) ));
        
        if( $shopDept )
        {
            if( $shopDept->update( $data ) )
            {
                $this->success( '更新成功' );
            }
        }
        
        $this->error( '更新失败' );
    }

    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 删除部门' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function deleteAction()
    {
//        $this->csrfCheck();
        
        $id = $this->request->getPost( 'id', 'int' );
        $shopDept = ShopDept::findFirst( array( 'id=?0', 'bind' => array( $id )));
        
        if( $shopDept )
        {
            $status = $shopDept->update( array( 'delsign' => SystemEnums::IS_MENU_YES, 'uptime' => date( 'Y-m-d H:i:s')));
          
            if( $status )
            {
                $this->success( '删除成功' );
            }   
        }
        $this->error( '删除失败' );
    }
    
       /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 开启关闭部门' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function toggleAction()
    {
//        $this->csrfCheck();
        
        $id = $this->request->getPost( 'id', 'int' );
        $status = $this->request->getPost( 'status', 'int' );
        $shopDept = ShopDept::findFirst( array( 'id=?0', 'bind' => array( $id )));
        
        if( $shopDept )
        {
            $status = $shopDept->update( array( 'status' => $status , 'uptime' => date( 'Y-m-d H:i:s')));
          
            if( $status )
            {
                $this->success( '删除成功' );
            }   
        }
        $this->error( '删除失败' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-9-21' )
     * @comment( comment = 'ajax 请求 添加一个部门' )	
     * @method( method = 'insertAction' )
     * @op( op = 'c' )		
    */
    public function insertAction()
    {
         $this->csrfCheck();
        
        $id = $this->request->getPost( 'id', 'int' );
        $data[ 'name' ] = $this->request->getPost( 'name', 'string' );
        if( ! $data[ 'name' ] )
        {
            $this->error( '部门名必须填写' );
        }
        
        $data[ 'sort' ] = $this->request->getPost( 'sort', 'int' );
        $status = $this->request->getPost( 'status' );
        $data[ 'status' ] = $status == 'on' ? 0 : 1;
        
        $data[ 'delsign' ] = 0; 
        $data[ 'shop_id' ] = $this->shopId;
        $data[ 'addtime' ] = $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
        $shopDept = new ShopDept();
        
        if( $shopDept->save( $data ) )
        {
            $this->success( '添加成功' );
        }
      
        $this->error( '添加失败' );
    }
    
}
