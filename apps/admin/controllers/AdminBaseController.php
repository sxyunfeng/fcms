<?php

/**
 * @comment Admin基类
 * @author fzq
 * @date 2015-1-20
 * @comment 基类不采用统一注释格式
 */
namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\PriGroups;
use apps\admin\models\PriPris;
use apps\admin\models\PriRoles;
use apps\admin\models\PriUsers;
use enums\SystemEnums;
use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Resource;
use Phalcon\Acl\Role;
use Phalcon\Mvc\Controller;

class AdminBaseController extends Controller
{
    protected $userId = 0;
    protected $shopId = 0;
    
    protected function initialize()
	{
		 // 判断是否登录 - session
        $userInfo = $this->session->get( 'userInfo' );
        if( empty($userInfo) )
        {
            if( ! $this->request->isAjax() )
            {
                exit('<script>parent.window.location="/admin/login/index";</script>');
            }
            else
            {
                $this->error( '超时登录，请重新登录' );
            }
        }
        else
        {
            $this->userId = intval( $userInfo[ 'id' ] );
            $this->shopId = intval( $userInfo[ 'shopid' ] );
            
            //判断数据库是否存在user，不存在则返回登录页面
            $where = array(
                'id=?0',
                'bind' => [ $this->userId ],
            );
            $loginInfo = PriUsers::findFirst( $where );
            if( !$loginInfo )
            {
                $this->response->redirect( "admin/login/index" );
            }
            
            
            if( $userInfo[ 'groupid' ] == SystemEnums::SUPER_ADMIN_ID ) //超级管理员不参加角色
            {
                return true;
            }
            
            $aclList = 'aclList' . $userInfo[ 'groupid' ];
            $acl =  $this->memCache->get( $aclList );   
            
            if( !$acl ) //没有的话从文件里读取
            {
                $acl = unserialize( $this->fCache->get( $aclList ) );
                $this->memCache->save( $aclList, $acl );
            }
            if( $acl )
            {
                $controller = $this->router->getControllerName();
                $action = strtolower( $this->router->getActionName());
                
                if(  $acl->isAllowed( 'group' . $userInfo[ 'groupid' ], $controller, $action) )
                {
                   return true;
                }
            }
            $this->output( '你没有权限访问' );
        }
	}
    
    /**
    * 设置访问控制
    * int $groupId 分组id
    */
    protected function setAcl( $groupId = 0 )
    {
        if( !$groupId )
        {
            return;
        }
        $group = PriGroups::findFirst( $groupId );
        $roles = $pris =  array();
        //组所包含的角色
        foreach( $group->priGroupsRoles as $groupRoles )
        {
            $roles[] = $groupRoles->roleid;
        }
        
        //查询限制条件 --  pri_pris 表中删除或者禁用的权限项
        $relWhere = array(
            'columns'  => 'id,addtime,uptime,delsign,name,pid,display,src,sort,module',
            'conditions'=> 'delsign=:del:',
            'bind'      => array( 'del' => SystemEnums::DELSIGN_NO ),
        );
        //角色包含权限
        foreach( $roles as $roleId )
        {
            $role = PriRoles::findFirst( $roleId );
            foreach( $role->priRolesPris as $rolePris )
            {
                //查询限制条件
                if( $rolePris->getPriPris( $relWhere ) )
                {
                     $pris[ $rolePris->priPris->id ] = $rolePris->priPris->toArray();
                }
            }
        }
        $allowRes = $this->getResource( $pris ); //允许的资源
        $roleName = 'group' . $groupId; //和分组id相关
        $acl = $this->memCache->get( 'aclList' );
                
        if( ! $acl ) //不存在acl
        {
            $acl = new AclList();
            $acl->setDefaultAction( Acl::ALLOW ); //不受控的操作允许访问
        }
        
        $role = new Role( $roleName );
        $acl->addRole( $role );

        $allPris = PriPris::find( array( 'delsign=' . SystemEnums::DELSIGN_NO . ' and pid != 0',
            'columns' => 'id,src,pid,display','order' => 'pid,sort' ) )->toArray();
        $aPris = array();
        foreach( $allPris as $pris )
        {
            $aPris[ $pris[ 'id' ] ] = $pris;
        }
        $allRes = $this->getResource( $aPris );
        
        
        foreach( $allRes as $res => $actions )  //所有资源都要拒绝
        {
            $acl->addResource( new  Resource( $res ), $actions );
            $acl->deny( $roleName, $res, $actions );
        }
        
        foreach( $allowRes as $res => $actions ) //允许的资源
        {
            $acl->allow( $roleName, $res, $actions );
        }
        $acl->allow( $roleName, 'index', 'show' ); //增加后台首页 
        $acl->allow( $roleName, 'index', 'index' ); 
        
        $this->fCache->save( 'aclList' . $groupId, serialize( $acl ));
        $this->memCache->save( 'aclList' . $groupId,  $acl  );
    }
    
