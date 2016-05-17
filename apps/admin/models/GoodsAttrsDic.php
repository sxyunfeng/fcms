<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class GoodsAttrsDic extends \Phalcon\Mvc\Model
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
    public $name;

    /**
     *
     * @var integer
     */
    public $itype;

    /**
     *
     * @var integer
     */
    public $ftype;

    /**
     *
     * @var integer
     */
    public $length;

    /**
     *
     * @var string
     */
    public $unit;

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id'      => 'id',
            'addtime' => 'addtime',
            'delsign' => 'delsign',
            'descr'   => 'descr',
            'name'    => 'name',
            'itype'   => 'itype',
            'ftype'   => 'ftype',
            'length'  => 'length',
            'unit'    => 'unit'
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
     * 更新
     */
    public function updateGoodsAttr( $data )
    {
        $phql = 'update \apps\admin\models\GoodsAttrsDic set name=:name:, length=:length:, unit=:unit:, itype=:itype: where id=:id:';
        $result = $this->modelsManager->executeQuery( $phql, $data );
        return $result->success();
    }

    /**
     * 删除
     */
    public function deleteGoodsAttr( $data )
    {
        $phql = 'update \apps\admin\models\GoodsAttrsDic set  delsign=' . SystemEnums::DELSIGN_YES . ' where id=:id:';
        $result = $this->modelsManager->executeQuery( $phql, $data );
        return $result->success();
    }

}
