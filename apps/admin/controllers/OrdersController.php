<?php
/**
 * 订单管理
 * @author hfc
 * time 2015-7-5
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\CommonDistrictDic;
use apps\admin\models\Orders;
use apps\admin\models\OrdersAddress;
use apps\admin\models\OrdersFeightTrack;
use apps\admin\models\OrdersShipping;
use apps\admin\models\OrdersSub;
use apps\admin\models\OrdersSubordersSpecs;
use apps\admin\models\Payment;
use apps\admin\models\PriUsers;
use enums\MsgType;
use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class OrdersController extends AdminBaseController
{
    
    public function initialize()
    {
        parent::initialize();
       
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '首页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;
        
        $orderModel = new OrdersSub();
        $orders = $orderModel->getOrder( $this->shopId );
              
        $pagination = new PaginatorModel( array(
          'data' => $orders,
          'limit' => 10,
          'page' => $currentPage
        ) );
        
        $page = $pagination->getPaginate();
        $this->view->page = $page;
        
    }
    


    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '订单详情显示' )	
     * @method( method = 'readAction' )
     * @op( op = 'r' )		
    */
    public function readAction()
    {
        $orderId =  $this->request->getQuery( 'id', 'int' )  ;

        //商品信息
        $orderGoods = new OrdersSubordersSpecs();
        $goods = $orderGoods->getOrderGoods( $orderId, $this->shopId );
        if( $goods )
        {
            $this->view->goodsInfo = $goods->toArray();
        }
        
        //订单信息
        $order = OrdersSub::findFirst( array( 'id=:id: and shop_id=:shop_id:', 'bind' => array( 'id' => $orderId, 'shop_id' => $this->shopId )));
        if( $order )
        {
            $arrOrder = $order->toArray();
            
            //快递信息 取快递的公司 名称
            if( $order->freight_company )
            {
                $ship = OrdersShipping::findFirst( 'id=' . $order->freight_company );
                if( $ship )
                {
                    $arrOrder[ 'freightCompany' ] = $ship->name;
                }
            }
            $this->view->order = $arrOrder;
            
            //收货人信息
            $orderMainId = $order->order_id; //主订单的id
            $mainOrder = Orders::findFirst( 'id=' . $orderMainId );
            if( $mainOrder )
            {
                $memId = $mainOrder->mem_id;
                $address = OrdersAddress::findFirst(  'mem_id='. $memId . ' and id=' . $mainOrder->addr_id  );
                if( $address )
                {
                    $this->view->receiver = $address->toArray();
                    $this->view->province =  CommonDistrictDic::findFirst( $address->province )->toArray(); //省份
                    $this->view->city =  CommonDistrictDic::findFirst( $address->city )->toArray(); //市
                    $this->view->country =  CommonDistrictDic::findFirst(  $address->district )->toArray(); //县
                }
            }
         
            //获得支付方式
            $pay = Payment::findFirst( $order->pay_id );
            if( $pay )
            {
                $this->view->pay = $pay->toArray();
            }
            
            //取得 快递跟踪
            $orderTrack = new OrdersFeightTrack();
            $track = $orderTrack->getFeight( $order->id );
            if( $track )
            {
                $this->view->track = $track;
            }
        }     
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '填写发货' )	
     * @method( method = 'deliverAction' )
     * @op( op = '' )		
    */
    public function deliverAction()
    {
        $this->readAction();
        
        $ship = OrdersShipping::find( 'delsign=' . SystemEnums::DELSIGN_NO );
        if( $ship )
        {
            $this->view->ship = $ship->toArray();
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '打印订单' )	
     * @method( method = 'printAction' )
     * @op( op = 'c' )		
    */
    public function printAction()
    {
         $orderId =  $this->request->getQuery( 'id', 'int' )  ;
        //商品信息
        $orderGoods = new OrdersSubordersSpecs();
        $goods = $orderGoods->getOrderGoods( $orderId, $this->shopId );
        if( $goods )
        {
            $this->view->goodsInfo = $goods->toArray();
        }
        
        //订单信息
        $order = OrdersSub::findFirst( array( 'id=:id: and shop_id=:shop_id:', 'bind' => array( 'id' => $orderId, 'shop_id' => $this->shopId )));   
        if( $order )
        {
            $orderMainId = $order->order_id; //主订单的id
             $this->view->order = $order->toArray();       
             //收货人信息
            $mainOrder = Orders::findFirst( 'id=' . $orderMainId );
            if( $mainOrder )
            {
                $memId = $mainOrder->mem_id;
                $address = OrdersAddress::findFirst(  'mem_id='. $memId . ' and id=' . $mainOrder->addr_id  );
                if( $address )
                {
                    $provice  = CommonDistrictDic::findFirst( 'id=' . $address->province );
                    $addressName = $provice ? $provice->name . ' ' : '';

                    $city  = CommonDistrictDic::findFirst( 'id=' . $address->city );
                    $addressName .= $city ? $city->name . ' ' : '';

                    $country  = CommonDistrictDic::findFirst( 'id=' . $address->district  );
                    $addressName .= $country ? $country->name . ' ' : '';

                    $this->view->receiver = $address->toArray();
                    $this->view->addressName = $addressName . $address->detail;
                }
            }
            //把打印订单的行为写在日志中
            $track = new OrdersFeightTrack();
            $data[ 'addtime' ] = $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
            $data[ 'delsign' ] = 0;
            $data[ 'user_id' ] = $this->userId;
            $data[ 'order_id' ] = $order->id; //子订单的id
            $data[ 'content' ] = '订单已经打印';
            $track->save( $data );
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '保存发货' )	
     * @method( method = 'saveDeliverAction' )
     * @op( op = 'c' )		
    */
    public function saveDeliverAction()
    {
        $orderId = $this->request->getPost( 'id', 'int' );
        $data[ 'freight_company' ] = $this->request->getPost( 'freight_company', 'int' );
        $data[ 'freight_sn' ] = $this->request->getPost( 'freight_sn', 'string' );
        $data[ 'freight_accesstime' ] = date( 'Y-m-d H:i:s' );
        $data[ 'status' ] = SystemEnums::ORDER_WAIT_BUYER_CONFIRM_GOODS;
        $order = OrdersSub::findFirst( array( 'id=?0', 'bind' => array( $orderId ) ) );
        
        if( $order )
        {
            $status = $order->update( $data );
            if( $status )
            {
//               //保存发货成功后要通知一下支付宝
//                $payment = new Payment( $order->pay_id );
//                $paymentPlugin = $payment->getPaymentPlugin();
//                $status =  $paymentPlugin->delivery( $order->trade_no, $data[ 'freight_company'], $data[ 'freight_sn'] );
//                if( ! $status )
//                {
//                    $this->error( '支付宝发货失败' );
//                }
               //把发货时间写在日志中
                $data[ 'content' ] = '已经发货，发货单号为：' . $data[ 'freight_sn' ];
                $data[ 'addtime' ] = $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
                $data[ 'delsign' ] = SystemEnums::DELSIGN_NO;
                $data[ 'user_id' ] = $this->userId; 
                $data[ 'mem_id' ] = $order->mem_id;
                $data[ 'order_id' ] = $orderId;
                $data[ 'shipping_type' ] = '';
                $flow = new OrdersFeightTrack();
                
                $status =  $flow->save( $data );
                 
                if( $status )
                {
                     $this->queue->put(  array(
                        'type' => MsgType::ORDER_WAIT_RECEIVE,
                        'body' => array( 'id' => $this->shopId  )
                    ));
                    $this->success( '发货成功' );   
                }
              
            }
        }
         $this->error( '发货失败' );   
    }

    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '获得收货的地址' )	
     * @method( method = 'getAddressAction' )
     * @op( op = '' )		
    */
    public function getAddressAction()
    {
        $id = $this->request->getQuery( 'id', 'int' );
        $address = CommonDistrictDic::find( array( 'upid=?0', 'bind' => array( $id ) ));
        if( $address != false )
        {
            $data[ 'address' ] = $address->toArray();
            $this->success( '获得地址成功', $data );
        }
        else
        {
            $this->error( '获得地址失败');

        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '取消订单' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function deleteAction()
    {
        //        $this->csrfCheck();
        $id = $this->request->getPost( 'id', 'int' );
        $user = OrdersSub::findFirst( array( 'id=?0', 'bind' => array( $id )) );
        
        if( $user )
        {
            $status = $user->update( array( 'delsign' => SystemEnums::DELSIGN_YES, 'uptime' => date( 'Y-m-d H:i:s')));
            if( $status )
            {
                 $this->success( '删除成功' );
            }
        }
        $this->error( '删除失败' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-9-11' )
     * @comment( comment = '锁定订单' )	
     * @method( method = 'lockAction' )
     * @op( op = '' )		
    */
    public function lockAction()
    {
        $id = $this->request->get( 'id' );
        $key = 'shop' . $this->shopId . 'order' . $id ;
        $data = $this->memCache->get( $key );
        
        if( ! $data  ) //还没有人在处理
        {
            $this->memCache->save( $key, array( 
            'userId' => $this->userId,
            'orderId' => $id
            ), 600 ); //缓存10分钟，告诉管理者有人正在处理同一个订单
           
        }
        else if( $data[ 'userId'] != $this->userId ) //已经有人在处理，看看是不是自己
        {
            $user = PriUsers::findFirst( 'id=' . $data[ 'userId'] );
            $msg = $user->name . ' ' .  date( 'H:i:s' ) . ' 正在处理该订单';

            $this->error( $msg );
        }
        
        $this->success( '已经锁定订单' );
    }
    
     /**
     * @author( author='hfc' )
     * @date( date = '2015-9-15' )
     * @comment( comment = '订单结算' )	
     * @method( method = 'balanceAction' )
     * @op( op = '' )		
    */
    public function balanceAction()
    {
        $id = $this->request->getPost( 'id', 'int' );
     
        $order = OrdersSub::findFirst( array( 'id=?0', 'bind' => array( $id ) ));
        if( $order )
        {
            $data[ 'status' ] = SystemEnums::ORDER_TRADE_SUCCESS; 
            $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
            $status = $order->update( $data );
            
            if( $status )
            {
                $this->success( '结算成功' );
            }
        }
        
        $this->error( '结算失败' );
    }
}
