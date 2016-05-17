<?php
/**
 * 用户管理
 * @author hfc
 * time 2015-7-5
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\CommonDistrictDic;
use apps\admin\models\MemMembers;
use apps\admin\models\Orders;
use apps\admin\models\OrdersAddress;
use apps\admin\models\OrdersShipping;
use apps\admin\models\OrdersSub;
use apps\admin\models\OrdersSubordersSpecs;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class DeliversController extends AdminBaseController
{
    public function initialize()
    {
        parent::initialize();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '发货的首页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;
        
        $model = new OrdersSub();
        $data = $model->getDeliver( $this->shopId );
                  
        $pagination = new PaginatorModel( array(
          'data' => $data,
          'limit' => 10,
          'page' => $currentPage
        ) );
        
        $page = $pagination->getPaginate();

        $this->view->page = $page;
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '发货详情显示' )	
     * @method( method = 'readAction' )
     * @op( op = '' )		
    */
    public function readAction()
    {
         $orderId =  $this->request->getQuery( 'id', 'int' )  ;
         
        //商品信息
        $model = new OrdersSubordersSpecs();
        $goods = $model->getOrderGoods( $orderId );
        
        if( $goods )
        {
            $this->view->goodsInfo = $goods->toArray();
        }
        
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
                $this->view->order = $order;
            }
            
             //收货人信息
            $mainOrder = Orders::findFirst( 'id=' . $orderMainId );
            if( $mainOrder )
            {
                $memId = $mainOrder->mem_id;
                $mem = MemMembers::findFirst( array( 'id' => $memId, 'columns' => 'username' ));
                if( $mem )
                {
                    $this->view->username = $mem->username;
                }
                
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
        }
    }
    
     /**
     * @author( author='hfc' )
     * @date( date = '2015-9-16' )
     * @comment( comment = '发货单打印' )	
     * @method( method = 'printAction' )
     * @op( op = '' )		
    */
    public function printAction()
    {
        $this->readAction();
    }
}
