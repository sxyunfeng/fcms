<?php

namespace apps\admin\models;

class ShopCats extends \Phalcon\Mvc\Model
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
    public $cat_id;

    /**
     *
     * @var integer
     */
    public $shop_id;

    /**
     *
     * @var integer
     */
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
            'addtime' => 'addtime', 
            'delsign' => 'delsign', 
            'descr' => 'descr', 
            'cat_id' => 'cat_id', 
            'shop_id' => 'shop_id', 
            'status' => 'status'
        );
    }

}
