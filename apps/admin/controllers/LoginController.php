<?php

/**
 * 登录页面
 * @author hfc
 * @since 2015-6-29
 */
namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\PriPris;
use apps\admin\models\PriUsers;
use enums\SystemEnums;
use libraries\Verify;
use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    private $menus = array();

    public function initialize()
    {
        
    }

    
    /**
     * fcms 登录
     */
    public function indexAction()
    {
        $remember = $this->cookies->has( 'remember' );
    
        if( $remember  ) //传递密码
        {
            $this->view->setVar( 'password', $this->cookies->get( 'remember')->getValue() );
            $this->view->setVar( 'remember', $remember );
        }
    
        $num = rand( 0, 10000000000 );
        
        $strNum = md5( $num );
        
        $this->session->set( 'sid' , $strNum );
        $this->view->setVar( 'sid', $strNum );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求登录页面' )	
     * @method( method = 'doLoginAction' )
     * @op( op = '' )		
    */
    public function doLoginAction()
    {
        $this->checkCode(); //验证验证码
        $loginName = $this->request->getPost( 'loginname', 'trim' );
        $password = $this->request->getPost( 'password', 'trim' );
       
//        $error = $this->memCache->get( 'error_' . $loginName ); //判断是否锁定
        if( isset( $error[ 'status' ] ) && SystemEnums::USER_STATE_LOCK == $error[ 'status' ] )
        {
            $ret[ 'status' ] = 1;
            $ret[ 'msg' ] = '密码已经锁定，请两个小时后再登录';
            echo json_encode( $ret );
            return false;
        }
        
        $where = array(
                'loginname=:loginname:', 
                'bind' => array(
                    'loginname' => "$loginName"
                ), 
                'columns' => 'id,groupid,shopid,status,pwd,name,loginname,nickname'
        );
        $user = PriUsers::findFirst( $where );
        
        if( $user != false )
        {
            $user = $user->toArray();
            if( isset( $user[ 'pwd' ] ) && $user[ 'pwd' ] && $user  )
            {
                $secret = md5( $this->session->get( 'sid' ) . $user[ 'pwd' ] );
                $enableCnt = 6;
                
                if( $secret != $password )
                {
                    if( ! isset( $error ) )
                    {
                        $error[ 'cnt' ] = 1;
                    }
                    else 
                  {
                        if( $error[ 'cnt' ] > $enableCnt ) //大于设定次数
                        {
                            $error[ 'status' ] = SystemEnums::USER_STATE_LOCK;
                        }
                        $error[ 'cnt' ]++;
                    }
                    
                    $this->memCache->save( 'error_' . $loginName, $error, 7200 );
                    $ret[ 'status' ] = 1;
                    $ret[ 'msg' ] = '密码不正确';
                    if( $error[ 'cnt' ] < $enableCnt )
                    {
                        $ret[ 'msg' ] =  '第' . $error[ 'cnt' ] . '次密码不正确,还有'. ( $enableCnt - $error[ 'cnt' ] ) .  '次机会，否则账号锁定两小时';
                    }
                    else if( $error[ 'cnt' ] >= $enableCnt )
                    {
                        $ret[ 'msg' ] = '你的账号已经锁定，请两小时后再输入';
                    }
                    echo json_encode( $ret );
                    return;
                }
            }
            if( isset( $user[ 'status' ] ) )
            {
                if( SystemEnums::USER_STATE_NORMAL == $user[ 'status' ] )
                {
                    $this->rememberPassword( $user[ 'pwd' ] ); //登录成功，记忆密码
                    unset( $user[ 'pwd' ] );
                    $this->_setMenus( $user );//把菜单保存到缓存中
                    
                    $ret[ 'status' ] = 0;
                    $ret[ 'msg' ] = '登录成功';
                }
                else if( SystemEnums::USER_STATE_LOCK == $user[ 'status' ] || ( isset( $error ) && $error[ 'status' ]) )
                {
                    $ret[ 'status' ] = 3;
                    $ret[ 'msg' ] = '账号被锁定';
                }
                else if( SystemEnums::USER_STATE_PAUSE == $user[ 'status' ] )
                {
                    $ret[ 'status' ] = 7;
                    $ret[ 'msg' ] = '账号暂停使用';
                }
                else if( SystemEnums::USER_STATE_LOST == $user[ 'status' ] )
                {
                    $ret[ 'status' ] = 8;
                    $ret[ 'msg' ] = '账号忘记密码';
                }
            }
        }
        else
        {
            $ret[ 'status' ] = 2;
            $ret[ 'msg' ] = '账号不存在';
        }
        
        echo json_encode( $ret );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '设置左边菜单' )	
     * @method( method = '_setMenus' )
     * @op( op = '' )		
    */
    private function _setMenus( $userInfo = null ) 
    {
    	//浏览器 + ip地址
		$strVerfiy = trim( trim( trim( $_SERVER[ 'HTTP_USER_AGENT' ] ) ) . trim( md5( $_SERVER[ 'SERVER_ADDR' ] ) ) );
    	
    	if( false == $userInfo )
    	   return false;
    	$userInfo[ 'session_verfiy' ] 			= $strVerfiy;
    	$userInfo[ 'admin_regenrator_time' ]	= $_SERVER[ 'REQUEST_TIME' ];
    	
        $this->session->set( 'userInfo', $userInfo ); // 保存session
        
        $aclList = 'aclList' . $userInfo[ 'groupid' ];
        $acl =  $this->memCache->get( $aclList );
        if( !$acl ) //没有的话从文件里读取
        {
            $acl = unserialize( $this->fCache->get( $aclList ) );
            $this->memCache->save( $aclList, $acl );
        }
        
        $menu = $this->_getMenuTree( $userInfo[ 'groupid' ] );
        $leftMenu = 'admin_left_menu_' . $userInfo[ 'groupid' ] . '_' . $userInfo['shopid' ];
        
       //把菜单保存到缓存中
       $this->memCache->save( $leftMenu, $menu );
    }
  
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '得到后台所有菜单' )	
     * @method( method = '_getMenuTree' )
     * @op( op = '' )		
    */
    private function _getMenuTree( $groupId = 1, $parentId = 1 )
    {
        $arrMenus = array();
        if( ! $this->menus )
        {    
            $where = 'delsign='. SystemEnums::DELSIGN_NO . ' AND display=' . SystemEnums::IS_MENU_YES ;
            $objMenus = PriPris::find( array(  $where, 'columns' => 'id,name,pid,src,descr,module', 'order' => 'pid,sort' ));
            
            if( $objMenus )
            {
                $this->menus = $objMenus->toArray();
            }
        }
      
        foreach( $this->menus as  $menu )
        {
            if( $menu[ 'pid' ] == $parentId )
            {
                $arrMenus[ $menu[ 'id' ]] = $menu;
                $children = $this->_getMenuTree( $groupId, $menu[ 'id' ] );
                
                if(  ! empty( $children ) )
                {
                    $arrMenus[ $menu[ 'id' ]][ 'sub' ] = $children;
                }
                else    // 没有子菜单，就对该菜单进行acl判断
                {
                    if( strpos( $menu[ 'src' ], '/') === false )
                    {
                        $menu[ 'src' ] .= '/index';  //默认index操作
                        $arrMenus[ $menu[ 'id' ] ] = $menu;  
                    }
                    
                    if( $groupId != SystemEnums::SUPER_ADMIN_ID )
                    {
                        list( $controller, $action ) = explode( '/', $menu[ 'src' ] );
                        $acl =  $this->memCache->get( 'aclList' . $groupId );
                        
                        if( !$acl ||  ! $acl->isAllowed( 'group' . $groupId, $controller, $action) )
                        {
                            unset( $arrMenus[ $menu[ 'id' ]] );//如果不允许，就删除菜单
                        }
                    }
                }
            }
        }
        return $arrMenus;
    }   
 
    /**
     * 退出登录
     */
    public function logoutAction()
    {
        $this->session->remove( 'userInfo' );
        $this->session->destroy();
        session_regenerate_id();
        $this->response->redirect( 'admin/login/index' );
    }
    
    /**
     * 输出验证码
     */
    public function verifyAction()
    {
    
        $verify = new Verify( array( 'imageH' => 40, 'imageW' => 140, 'fontSize' => 20, 'length' => 4 ));
        $verify->entry( 'code' );
    }
    
    /**
     * 记忆密码
     */
    private function rememberPassword(  $password = '' )
    {
        $remember = $this->request->getPost( 'remember', 'int' );
        
        if( $remember )
        {
            $this->cookies->set( 'remember', $password, time() + 15 * 86400 ); //记忆15天
        }
        else
        {
            $remember = $this->cookies->has( 'remember' );
            if( $remember ) //如果存在就删除
            {
                $this->cookies->get( 'remember' )->delete( 'remember' );
            }
        }
    }
    
    /**
     * 验证验证码
     */
    private function checkCode()
    {
        $code = $this->request->getPost( 'code', 'trim' );
        $verify = new Verify();

        if( ! $verify->check( $code, 'code') )
        {
            $ret['status'] = 6;
            $ret['msg'] = '验证码错误';
            exit( json_encode( $ret ) );
        }
    }
    

    
}
