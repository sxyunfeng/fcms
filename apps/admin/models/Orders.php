<?php

namespace apps\admin\models;

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

class Orders extends \Phalcon\Mvc\Model
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
    public $mem_id;

    /**
     *
     * @var string
     */
    public $order_sn;

    /**
     *
     * @var double
     */
    public $discount_amount;

    /**
     *
     * @var integer
     */
    public $addr_id;

    /**
     *
     * @var double
     */
    public $sum;

    /**
     *
     * @var double
     */
    public $order_amount;
    
    public function initialize()
    {
        $this->useDynamicUpdate( true );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
    }
    
}
