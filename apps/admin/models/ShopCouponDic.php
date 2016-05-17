<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class ShopCouponDic extends Model
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
     * @var string
     */
    public $datefrom;

    /**
     *
     * @var string
     */
    public $dateto;

    /**
     *
     * @var double
     */
    public $lowlimit;

    /**
     *
     * @var integer
     */
    public $shopid;

    /**
     *
     * @var double
     */
    public $value;

    /**
     *
     * @var string
     */
    public $pic;

    /**
     *
     * @var integer
     */
    public $dateinterval;

    /**
     *
     * @var integer
     */
    public $type;

    /**
     *
     * @var string
     */
    public $title;

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
            'datefrom' => 'datefrom', 
            'dateto' => 'dateto', 
            'lowlimit' => 'lowlimit', 
            'shopid' => 'shopid', 
            'value' => 'value', 
            'pic' => 'pic', 
            'dateinterval' => 'dateinterval', 
            'type' => 'type', 
            'title' => 'title'
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
}
