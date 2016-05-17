<?php

namespace apps\admin\models;

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

class GoodsTechanPics extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $url;

    /**
     *
     * @var string
     */
    public $realname;

    /**
     *
     * @var integer
     */
    public $length;

    /**
     *
     * @var string
     */
    public $thumb_url;

    /**
     *
     * @var string
     */
    public $save_name;

    /**
     *
     * @var integer
     */
    public $goods_id;

    /**
     *
     * @var integer
     */
    public $sort;

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
            'url' => 'url', 
            'realname' => 'realname', 
            'length' => 'length', 
            'thumb_url' => 'thumb_url', 
            'save_name' => 'save_name', 
            'goods_id' => 'goods_id', 
            'sort' => 'sort'
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
}
