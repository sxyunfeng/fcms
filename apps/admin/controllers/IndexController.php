<?php

/**
 * 系统主框架以及公共显示区域
 * @author Bruce
 * time 2014-10-30
 */
namespace apps\admin\controllers;

use enums\SystemEnums;
use apps\admin\models\SysIndeCfg;
use apps\admin\models\PriUsers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class IndexController extends AdminBaseController
{	
    public function initialize()
    {
        parent::initialize();
	}

    /**
     * 首页
     */
    public function indexAction( )
    {
        $userInfo = $this->session->get( 'userInfo' );
        $leftMenu = $this->memCache->get( 'admin_left_menu_' . $userInfo[ 'groupid' ] . '_' . $userInfo[ 'shopid' ] ); 
            
        $this->view->leftMenu = $leftMenu ;
        $this->view->loginName = $userInfo[ 'loginname' ];
        $this->view->nickName = $userInfo[ 'nickname' ];
        $this->view->uid = $userInfo[ 'id' ];
        $this->view->shopId = $userInfo[ 'shopid' ];
    }
    
    /**
     * 点击后台首页，进行的是这个操作
     */
    public function showAction()
    {
    	$userInfo = $this->session->get( 'userInfo' );
    	$groupid = $userInfo[ 'groupid' ];
    	$where = array(
    		'column'	=> 'id,delsign,sort,display,name,line,sort,icon,color,size,groupid',
    		'conditions'=> 'delsign=:del: and groupid=:gid: and display=:display: ORDER BY sort DESC',
    		'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'gid' => $groupid, 'display' => 0 ),
    	);
    	$res = SysIndeCfg::find( $where );
    	if( false == $res || count( $res ) <= 0 )
    		$this->view->pick( 'index/cms' );
    	else 
    		$this->view->shopId = $userInfo[ 'shopid' ];
    }
    
    /**
     * 获取模块信息
     */
    public function getmodalsAction()
    {
    	$objRet = new \stdClass();
    	$userInfo = $this->session->get( 'userInfo' );
    	$groupid = $userInfo[ 'groupid' ];
    	$where = array(
    			'column'	=> 'id,delsign,sort,display,name,line,sort,icon,color,size,groupid',
    			'conditions'=> 'delsign=:del: and groupid=:gid: and display=:display: ORDER BY sort DESC',
    			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'gid' => $groupid, 'display' => 0 ),
    	);
    	$res = SysIndeCfg::find( $where );
    	if( false != $res && count( $res ) > 0 )
    	{
    		$result = $res->toArray();
    		$i=0;
    		$curObj = $this;
    		foreach ( $result as $row )
    		{
    			$newCont = preg_replace_callback( '/%([a-z A-Z]+)-([a-z A-Z]+)%/', function( $matches ) use( $curObj ) {
    				return $curObj->$matches[1]->{"get". "$matches[2]"}();
    			}, $row[ 'descr' ]);
    			
    			$result[$i][ 'info' ] = $newCont;
    			$i++;
    		}
    		$objRet->state = 0;
    		$objRet->data = $result;
    	}
    	else
    	{
    		$objRet->state = 1;
    	}
    	
    	
    	echo json_encode( $objRet );
    }
    
    /**
     * 错误显示
     */
     public static function errorAction( $data )
    {
        $data = $this->dispatcher->getParams();
        $this->view->data = $data;
    }
    
     /**
     * 错误显示
     */
     public function show404Action( )
    {
        $data = $this->dispatcher->getParams();
        if(  ! empty( $data )  )
        {
            if( !empty( $data['referer'] ) )
            {
                $data['referer'] = str_replace( '$', '/', $data['referer'] );
            }
            $this->view->data = $data;
        }
        
        $this->view->pick( '/index/404' );
    }
}
