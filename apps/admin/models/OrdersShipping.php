<?php

namespace apps\admin\models;

class OrdersShipping extends \Phalcon\Mvc\Model
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
    public $name;

    /**
     *
     * @var double
     */
    public $fee;

    /**
     *
     * @var string
     */
    public $insure;

    /**
     *
     * @var integer
     */
    public $sort;

}
