<?php
/**
 * 退货管理
 * @author hfc
 * time 2015-7-5
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\CommonDistrictDic;
use apps\admin\models\Orders;
use apps\admin\models\OrdersAddress;
use apps\admin\models\OrdersReturns;
use apps\admin\models\OrdersReturnsFlow;
use apps\admin\models\OrdersShipping;
use apps\admin\models\OrdersSub;
use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ReturnsController extends AdminBaseController
{
    public function initialize()
    {
        parent::initialize();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '退货的首页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;

        $returns = new OrdersReturns();
        $orders = $returns->getReturns( $this->shopId );
        
        $pagination = new PaginatorModel( array(
          'data' => $orders,
          'limit' => 10,
          'page' => $currentPage
        ) );
        
        $page = $pagination->getPaginate();
        foreach( $page->items as & $item ) //把时间改为字符串格式
        {
            $item->addtime = date( 'Y-m-d H:i:s', $item->addtime );
         
        }
        $this->view->page = $page;
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '退货详情显示' )	
     * @method( method = 'readAction' )
     * @op( op = 'r' )		
    */
    public function readAction()
    {
         $returnId =  $this->request->getQuery( 'id', 'int' )  ;
         
        //商品信息
        $return = new OrdersReturns();
        $goods = $return->getGoods( $returnId, $this->shopId );
        if( $goods )
        {
            $orderId =  $goods->order_id;
          
            if( isset( $goods->express_id ))
            {
                $express = OrdersShipping::findFirst( 'id=' . $goods->express_id );
                $goods->express_name  = $express ? $express->name : '';
                $goods->addtime  = date( 'Y-m-d H:i:s');
            }
           
            $this->view->goodsReturn = $goods->toArray();
        }
        
        //快递公司
        $express = OrdersShipping::find( 'delsign=' .SystemEnums::DELSIGN_NO );
        $this->view->sendExpress = $express;
        
        //订单信息
        $order = OrdersSub::findFirst( array( 'id=:id:', 'bind' => array( 'id' => $orderId )));   
        if( $order )
        {
            $orderMainId = $order->order_id; //主订单的id
            $freight = OrdersShipping::findFirst( 'id=' . $order->freight_company );
            if( $freight ) //快递公司
            {
                $order = $order->toArray();
                $order[ 'freightCompany' ] = $freight->name;
            }
            $this->view->order = $order;
            
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
            
            //取得 退货商品的跟踪
            $flow = new OrdersReturnsFlow();
            $track = $flow->getLog( $returnId );

            if( $track )
            {
                $this->view->track = $track;
            }
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '审核' )	
     * @method( method = 'saveAction' )
     * @op( op = 'u' )		
    */
    public function saveAction()
    {
       $id = $this->request->getPost( 'id', 'int' ); 
       $data[ 'handling_idea' ] = $this->request->getPost( 'content', 'string' );
       $data[ 'status'] = $this->request->getPost( 'agree', 'int' );
       $data[ 'user_id'] = $this->userId;
       
       $return = OrdersReturns::findFirst( array( 'id=?0', 'bind' => array( $id )));
       $status = $return->update( $data );
       if( $status )
       {
           $this->writeLog( $id, '卖家审核完成' );
           $this->success( '保存成功' );
       }
       else
       {
           $this->error( '处理失败' );
       }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '删除退货' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function deleteAction()
    {
       $data[ 'id' ] = $this->request->getPost( 'id', 'int' ); 
      
       $phql = 'update apps\admin\models\OrdersReturns set delsign= ' .SystemEnums::DELSIGN_YES . ' where  id=:id:';
       $status = $this->modelsManager->executeQuery($phql, $data );
       if( $status->success() )
       {
           $this->success( '删除成功' );
       }
       else
       {
           $this->error( '删除失败' );
       }
    }
     
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '发货' )	
     * @method( method = 'sendAction' )
     * @op( op = 'u' )		
    */
    public function sendAction()
    {
       $id = $this->request->getPost( 'id', 'int' ); 
       $data[ 'send_express_no' ] = $this->request->getPost( 'send_express_no', 'string' ); 
       $data[ 'send_express_id' ] = $this->request->getPost( 'send_express_id', 'int' ); 
       $data[ 'status'] = SystemEnums::REFUND_SELLER_SEND_GOODS ; 

       $return = OrdersReturns::findFirst( array( 'id=?0', 'bind' => array( $id )) );
       $status = $return->update( $data );
       if( $status )
       {
            $this->writeLog( $id, '卖家发货完成' );
            $this->success( '发货完成' );
       }
       else
       {
           $this->error( '发货失败' );
       }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '退款' )	
     * @method( method = 'refundAction' )
     * @op( op = 'u' )		
    */
    public function refundAction()
    {
       $id = $this->request->getPost( 'id', 'int' ); 
       $data[ 'status' ] = 5; //已退款
       
       $return = OrdersReturns::findFirst( array( 'id=?0', 'bind' => array( $id )) );
       $status = $return->update( $data );
       if( $status )
       {
           $this->writeLog( $id, '卖家退款完成' );
           $this->success( '退款完成' );
       }
       else
       {
           $this->error( '退款失败' );
       }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '写日志到退货跟踪' )	
     * @method( method = 'writeLog' )
     * @op( op = 'c' )		
    */
    public function writeLog( $returnId, $msg )
    {
        $flow = new OrdersReturnsFlow();
        $data[ 'content' ] = $msg; 
        $data[ 'addtime' ] = date( 'Y-m-d H:i:s' );
        $data[ 'delsign' ] = 0;
        $data[ 'return_id' ] = $returnId;
        $data[ 'user_id' ] = $this->userId;
        
        $status = $flow->save( $data );
        foreach( $flow->getMessages() as $msg )
        {
            echo $msg, PHP_EOL;
        }
        
    }
}