    /**
     * 根据权限项获得 资源 （控制器， 操作）
     * param array $pris 权限项
     * return array $resource 资源 键是控制器，值是操作
     */
    protected function getResource( $pris = array())
    {
        $resource = array();
        foreach( $pris as $pri )
        {
            if( $pri[ 'display' ] ) //菜单
            {
                if( strpos( $pri[ 'src'], '/' )  === false )
                {
                   $pri[ 'src' ] .= '/index'; //菜单默认action是index
                }
                
                 list( $controller, $action ) = explode( '/', $pri[ 'src'] ); 
                 $resource[ $controller ][] = $action;
            }
            else //功能点
            {
                $controller = $pris[ $pri[ 'pid' ] ][ 'src' ];
                $pos = strpos( $controller, '/');
                if(  $pos !== false )
                {
                    $controller = substr( $controller, 0,  $pos );
                }
                $resource[ $controller ][] = $pri[ 'src' ];
            }
        }
        $resource[ 'index' ][] = 'index'; //添加一个特殊的资源 index/index
        return $resource;
    }
    
    /**
     * csrf 检验
     * return bool
     */
    protected function csrfCheck()
    {
        if( ! $this->security->checkToken() )
        {
            $ret[ 'status' ] = 1;
            $ret[ 'msg' ] = 'csrf校验不正确';
            echo json_encode( $ret );
            exit;
        }
        else
        {
            return true;
        }
    }
    
    /**
     * 验证一下是否是自己
     */
    protected function checkSelf( $userId =0 )
    {
        if( $this->userId != $userId && $this->userId != SystemEnums::SUPER_ADMIN_ID ) //只能编辑自己
        {
            $this->ouput( '你没有权限使用其他用户的账号' );
        }
    }
    
    /**
    * 验证一下是否是自己的商铺
    */
    protected function checkShop( $shopId = 0 )
    {
        if( $this->shopId != $shopId && $this->userId != SystemEnums::SUPER_ADMIN_ID ) //只能编辑自己
        {
           $this->ouput( '你没有权限访问该商铺' );
        }
    }
    
    /**
     * 消息输出
     * param string $msg
     */
    protected function output( $msg )
    {
        if( $this->request->isAjax() )
        {
            $this->error( $msg );
        }
        else
        {
            exit( $msg );
        }
    }
    /**
     * 消息的输出
     * param int $status 状态 0：代表成功，1：代表失败，2:代表其
     * param string $msg 消息内容
     * param array $data 其他自定义数据
     */
    protected function message( $status = 0, $msg = '', $data = array() )
    {
        $ret[ 'status' ] = $status;
        $ret[ 'msg' ] = $msg;
        $ret = array_merge( $ret, $data );
        echo json_encode( $ret );
        exit;
    }
    
    /**
     *成功消息返回 
     * param string $msg
     * param array $data 其他自定义数据
     */
    protected function success( $msg = '', $data = array() )
    {
        $this->message( 0, $msg, $data );
    }
    
     /**
     * 错误消息返回 
     * param string $msg
     * param array $data 其他自定义数据
     */
    public function  error( $msg = '', $data = array() )
    {
        $this->message( 1, $msg, $data );
    }
    
      
    /**
     * 显示404错误页面
     */
    public function show404( $msg = '' )
    {
        $referer = '';
        if( ! empty( $_SERVER[ 'HTTP_REFERER']))
        {
            $referer = str_replace( '/', '$', $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        $this->response->redirect( '/admin/index/show404/msg/' . $msg . '/referer/'. $referer );
    }
}

?>