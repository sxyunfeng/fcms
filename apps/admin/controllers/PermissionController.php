<?php

/**
 * 权限管理
 * @author nzw
 * time 2016.03.03
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\PriPris;
use enums\SystemEnums;
use apps\admin\models\PriGroups;
use Phalcon\Mvc\Model\Resultset;
use apps\admin\models\PriUsers;
use apps\admin\models\Shops;
use libraries\TimeUtils;
use Phalcon\Validation;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use libraries\Email;

class PermissionController extends AdminBaseController
{
    
    public function initialize()
    {
        parent::initialize();
    }
    
    /**
     * @author( author='nzw' )
     * @date( date = '2016.03.03' )
     * @comment( comment = '所有权限首页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction()
    {
        $priPrisModel = new PriPris();
        $where = array(
            "columns" => "id, pid, name, loadmode"
        );
        $allPermissioms = $priPrisModel->find( $where )->toArray();
        var_dump( $allPermissioms );exit;
        //$this->view->
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '编辑用户界面显示' )	
     * @method( method = 'editAction' )
     * @op( op = '' )		
    */
    public function editAction()
    {
        $id = $this->request->getQuery( 'id', 'int' );
        $this->checkSelf( $id ); //判断一下是否是自己
        
        $groupid = '';
        if( $this->userId != $id && $this->userId == SystemEnums::SUPER_ADMIN_ID )//超级管理员可以编辑其他人的分组
        {
             $groupid = ',groupid';
             $this->view->groups = PriGroups::find( 
                 array( 
                     'delsign=' . SystemEnums::DELSIGN_NO . ' and id!=' . SystemEnums::SUPER_ADMIN_ID,
                     'columns' => 'id,name',
                     'hydration' => Resultset::HYDRATE_ARRAYS
                 )
             );
        }
        
        $user = PriUsers::findFirst( array( 'id=?0', 'bind' => array( $id ), 'columns' => "id,name,nickname,loginname,shopid,email$groupid" ) );
        $csrfArr = array( 'csrfName' => $this->security->getTokenKey(), 'csrfValue' => $this->security->getToken() );
        if( $user )
        {
            if( $user->shopid )
            {
                $shop = Shops::findFirst( array( 'delsign=' . SystemEnums::DELSIGN_NO . ' and id=:id:', 'bind' => array( 'id' => $user->shopid ) ) );
                if( $shop )
                {
                    $this->view->shop = $shop->toArray();
                }
            }
            $this->view->user = $user->toArray();
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
        $this->view->groups = PriGroups::find( 
            array( 
                'delsign=' . SystemEnums::DELSIGN_NO . ' and id!=' . SystemEnums::SUPER_ADMIN_ID,
                'columns' => 'id,name',
                'hydration' => Resultset::HYDRATE_ARRAYS 
            ) 
        );
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
        
        $userId = $this->request->getPost( 'userId', 'int' );
        $this->checkSelf( $userId );
        
        $data[ 'id' ] = $userId;
        $set = '';
        
        $groupId = $this->request->getPost( 'groupId', 'int' );
        if(  $groupId ) //获得到分组
        {
            $set = ',groupid=:groupid:';
            $data[ 'groupid' ] =  $groupId;  
        }    
        
        $data[ 'email' ] = $this->request->getPost( 'email', 'email' );
        $data[ 'name' ] = $this->request->getPost( 'name', 'trim' );
        $data[ 'nickname' ] = $this->request->getPost( 'nickname', 'trim' );
        $this->validation( $data );//验证数据
        
        $phql = 'UPDATE apps\admin\models\PriUsers SET name=:name:, email=:email:, nickname=:nickname: ' . $set . ' WHERE id=:id:';
        $status = $this->modelsManager->executeQuery( $phql, $data );
        
        if( $status->success() )
            $this->success( '更新成功' );
        else
            $this->error( '更新失败' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax请求 修改密码' )	
     * @method( method = 'changePasswordAction' )
     * @op( op = 'u' )		
    */
    public function changePasswordAction()
    {
        $this->csrfCheck();
        
        $userId = $this->request->getPost( 'userId', 'int' );
        $this->checkSelf( $userId );
        
        $user = null;
        $oldPassword = $this->request->getPost( 'oldPassword', 'trim' );
        if( $oldPassword )
        {
            $user = PriUsers::findFirst( array( 'id=?0','bind' => array( $userId ))  );
            if( $user )
            {
                $pwd = md5( $this->session->getId() . $user->pwd );
                if( $pwd != $oldPassword )
                    $this->error( '原密码不正确' );
            }
        }
        else
            $this->error( '请输入原密码' );
        
        $password = $this->request->getPost( 'password', 'trim' );
        $repassword = $this->request->getPost( 'repassword', 'trim' );
        if( $password != $repassword )
            $this->error( '密码不一致' );
       
        if( $user )
        {
            if( $user->update( array( 'pwd' =>  $password  ) ))
                $this->success( '修改密码成功' );
            else
                $this->error( '修改密码失败' );
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
       	$this->csrfCheck();
       	
        $id = $this->request->getPost( 'id', 'int' );
        $user =  PriUsers::findFirst( array( 'id=?0', 'bind' => array( $id )) );
        if( $user )
        {
            $status = $user->update( array( 'delsign' => SystemEnums::DELSIGN_YES, 'uptime' => TimeUtils::getFullTime() ));
            if( $status )
                 $this->success( '删除成功' );
        }
        $this->error( '删除失败' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 检验用户名' )	
     * @method( method = 'checkLoginNameAction' )
     * @op( op = 'r' )		
    */
    public function checkLoginNameAction()
    {
        $loginname = $this->request->get( 'loginname', 'string' );
        $where = array( 'loginname = :name:', 'bind' => array( 'name' => $loginname ) );
        $priUser = PriUsers::findFirst( $where );
        if( ! $priUser )
            $this->success( '账号不存在' );
        else
            $this->error( '账号已经存在' );
    } 

    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 添加一个新用户' )	
     * @method( method = 'insertAction' )
     * @op( op = 'c' )		
    */
    public function insertAction()
    {
        $this->csrfCheck(); //sadbkjasnkansklnkl
        
        $data[ 'name' ] = $this->request->getPost( 'name', 'trim' );
        $data[ 'nickname' ] = $this->request->getPost( 'nickname', 'trim' );
        $data[ 'loginname' ] = $this->request->getPost( 'loginname', 'trim' );
        $data[ 'pwd' ] = md5( $this->request->getPost( 'password', 'trim' ) );
        $data[ 'email' ] = $this->request->getPost( 'email', 'email' );
        $data[ 'groupid' ] = $this->request->getPost( 'groupId', 'int' );
        $data[ 'shopid' ] = $this->request->getPost( 'shopId', 'int' );
        $this->validation( $data );
        
        $data[ 'addtime' ] = $data[ 'uptime' ] = TimeUtils::getFullTime();
        $data[ 'delsign' ]  = $data[ 'status' ]  = SystemEnums::DELSIGN_NO;
        
        $userName = PriUsers::findFirst( array( 'loginname=?0', 'bind' => $data[ 'loginname' ] ) );
        if( $userName !== false )
            $this->error( '用户名已经存在' );
        
        $user = new PriUsers();
        if( $user->save( $data ) )
            $this->success( '保存成功' );
        else
            $this->error( '保存失败'  );
    }
    
    /**
     * 对输入的数据进行验证
     * @param array $data
     */
    private  function validation( $data = array() )
    {
        $validation = new Validation();
        $validation->add( 'name', new PresenceOf(array(
            'message' => '姓名必须填写'
        )));
         $validation->add( 'email', new PresenceOf(array(
            'message' => '邮箱必须填写'
        )));
         $validation->add( 'email', new Email(array(
            'message' => '邮箱格式不正确'
        )));
        $messages =  $validation->validate( $data );
        if( count( $messages ))
        {
            foreach( $messages as $msg )
            {
                $this->error( $msg->getMessage() );
            }
        }
    }
   
}
