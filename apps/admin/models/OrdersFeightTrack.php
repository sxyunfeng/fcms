<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class OrdersFeightTrack extends Model
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
    public $order_id;

    /**
     *
     * @var integer
     */
    public $mem_id;

    /**
     *
     * @var string
     */
    public $content;

    /**
     *
     * @var string
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $shipping_type;

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
            'uptime'        => 'uptime',
            'delsign'       => 'delsign',
            'descr'         => 'descr',
            'order_id'      => 'order_id',
            'mem_id'        => 'mem_id',
            'content'       => 'content',
            'user_id'       => 'user_id',
            'shipping_type' => 'shipping_type'
        );
    }

    public function initialize()
    {
        $this->useDynamicUpdate( TRUE );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
    }

    /**
     * 获得跟踪信息
     * @param  int $orderId
     * @return type
     */
    public function getFeight( $orderId )
    {
        $sql = 'SELECT u.name,f.addtime,f.content,f.shipping_type FROM apps\admin\models\OrdersFeightTrack as f ' .
                ' LEFT JOIN apps\admin\models\PriUsers as u ON f.user_id=u.id WHERE f.order_id=:order_id: AND f.delsign=' . SystemEnums::DELSIGN_NO;

        $rst = $this->modelsManager->executeQuery( $sql, array( 'order_id' => $orderId ) );
        if( $rst )
        {
            return $rst->toArray();
        }
    }

}
