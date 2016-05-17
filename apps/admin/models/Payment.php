<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Payment extends Model
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
    public $plugin_id;

    /**
     *
     * @var string
     */
    public $pay_name;

    /**
     *
     * @var string
     */
    public $partner_id;

    /**
     *
     * @var string
     */
    public $partner_key;

    /**
     *
     * @var integer
     */
    public $client_type;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var string
     */
    public $note;

    /**
     *
     * @var double
     */
    public $pay_fee;

    /**
     *
     * @var integer
     */
    public $fee_type;

    /**
     *
     * @var integer
     */
    public $sort;

    /**
     *
     * @var integer
     */
    public $delsign;

    /**
     * 
     * @var integer
     */
    public $shop_id;
    
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
            'id' => 'id', 
            'plugin_id' => 'plugin_id', 
            'pay_name' => 'pay_name', 
            'partner_id' => 'partner_id', 
            'partner_key' => 'partner_key', 
            'client_type' => 'client_type', 
            'description' => 'description', 
            'note' => 'note', 
            'pay_fee' => 'pay_fee', 
            'fee_type' => 'fee_type', 
            'sort' => 'sort', 
            'delsign' => 'delsign',
            'shop_id' => 'shop_id',
            'status' => 'status'
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
     * 获得已经开启的配置
     * @param int $shopId
     * @return obj payment
     */
    public function getPayment( $shopId )
    {
        $phql =  'select p.id, p.pay_name, p.status, pp.logo from apps\admin\models\Payment as p ' . 
                'left join apps\admin\models\PaymentPlugin as pp on pp.id = p.plugin_id ' .
                'where p.delsign=' . SystemEnums::DELSIGN_NO . ' and p.shop_id=' . $shopId .
                ' order by p.sort';
                
        $payment = $this->getModelsManager()->executeQuery( $phql );
        return $payment;
    }
}
