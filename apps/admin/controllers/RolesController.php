<?php

/**
 * 角色管理
 * @author hfc
 * time 2015-7-5
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\PriPris;
use apps\admin\models\PriRoles;
use enums\SystemEnums;
use Phalcon\Mvc\Model\Resultset;

class RolesController extends AdminBaseController{
    
    private $pris = array();
    
    public function initialize()
    {            
        parent::initialize();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '角色列表页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction()
    {
        $rolesList = PriRoles::find( array( 'delsign=' . SystemEnums::DELSIGN_NO, 
            'columns' => 'id,name,descr', 'hydration' => Resultset::HYDRATE_ARRAYS ));
       
        $this->view->rolesList = $rolesList;
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '编辑角色界面显示' )	
     * @method( method = 'editAction' )
     * @op( op = '' )		
    */
    public function editAction()
    {
        $id =  $this->request->getQuery( 'id', 'int' )  ;
        
        $priRole = PriRoles::findFirst( array( 'id=?0', 'bind' => array( $id )));
          
        if( $priRole )
        {
            $this->view->role = $priRole->toArray();
            //当前角色包含的所有权限
            $rolePris = array();
            foreach( $priRole->priRolesPris  as $item )
            {
                $rolePris[] = $item->priid;
            }
            $this->view->rolePris = $rolePris;
        }
        //所有的权限项
        $this->view->pris = $this->_getPriTree();

    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '添加角色界面显示' )	
     * @method( method = 'addAction' )
     * @op( op = '' )		
    */
    public function addAction()
    {
        $this->view->pris = $this->_getPriTree();
     
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax请求 更新角色' )	
     * @method( method = 'updateAction' )
     * @op( op = 'c' )		
    */
    public function updateAction()
    {
//        $this->csrfCheck();
        
        $roleId = $this->request->getPost( 'roleId', 'int' );
        $data[ 'name' ] = $this->request->getPost( 'roleName', 'trim' );
        $data[ 'descr' ] = $this->request->getPost( 'roleDescr', 'string' );
        $priss = $this->request->getPost( 'pris', 'trim' );
        $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
        
        
        $role = PriRoles::findFirst( array( 'id=?0', 'bind' => array($roleId) ));
        
        if( $role->update( $data ) )
        {
            $role->priRolesPris->delete(); //把以前的删除 
            $addtime = date( 'Y-m-d H:i:s' );
            $query = $this->modelsManager->createQuery( "insert into apps\admin\models\PriRolesPris (roleid, addtime, delsign, priid) values ('$roleId', '$addtime', 0, :priid:)" );

            foreach( $priss as $pris )
            {
                $ret = $query->execute( array( 'priid' => $pris ));
            }
            if( $ret )
            {
                //角色相关的组， 进行acl的修改
                $phql = 'select groupid from apps\admin\models\PriGroupsRoles where roleid=?0';
                $groupRoles = $this->modelsManager->executeQuery( $phql , array( $roleId ));
                foreach( $groupRoles as $gr )
                {
                    $this->setAcl( $gr->groupid );
                }
               
                $this->success( '更新成功' );
            }
            else
            {
                $this->error( '更新失败' );
            };
        }
        else
        {
             $this->error( '更新失败' );
        }
       
    }

    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax请求 删除角色' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function deleteAction()
    {
//        $this->csrfCheck();
        
        $id = $this->request->getPost( 'id', 'int' );
        $priRoles = PriRoles::findFirst( array( 'id=?0', 'bind' => array( $id )));
        $isRoles = $priRoles->update( array( 'delsign' => SystemEnums::IS_MENU_YES, 'uptime' => date( 'Y-m-d H:i:s')));
        $isPris = $priRoles->priRolesPris->delete();
        
        if( $isRoles && $isPris )
        {
           $this->success( '删除成功' );
        }
        else
        {
            $this->error( '删除失败' );
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 添加一个新角色' )	
     * @method( method = 'insertAction' )
     * @op( op = 'c' )		
    */
    public function insertAction()
    {
        $this->csrfCheck(); //csrf检验
        
        $data[ 'name' ] = $this->request->getPost( 'roleName', 'trim' );
        $data[ 'descr' ] = $this->request->getPost( 'roleDescr', 'string' );
        $priss = $this->request->getPost( 'pris', 'trim' );
        $data[ 'addtime' ]  = $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
        $data[ 'delsign' ] = $data[ 'shopid' ] = 0;
        
        $role = new PriRoles();
        $rolePris = array();
        
        if( $role->save( $data ))
        {
            $roleId = $role->id;
            $addtime = date( 'Y-m-d H:i:s' );
            $query = $this->modelsManager->createQuery( "insert into apps\admin\models\PriRolesPris (roleid, addtime, delsign, priid) values ('$roleId', '$addtime', 0, :priid:)" );
            
            foreach( $priss as $pris )
            {
                $ret = $query->execute( array( 'priid' => $pris ));
            }
          
            if( $ret )
            {
                $this->success( '添加成功', array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
            }
            else
           {
                $this->error( '添加失败', array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
            }
        }
        else
       {
            $this->error( '添加失败', array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
        }
    }
    
    /**
     * 得到管理后台权限项
     * param number $parentid 
     */
    private function _getPriTree( $parentId = 1 )
    {
        $arrPris = array();
        if( ! $this->pris )
        {
            $where = 'delsign='. SystemEnums::DELSIGN_NO;
            $objPris = PriPris::find( array( $where, 'columns' => 'id,name,pid,src', 'order' => 'id' ) );
            if( $objPris )
            {
                $this->pris = $objPris->toArray();
            }
        }
        
        foreach( $this->pris as $pri )
        {
            if( $pri[ 'pid' ] == $parentId )
            {
                $arrPris[ $pri[  'id' ] ] = $pri;                
                $children = $this->_getPriTree( $pri[ 'id' ] );

                if( ! empty( $children )  )
                {
                    $arrPris[ $pri[  'id' ] ][ 'sub' ] = $children;
                }
            }
        }
       
        return $arrPris;
    }
    
}
