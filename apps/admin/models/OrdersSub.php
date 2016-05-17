<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class  OrdersSub extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $addtime;

    /**
     *
     * @var string
     */
    public $uptime;

    /**
     *
     * @var integer
     */
    public $delsign;

    /**
     *
     * @var string
     */
    public $desc;

    /**
     *
     * @var integer
     */
    public $order_id;

    /**
     *
     * @var double
     */
    public $freight_fee;

    /**
     *
     * @var double
     */
    public $order_amount;

    /**
     *
     * @var double
     */
    public $discount_amount;

    /**
     *
     * @var double
     */
    public $sum;

    /**
     *
     * @var string
     */
    public $invoice_title;

    /**
     *
     * @var integer
     */
    public $invoice_type;

    /**
     *
     * @var string
     */
    public $invoice_content;

    /**
     *
     * @var integer
     */
    public $pay_type;

    /**
     *
     * @var integer
     */
    public $shop_id;

    /**
     *
     * @var string
     */
    public $feight_sn;

    /**
     *
     * @var string
     */
    public $feight_content;

    /**
     *
     * @var integer
     */
    public $feight_company;

    /**
     *
     * @var string
     */
    public $feight_accesstime;

    /**
     *
     * @var string
     */
    public $pay_id;

    /**
     *
     * @var integer
     */
    public $mem_id;
    
    public function initialize()
    {
        $this->useDynamicUpdate( true );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
    }
    
    /**
     * 获得订单
     * @param int $shopId
     * @return obj
     */
    public function getOrder( $shopId )
    {
        $phql = 'select o.order_sn,o.addtime,o.pay_id,o.sum,o.status,o.id, p.pay_name from apps\admin\models\OrdersSub as o join apps\admin\models\Payment as p on o.pay_id = p.id ' . 
                'where o.delsign='. SystemEnums::DELSIGN_NO . ' and  o.shop_id='. $shopId . ' order by o.addtime desc';
        $order = $this->getModelsManager()->executeQuery( $phql );
        return $order;
    }
    
    /**
     * 获得发货单
     * @param int $shopId
     * @return object
     */
    public function getDeliver( $shopId )
    {
        $where = 'where o.delsign=' .  SystemEnums::DELSIGN_NO . ' and o.status >' . SystemEnums::ORDER_WAIT_SELLER_SEND_GOODS; //发货了的订单
        if( $this->shopId ) //只查自己商铺的订单
        {
            $where .= ' and o.shop_id=' . $shopId;
        }

        $phql = 'select o.freight_sn, o.id, o.freight_accesstime, a.name, a.tel, s.name as freight_name '.
                'from apps\admin\models\OrdersSub as o '. 
                'join apps\admin\models\Orders as m on m.id = o.order_id '  .
                'join apps\admin\models\OrdersShipping as s on o.freight_company = s.id '  .
                'join apps\admin\models\OrdersAddress as a on a.mem_id = m.mem_id ' . $where  . ' order by o.addtime desc';
        $orders = $this->modelsManager->executeQuery( $phql ); 
        return $orders;
    }
}
