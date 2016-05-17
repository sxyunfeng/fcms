<?php

namespace apps\cms\models;

use enums\SystemEnums;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

/**
 * 广告分类模型
 * @author Carey
 *
 */
class AdCats extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $name;

    /**
     *
     * @var integer
     */
    public $pid;

    /**
     *
     * @var string
     */
    public $descr;

    /**
     *
     * @var integer
     */
    public $width;

    /**
     *
     * @var integer
     */
    public $height;

    /**
     *
     * @var integer
     */
    public $delsign;

    /**
     *
     * @var double
     */
    public $base_price;

    /**
     *
     * @var double
     */
    public $click_price;

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id'          => 'id',
            'addtime'     => 'addtime',
            'uptime'      => 'uptime',
            'name'        => 'name',
            'pid'         => 'pid',
            'descr'       => 'descr',
            'width'       => 'width',
            'height'      => 'height',
            'delsign'     => 'delsign',
            'base_price'  => 'base_price',
            'click_price' => 'click_price'
        );
    }

    public function initialize()
    {
        $this->useDynamicUpdate( TRUE );
        $this->setSource( 'xuxu_ad_cats' );
    }

    /**
     * 更新
     */
    public function updateCats( $data )
    {
        $phql = 'update \apps\admin\models\AdCats set name=:name:, pid=:pid:, uptime=:uptime:, width=:width:, height=:height: where id=:id:';
        $result = $this->_modelsManager->executeQuery( $phql, $data );
        return $result->success();
    }

    /**
     * 删除
     */
    public function deleteCats( $data )
    {
        $phql = 'update \apps\admin\models\AdCats set  delsign=' . SystemEnums::DELSIGN_YES . ', uptime=:uptime: where id=:id:';
        $result = $this->_modelsManager->executeQuery( $phql, $data );
        return $result->success();
    }

}
