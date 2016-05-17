<?php
/**
 * 会员管理
 * @author hfc
 * time 2015-7-23
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\MemMembers;
use apps\admin\models\ShopCoupon;
use apps\admin\models\ShopCouponDic;
use enums\MsgEnums;
use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class MemcouponsController extends AdminBaseController
{
    
    public function initialize()
    {
        parent::initialize();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '优惠券的首页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;
        
        $couponModel = new ShopCoupon();
        $list = $couponModel->getCoupons( $this->shopId );
        
        $pagination = new PaginatorModel( array(
          'data' => $list,
          'limit' => 10,
          'page' => $currentPage
        ) );
        
        $page = $pagination->getPaginate();
  
        $this->view->page = $page;
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '查看会员优惠券' )	
     * @method( method = 'readAction' )
     * @op( op = '' )		
    */
    public function readAction()
    {
        $id = $this->request->getQuery( 'id', 'int' );
        
        $coupon = ShopCouponDic::findFirst( array( 'id=?0', 'bind' => array( $id ) ));
        if( $coupon )
        {
            $data = $coupon->toArray();
            $data[ 'isRange' ] = $coupon->type ? 'none' : 'block';
            $data[ 'isInterval' ]  = $coupon->type ? 'block' : 'none';
          
            $this->view->coupon = $data;
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-26' )
     * @comment( comment = '添加会员优惠券到数据库' )	
     * @method( method = 'insertAction' )
     * @op( op = 'c' )		
    */
    public function insertAction()
    {
        
        $data[ 'memid' ] = $this->request->getPost( 'memId', 'int' );
        $data[ 'couponid' ] = $this->request->getPost( 'couponId', 'int' );
        
        $this->validation( $data );
        $data[ 'addtime' ] = $data[ 'uptime' ] = date( 'Y-m-d H;i:s' );
        $data[ 'delsign' ] = $data[ 'is_used' ] = 0;
        $data[ 'shopid' ] = $this->shopId;
        
        //判读优惠券是否发送
        $where = 'delsign=' . SystemEnums::DELSIGN_NO . ' and memid=' . $data[ 'memid']  . ' and couponid=' . $data[ 'couponid'];
        $isExist = ShopCoupon::findFirst(  $where );
        if( $isExist )
        {
            $this->error( '优惠券已经存在' );
        }
        //发送优惠券到邮箱
        $mem = MemMembers::findFirst( array( 'id=?0', 'bind' => array( $data[ 'memid' ]) ));
        $coup = ShopCouponDic::findFirst( array( 'id=?0', 'bind' => array( $data[ 'couponid' ])));
        $msg = '华尔商城赠送您一张优惠券：' . $coup->title . '，请您登陆华尔商城查收';
        
        $this->queue->put( array(
				'type' => \enums\MsgType::EMAIL_SEND,
				'body' => array(
                        'subject' => '华尔商城赠送优惠券',
						'message' => $msg,
						'email' => $mem->email,
				)	
		));
        $coupon = new ShopCoupon();
        $status = $coupon->save( $data );
        foreach( $coupon->getMessages() as $c )
        {
            echo $c->getMessage(), PHP_EOL;
        }
        if( $status )
        {
            $this->success( '发送优惠券成功' );
        }
        else
        {
            $this->error( '发送优惠券失败' );
        }
        
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-26' )
     * @comment( comment = 'ajax 请求 删除会员优惠券' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function deleteAction()
    {
//        $this->csrfCheck();
        $id = $this->request->getPost( 'id', 'int' );
        $member = ShopCoupon::findFirst( array( 'id=?0', 'bind' => array( $id )) );
        
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
    
     /**
     * @author( author='hfc' )
     * @date( date = '2015-8-26' )
     * @comment( comment = '验证数据' )	
     * @method( method = 'validation' )
     * @op( op = '' )		
    */
    public function validation( $data )
    {
        $validation = new Validation();
        $validation->add( 'memid', new PresenceOf(
            array( 'message' => '会员id必须填写' )
        ));
      
        $validation->add( 'couponid', new PresenceOf(
            array( 'message' => '优惠券id必须填写' )
        ));
         
        $msgs = $validation->validate( $data );
        
        if( count( $msgs ) )
        {
            foreach( $msgs as $msg )
            {
             
                $this->error( $msg->getMessage() );
            }
        }
    }
   
}
