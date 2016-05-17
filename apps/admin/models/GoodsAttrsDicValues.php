<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class GoodsAttrsDicValues extends \Phalcon\Mvc\Model
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
    public $attr_id;

    /**
     *
     * @var string
     */
    public $value;

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
            'uptime'  => 'uptime',
            'delsign' => 'delsign',
            'descr'   => 'descr',
            'attr_id' => 'attr_id',
            'value'   => 'value'
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

    function getGoodsAttrVal( $attr_id )
    {
        $sql = 'select id,value from \apps\admin\models\GoodsAttrsDicValues where delsign =' . SystemEnums::DELSIGN_NO
                . ' and attr_id = :attr_id:';
        $rst = $this->modelsManager->executeQuery( $sql,
                array( 'attr_id' => $attr_id ) );
        if( $rst )
        {
            return $rst->toArray();
        }
    }

    function delGoodsAttr( $attr_id )
    {
        $sql = 'update \apps\admin\models\GoodsAttrsDicValues set delsign = 1 where'
                . '  attr_id = :attr_id:';
        $rst = $this->modelsManager->executeQuery( $sql,
                array( 'attr_id' => $attr_id ) );
        if( $rst )
        {
            return $rst;
        }
    }

}
