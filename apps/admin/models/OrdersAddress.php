<?php

namespace apps\admin\models;

class OrdersAddress extends \Phalcon\Mvc\Model
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
    public $mem_id;

    /**
     *
     * @var integer
     */
    public $province;

    /**
     *
     * @var integer
     */
    public $city;

    /**
     *
     * @var integer
     */
    public $district;

    /**
     *
     * @var string
     */
    public $detail;

    /**
     *
     * @var integer
     */
    public $tel;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var integer
     */
    public $status;
    
    /**
     *
     * @var integer
     */
    public $zipcode;

}
