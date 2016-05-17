<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class OrdersSubordersSpecs extends Model
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
    public $descr;

    /**
     *
     * @var integer
     */
    public $spec_id;

    /**
     *
     * @var integer
     */
    public $suborder_id;

    /**
     *
     * @var integer
     */
    public $cnt;
    /**
         *
         * @var integer
         */
    public $goods_id;
    
    public function initialize()
    {
        $this->useDynamicUpdate( true );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
    }
    
     /**
     * 获得订单下的商品
     * @param int $orderId
     * @param int $shopId
     * @return object
     */
    public function getOrderGoods( $orderId, $shopId )
    {
        $phql = 'select o.cnt as goods_num, g.name,g.price,g.id from apps\admin\models\OrdersSubordersSpecs as o ' .
                'inner join apps\admin\models\GoodsTechan as g on o.goods_id=g.id where o.suborder_id=:id: and o.delsign=' . SystemEnums::DELSIGN_NO;
        $goods = $this->_modelsManager->executeQuery( $phql, array( 'id' => $orderId ));  
        return $goods;
    }
    
     
}
