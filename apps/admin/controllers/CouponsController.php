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
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class CouponsController extends AdminBaseController
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
        
        $where = 'delsign=' . SystemEnums::DELSIGN_NO . ' and shopid=' . $this->shopId;
        $list = ShopCouponDic::find( $where  );
        
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
     * @comment( comment = '查看优惠券' )	
     * @method( method = 'readAction' )
     * @op( op = '' )		
    */
    public function readAction()
    {
        $this->editAction();
        $this->view->isRead = true;
        $this->view->pick( 'coupons/edit' );
    }
    
     /**
     * @author( author='hfc' )
     * @date( date = '2015-8-26' )
     * @comment( comment = '添加优惠券' )	
     * @method( method = 'addAction' )
     * @op( op = '' )		
    */
    public function addAction()
    {
        
    }
    
     /**
     * @author( author='hfc' )
     * @date( date = '2015-8-26' )
     * @comment( comment = '添加优惠券' )	
     * @method( method = 'editAction' )
     * @op( op = '' )		
    */
    public function editAction()
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
     * @comment( comment = '添加优惠券到数据库' )	
     * @method( method = 'insertAction' )
     * @op( op = 'c' )		
    */
    public function insertAction()
    {
        $data[ 'title' ] = $this->request->getPost( 'title', 'string' );
        $data[ 'type' ] = $this->request->getPost( 'type', 'int' );
        $data[ 'datefrom' ] = $this->request->getPost( 'datefrom', 'string' );
        $data[ 'dateto' ] = $this->request->getPost( 'dateto', 'string' );
        $data[ 'dateinterval' ] = $this->request->getPost( 'dateinterval', 'string' );
        $data[ 'lowlimit' ] = $this->request->getPost( 'limit', 'string' );
        $data[ 'pic' ] = $this->request->getPost( 'pic', 'string' );
        $data[ 'value' ] = $this->request->getPost( 'value', 'float' );
        
        $this->validation( $data );
        $data[ 'addtime' ] = $data[ 'uptime' ] = date( 'Y-m-d H;i:s' );
        $data[ 'delsign' ] = 0;
        $data[ 'shopid' ] = $this->shopId;
        
        $coupon = new ShopCouponDic();
        $status = $coupon->save( $data );
        foreach( $coupon->getMessages() as $c )
        {
            echo $c->getMessage(), PHP_EOL;
        }
        if( $status )
        {
            $this->success( '保存优惠券成功' );
        }
        else
        {
            $this->error( '保存优惠券失败' );
        }
        
    }
    
     /**
     * @author( author='hfc' )
     * @date( date = '2015-8-26' )
     * @comment( comment = '更新优惠券到数据库' )	
     * @method( method = 'updateAction' )
     * @op( op = 'u' )		
    */
    public function updateAction()
    {
        $id = $this->request->getPost( 'id', 'int');
        $data[ 'title' ] = $this->request->getPost( 'title', 'string' );
        $data[ 'type' ] = $this->request->getPost( 'type', 'int' );
        $data[ 'datefrom' ] = $this->request->getPost( 'datefrom', 'string' );
        $data[ 'dateto' ] = $this->request->getPost( 'dateto', 'string' );
        $data[ 'dateinterval' ] = $this->request->getPost( 'dateinterval', 'string' );
        $data[ 'lowlimit' ] = $this->request->getPost( 'limit', 'float' );
        $data[ 'pic' ] = $this->request->getPost( 'pic', 'string' );
        $data[ 'value' ] = $this->request->getPost( 'value', 'float' );
    
        $this->validation( $data );
        $data[ 'uptime' ] = date( 'Y-m-d H;i:s' );
        
        $coupon = ShopCouponDic::findFirst( array( 'id=?0', 'bind' => array( $id )));
        if( $coupon )
        {
            $status = $coupon->update( $data );
            if( $status )
            {
                $this->success( '更新成功' );
            }
        }
        $this->error( '更新失败' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-26' )
     * @comment( comment = 'ajax 请求 删除优惠券' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function deleteAction()
    {
//        $this->csrfCheck();
        $id = $this->request->getPost( 'id', 'int' );
        $member = ShopCouponDic::findFirst( array( 'id=?0', 'bind' => array( $id )) );
        
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
        $df = strtotime( $data[ 'datefrom' ] );
        $dt = strtotime( $data[ 'dateto'] );
        if( $dt < $df )
        {
            $this->error( '终止日期不能小于起始日期' );
        }
        
        $validation = new Validation();
        $validation->add( 'title', new PresenceOf(
            array( 'message' => '优惠券标题必须填写' )
        ));
        $validation->add( 'lowlimit', new PresenceOf(
            array( 'lowlimit' => '优惠券消费最低消费金额不能为空' )
        ));
        $validation->add( 'value', new PresenceOf(
            array( 'message' => '优惠券金额不能为空' )
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
