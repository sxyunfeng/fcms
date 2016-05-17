<?php
/**
 * 会员管理
 * @author hfc
 * time 2015-7-23
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\CommonDistrictDic;
use apps\admin\models\MemMembers;
use apps\admin\models\ShopCouponDic;
use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class MembersController extends AdminBaseController
{
    
    public function initialize()
    {
        parent::initialize();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '会员的首页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;
        
        $memModel = new MemMembers();
        $list = $memModel->getMemeber( $this->shopId );
        
        $pagination = new PaginatorModel( array(
          'data' => $list,
          'limit' => 10,
          'page' => $currentPage
        ) );
        
        $page = $pagination->getPaginate();
        //修改账户状态
        foreach( $page->items as &$vo )
        {
            switch( $vo->status )
            {
                case SystemEnums::USER_STATE_NORMAL : 
                    $vo->status = '未激活';
                    break;
                case SystemEnums::USER_STATE_PAUSE:
                    $vo->status = '冻结';
                    break;
                case SystemEnums::USER_STATE_LOST:
                    $vo->status = '删除';
                    break;
                case SystemEnums::USER_STATE_LOCK:
                    $vo->status = '忘记密码';
                    break;
                case SystemEnums::USER_STATE_ACTIVE:
                    $vo->status = '账号已激活';
                    break;
                default:
                    break;
            }
        }
        //获得所有优惠券
        $where = 'delsign=' . SystemEnums::DELSIGN_NO .  ' and shopid=' . $this->shopId;
        $coupon = ShopCouponDic::find( array( $where, 'columns' => 'id,title' ));
        if( $coupon )
        {
            $this->view->coupon = $coupon->toArray();
        }
        
        $this->view->page = $page;
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '会员界面显示' )	
     * @method( method = 'readAction' )
     * @op( op = '' )		
    */
    public function readAction()
    {
        $id =  $this->request->getQuery( 'id', 'int' );
  
        $member = MemMembers::findFirst( array( 'id=?0', 'bind' => array( $id ),
            'columns' => "id,username,login_name,email,accu_points,rest_points,mobile_phone,"
            . "gender,birthdate,province, city,district,addr"));
        
        if( $member )
        {
            if( $member->province && $member->city && $member->district )
            {
                $this->view->provinces =  CommonDistrictDic::find( 'upid=0' )->toArray(); //省份
                $this->view->citys =  CommonDistrictDic::find( 'upid=' . $member->province  )->toArray(); //省份
                $this->view->countrys =  CommonDistrictDic::find( 'upid=' . $member->city )->toArray();
            }
            $this->view->member = $member->toArray();
        }
        
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 删除会员' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function deleteAction()
    {
//        $this->csrfCheck();
        $id = $this->request->getPost( 'id', 'int' );
        $member = MemMembers::findFirst( array( 'id=?0', 'bind' => array( $id )) );
        
        if( $member )
        {
            $status = $member->update( array( 'delsign' => SystemEnums::DELSIGN_YES, 'uptime' => date( 'Y-m-d H:i:s'))); 
            if( $status )
            {
                $this->success( '删除成功' );
            }
        }
        $this->error( '删除失败' );
    }
    
   
}
