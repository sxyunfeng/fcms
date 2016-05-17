<?php

namespace apps\admin\models;

class Shops extends \Phalcon\Mvc\Model
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
    public $detail_addr;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var integer
     */
    public $class;

    /**
     *
     * @var integer
     */
    public $tpl_id;

    /**
     *
     * @var string
     */
    public $alipay;

    /**
     *
     * @var string
     */
    public $linkman;

    /**
     *
     * @var string
     */
    public $tel;

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
            'name' => 'name', 
            'province' => 'province', 
            'city' => 'city', 
            'district' => 'district', 
            'detail_addr' => 'detail_addr', 
            'status' => 'status', 
            'class' => 'class', 
            'tpl_id' => 'tpl_id', 
            'alipay' => 'alipay', 
            'linkman' => 'linkman', 
            'tel' => 'tel'
        );
    }

}
