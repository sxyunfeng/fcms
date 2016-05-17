<?php

/**
 * 支付配置
 * @author hfc
 * @date 2015-8-31
 */

namespace apps\admin\controllers;

use apps\admin\models\Payment;
use apps\admin\models\PaymentPlugin;
use enums\SystemEnums;
use Phalcon\Db\Profiler;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class PayconfigController extends AdminBaseController
{
    public function initialize()
    {
        parent::initialize();
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2015-8-31' )
    * @comment( comment = '使用支付' )	
    * @method( method = 'indexAction' )
    * @op( op = 'r' )		
   */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;
        
        $payModel = new Payment();
        $pay =  $payModel->getPayment( $this->shopId );       
        
        $pagination = new PaginatorModel( array( 'data' => $pay,
            'limit' => 10,
            'page' => $currentPage
            ));
        $page = $pagination->getPaginate();
        $this->view->page = $page;
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2015-8-31' )
    * @comment( comment = '全部支付' )	
    * @method( method = 'indexAction' )
    * @op( op = 'r' )		
   */
    public function allAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;
        
        $pay = PaymentPlugin::find( 'delsign=' . SystemEnums::DELSIGN_NO );       
        
        $pagination = new PaginatorModel( array( 'data' => $pay,
            'limit' => 10,
            'page' => $currentPage
            ));
        $page = $pagination->getPaginate();
        $this->view->page = $page;
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2015-8-31' )
    * @comment( comment = '删除已使用的支付' )	
    * @method( method = 'deleteAction' )
    * @op( op = 'd' )		
   */
    public function deleteAction()
    {
        $id = $this->request->getPost( 'id', 'int' );
        $profile = new Profiler();
        $payment = Payment::findFirst( array( 'id=?0', 'bind' => array( $id )));
        
        if( $payment )
        {
            $status =  $payment->update( array( 'delsign' => SystemEnums::DELSIGN_YES ) );
      
            if( $status )
            {
                $this->success( '删除成功' );
            }
            else
            {
                $this->error( '删除失败' );
            }
        }
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2015-9-1' )
    * @comment( comment = '使用支付的添加显示' )	
    * @method( method = 'editAction' )
    * @op( op = '' )		
   */
    public function addAction()
    {
        $id = $this->request->getQuery( 'id', 'int' );
        if( $id )
        {
            $plugin = PaymentPlugin::findFirst( array( 'id=?0', 'bind' => array( $id ), 'columns' => 'id,name'));
            if( $plugin )
            {
                $this->view->plugin = $plugin->toArray();
            }
        }
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2015-9-1' )
    * @comment( comment = '使用支付的编辑' )	
    * @method( method = 'editAction' )
    * @op( op = '' )		
   */
    public function editAction()
    {
        $id = $this->request->getQuery( 'id', 'int' );
        $pay = Payment::findFirst( array( 'id=?0', 'bind' => array( $id )));
        if( $pay )
        {
            $this->view->pay = $pay->toArray();
        }
    }
    
     /**
    * @author( author='hfc' )
    * @date( date = '2015-9-1' )
    * @comment( comment = '使用支付的编辑' )	
    * @method( method = 'editAction' )
    * @op( op = '' )		
   */
    public function readAction()
    {
       $this->editAction();
       $this->view->isRead = true;
       $this->view->pick( 'payconfig/edit' );
    }
    
     /**
    * @author( author='hfc' )
    * @date( date = '2015-9-1' )
    * @comment( comment = '使用支付的更新' )	
    * @method( method = 'updateAction' )
    * @op( op = 'u' )		
   */
    public function updateAction()
    {
        $this->csrfCheck();
        
        $id = $this->request->getPost( 'id', 'int' );
        $data[ 'pay_name' ] = $this->request->getPost( 'pay_name', 'string' );
        $data[ 'partner_id' ] = $this->request->getPost( 'partner_id', 'string' );
        $data[ 'partner_key' ] = $this->request->getPost( 'partner_key', 'string' );
        $data[ 'status' ] = $this->request->getPost( 'status', 'int' );
        $data[ 'sort' ] = $this->request->getPost( 'sort', 'int' );
        
        $this->validation( $data );
        
        $pay = Payment::findFirst( array( 'id=?0', 'bind' => array( $id )));
        if( $pay )
        {
            $status = $pay->update( $data );
            if( $status )
            {
                $this->success( '更新成功' );
            }
        }
        $this->error( '更新失败' );
    }
    
      /**
    * @author( author='hfc' )
    * @date( date = '2015-9-1' )
    * @comment( comment = '使用支付的添加' )	
    * @method( method = 'insertAction' )
    * @op( op = 'c' )		
   */
    public function insertAction()
    {
        $this->csrfCheck();
        
        $data[ 'pay_name' ] = $this->request->getPost( 'pay_name', 'string' );
        $data[ 'plugin_id' ] = $this->request->getPost( 'plugin_id', 'string' );
        $data[ 'partner_id' ] = $this->request->getPost( 'partner_id', 'string' );
        $data[ 'partner_key' ] = $this->request->getPost( 'partner_key', 'string' );
        $data[ 'status' ] = $this->request->getPost( 'status', 'int' );
        $data[ 'sort' ] = $this->request->getPost( 'sort', 'int' );
        
        $this->validation( $data );
        $data[ 'delsign' ] = $data[ 'status' ] = 0;
        $data[ 'shop_id' ] = $this->shopId;
        
        $pay = new Payment();
        if( $pay )
        {
            $status = $pay->save( $data );
            if( $status )
            {
                $this->success( '添加成功' );
            }
        }
        $this->error( '添加失败' );
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2015-9-1' )
    * @comment( comment = '验证数据' )	
    * @method( method = 'validation' )
    * @op( op = 'u' )		
   */
    private function validation( $data )
    {
        $validation =  new Validation();
        $validation->add( 'partner_id', new PresenceOf( array(
                 'message' =>  '合作者身份必学填写' 
        ) ) );
        $validation->add( 'partner_key', new PresenceOf( array(
                 'message' =>  '安全校验码必学填写' 
        ) ) );
        
        $msgs  = $validation->validate( $data );
        if( count( $msgs ))
        {
            foreach( $msgs as $m )
            {
                $this->error( $m->getMessage() );
            }
        }
    }
}
