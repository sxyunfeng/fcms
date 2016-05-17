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
use enums\SystemEnums;

use Phalcon\Mvc\Model\Resultset;

class GroupsController extends AdminBaseController{
    
    public function initialize()
    {                
        parent::initialize();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '管理员的首页' )	
     * @method( method = 'indexAction' )
     * @op( op = '' )		
    */
    public function indexAction()
    {
        $groupModel = new PriGroups();
        $result = $groupModel->getGroup();
        
        $groupsList = array();
        foreach( $result as $item )
        {
            $groupsList[ $item->group_id ][ 'group_name' ] = $item->group_name; 
            $groupsList[ $item->group_id ][ 'roles_name'] [] = $item->role_name;
        }
        
        $this->view->groupList = $groupsList;
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '编辑用户组界面显示' )	
     * @method( method = 'editAction' )
     * @op( op = '' )		
    */
    public function editAction()
    {
        $id =  $this->request->getQuery( 'id', 'int' );
        
        $priGroup = PriGroups::findFirst( array( 'id=?0', 'bind' => array( $id )));
          
        if( $priGroup )
        {
            $this->view->group = $priGroup->toArray();
            //当前组所包含的角色
            $groupRoles = array();
            foreach( $priGroup->priGroupsRoles  as $item )
            {
                $groupRoles[] = $item->roleid;
            }
            $this->view->groupRoles = $groupRoles;
        }
        //所有的角色
        $roles = PriRoles::find( 'delsign=' . SystemEnums::DELSIGN_NO );
        $this->view->roles = $roles->toArray();
        
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
        $this->view->roles = PriRoles::find( array( 'delsign=0', 'columns' => 'id,name', 'hydration' => Resultset::HYDRATE_ARRAYS ) );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 更新用户' )	
     * @method( method = 'updateAction' )
     * @op( op = 'u' )		
    */
    public function updateAction()
    {
        $this->csrfCheck();
        
        $groupId = $this->request->getPost( 'groupId', 'int' );
        $groupName = $this->request->getPost( 'groupName', 'string' );
        $roles = $this->request->getPost( 'roles' );
        
        $group = PriGroups::findFirst( array( 'id=?0', 'bind' => array($groupId) ));
        $group->name = $groupName;
        $group->priGroupsRoles->delete(); //把以前的删除 
        
        $groupsRoles = array();
        foreach( $roles as $id )
        {
            $gr = new PriGroupsRoles();
            $gr->roleid = $id;
            $gr->addtime = date( 'Y-m-d H:i:s' );
            $gr->delsign = 0;
            $groupsRoles[] = $gr;
        }
        $group->priGroupsRoles = $groupsRoles ;
        
        if( $group->save() )
        {
            $this->setAcl( $group->id );
            $this->success( '更新成功' );
        }
        else
        {
            $this->error( '更新失败' );
        }
        
    }

    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 删除用户' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function deleteAction()
    {
//        $this->csrfCheck();
        
        $id = $this->request->getPost( 'id', 'int' );
        $priGroups = PriGroups::findFirst( array( 'id=?0', 'bind' => array( $id )));
        
        if( $priGroups )
        {
            $isSuccessGroup = $priGroups->update( array( 'delsign' => SystemEnums::IS_MENU_YES, 'uptime' => date( 'Y-m-d H:i:s')));
            $isSuccessRole = $priGroups->priGroupsRoles->delete();

            if( $isSuccessGroup && $isSuccessRole )
            {
                $this->success( '删除成功' );
            }   
        }
        $this->error( '删除失败' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 添加一个新用户组' )	
     * @method( method = 'insertAction' )
     * @op( op = 'c' )		
    */
    public function insertAction()
    {
        $this->csrfCheck(); //csrf检验
        
        $data[ 'name' ] = $this->request->getPost( 'groupName', 'trim' );
        $roles = $this->request->getPost( 'roles', 'trim' );
        $data[ 'addtime' ] = $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
        $data[ 'delsign' ] = $data[ 'shopid' ] = 0;
        
        $groups = new PriGroups();
        $groupsRoles = array();
        foreach ( $roles as $id )
        {
            $gr = new PriGroupsRoles();
            $gr->roleid = $id;
            $gr->addtime = date( 'Y-m-d H:i:s' );
            $gr->delsign = 0;
            $groupsRoles[] = $gr; 
        }
        $groups->priGroupsRoles = $groupsRoles;
        
        if( $groups->save( $data ))
        {
            $this->setAcl( $groups->id );
            $this->success( '保存成功' , array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
        }
        else
        {
            $this->error( '保存失败' , array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
        }
    }
    
    
    
    
}
