<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class OrdersReturns extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $mem_id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var integer
     */
    public $order_id;
    
     /**
     *
     * @var integer
     */
    public $goods_id;

    /**
     *
     * @var string
     */
    public $reason_content;

    /**
     *
     * @var integer
     */
    public $reason_type;

    /**
     *
     * @var double
     */
    public $money;

    /**
     *
     * @var string
     */
    public $addtime;

    /**
     *
     * @var string
     */
    public $express_no;

    /**
     *
     * @var integer
     */
    public $express_id;

     /**
     *
     * @var string
     */
    public $send_express_no;

    /**
     *
     * @var integer
     */
    public $send_express_id;
    /**
     *
     * @var string
     */
    public $handling_idea;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var integer
     */
    public $type;

    /**
     *
     * @var string
     */
    public $img;

    /**
     *
     * @var integer
     */
    public $shop_id;

    /**
     *
     * @var integer
     */
    public $uptime;

    /**
     *
     * @var integer
     */
    public $delsign;

    /**
     *
     * @var integer
     */
    public $after_sales_comment;
   
    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'mem_id' => 'mem_id', 
            'user_id' => 'user_id', 
            'goods_id' => 'goods_id',
            'order_id' => 'order_id', 
            'reason_content' => 'reason_content', 
            'reason_type' => 'reason_type', 
            'money' => 'money', 
            'addtime' => 'addtime', 
            'express_no' => 'express_no', 
            'express_id' => 'express_id', 
            'handling_idea' => 'handling_idea', 
            'status' => 'status', 
            'type' => 'type', 
            'img' => 'img', 
            'shop_id' => 'shop_id', 
            'uptime' => 'uptime', 
            'delsign' => 'delsign', 
            'after_sales_comment' => 'after_sales_comment',
            'send_express_no' => 'send_express_no', 
            'send_express_id' => 'send_express_id'
        );
    }
    
    public function initialize()
    {
         $this->useDynamicUpdate( true );
		 
		 $this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
    }
    
    /**
     * 获得退货单
     * @param int $shopId
     */
    public function getReturns( $shopId )
    {
        $phql = 'select o.order_sn, g.name as goods_name, a.name as member_name,r.id, r.type, r.addtime, u.name as user_name, r.status ' .
             'from apps\admin\models\OrdersReturns as r  '.
             'inner join apps\admin\models\OrdersSub as o on o.id = r.order_id ' . 
             'inner join apps\admin\models\GoodsTechan as g on g.id = r.goods_id ' .
             'inner join apps\admin\models\Orders as mo on mo.id = o.order_id ' .
             'inner join apps\admin\models\OrdersAddress as a on a.id = mo.addr_id ' .
             'left join apps\admin\models\PriUsers as u on u.id = r.user_id ' . 
             'where o.shop_id=' . $shopId  . ' and r.delsign='. SystemEnums::DELSIGN_NO . ' order by r.uptime desc';

        return $this->modelsManager->executeQuery( $phql ); 
    }
    
    /**
     * 获得退货的商品
     * @param int $returnId
     * @param int $shopId
     */
    public function getGoods( $returnId, $shopId )
    {
         $phql = 'select o.cnt as goods_num, g.thumb_url, g.name,g.price, r.id, r.order_id,r.goods_id,r.send_express_no,r.send_express_id, ' .
                'r.type, r.reason_type, r.reason_content,r.status, r.img, r.addtime, r.handling_idea,r.express_no,r.express_id ' .
                'from apps\admin\models\OrdersReturns as r ' .
                'inner join apps\admin\models\GoodsTechan as g on g.id = r.goods_id   ' .
                'inner join apps\admin\models\OrdersSubordersSpecs as o on o.suborder_id = r.order_id and o.goods_id = r.goods_id ' . 
                'where  r.id = :id:  and r.delsign= ' . SystemEnums::DELSIGN_NO . ' and r.shop_id=' . $shopId;
        
         $goods =  $this->modelsManager->executeQuery( $phql, array( 'id' => $returnId ));  
         if( $goods )
         {
             return $goods->getFirst();
         }
         return false;
    }
}
