<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model;

class ShopCoupon extends Model
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
    public $shopid;

    /**
     *
     * @var integer
     */
    public $memid;

    /**
     *
     * @var integer
     */
    public $couponid;

    /**
     *
     * @var integer
     */
    public $is_used;

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
            'addtime' => 'addtime', 
            'uptime' => 'uptime', 
            'delsign' => 'delsign', 
            'descr' => 'descr', 
            'shopid' => 'shopid', 
            'memid' => 'memid', 
            'couponid' => 'couponid', 
            'is_used' => 'is_used'
        );
    }

    /**
     * 获得会员的优惠券
     * @param int $shopId
     * @return obj
     */
     public function getCoupons( $shopId )
    {
        $phql = 'select m.username,c.id,c.is_used,c.couponid,d.datefrom,d.dateto, d.dateinterval,d.type,d.value,d.lowlimit,d.title ' .
                'from apps\admin\models\ShopCoupon  as c ' .
                'join apps\admin\models\MemMembers as m on m.id = c.memid ' .
                'join apps\admin\models\ShopCouponDic  as d on d.id = c.couponid ' .
                'where c.delsign = ' . SystemEnums::DELSIGN_NO . ' and c.shopid = ' . $shopId .  ' and d.delsign=' . SystemEnums::DELSIGN_NO ;
               
        $coupons = $this->getModelsManager()->executeQuery( $phql );
        return $coupons;
    }
}
