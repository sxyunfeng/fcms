<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class GoodsTechan extends Model
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
    public $shelve_time;

    /**
     *
     * @var string
     */
    public $name;

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
     * @var string
     */
    public $weight;

    /**
     *
     * @var integer
     */
    public $address;

    /**
     *
     * @var double
     */
    public $price;

    /**
     *
     * @var string
     */
    public $unshelve_time;

    /**
     *
     * @var string
     */
    public $uptime;

    /**
     *
     * @var integer
     */
    public $brand_id;

    /**
     *
     * @var integer
     */
    public $commnum;

    /**
     *
     * @var integer
     */
    public $focusnum;

    /**
     *
     * @var integer
     */
    public $skuaccum;

    /**
     *
     * @var integer
     */
    public $skuleft;

    /**
     *
     * @var integer
     */
    public $cat_id;

    /**
     *
     * @var integer
     */
    public $shop_id;

    /**
     *
     * @var double
     */
    public $discount;

    /**
     *
     * @var string
     */
    public $thumb_url;
    public $status;

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id'            => 'id',
            'addtime'       => 'addtime',
            'shelve_time'   => 'shelve_time',
            'name'          => 'name',
            'delsign'       => 'delsign',
            'descr'         => 'descr',
            'weight'        => 'weight',
            'address'       => 'address',
            'price'         => 'price',
            'unshelve_time' => 'unshelve_time',
            'uptime'        => 'uptime',
            'brand_id'      => 'brand_id',
            'commnum'       => 'commnum',
            'focusnum'      => 'focusnum',
            'skuaccum'      => 'skuaccum',
            'skuleft'       => 'skuleft',
            'cat_id'        => 'cat_id',
            'shop_id'       => 'shop_id',
            'discount'      => 'discount',
            'thumb_url'     => 'thumb_url',
            'status'        => 'status',
        );
    }

    public function initialize()
    {
        $this->useDynamicUpdate( TRUE );
		
        $this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
        
        $this->belongsTo( 'cat_id' , 'apps\admin\models\GoodsCats' , 'id' , array( 'alias' => 'gcates' ) );
    }

    /**
     * 获得商品
     * @param int $shopId
     * @param string $goodsName
     */
    public function getGoods( $shopId, $goodsName )
    {
        $where = 'g.delsign=' .  SystemEnums::DELSIGN_NO . ' and g.shop_id=:shopId:';
        $data = array( 'shopId' => $shopId );
        if( $goodsName )
        {
            $where .= ' and g.name like :goodsName: ';
            $data = array( 'shopId' => $shopId, 'goodsName' => '%' . $goodsName . '%' );
        }
        $phql = 'select g.id,g.thumb_url,g.name,g.skuleft,g.status,g.price,g.skuaccum,a.name as category_name from '
                . ' apps\admin\models\GoodsTechan as g join apps\admin\models\GoodsCats as a'
                . ' on g.cat_id = a.id where ' . $where . ' order by g.uptime desc';

        $goods = $this->modelsManager->executeQuery( $phql, $data );
        return $goods;
    }

}
