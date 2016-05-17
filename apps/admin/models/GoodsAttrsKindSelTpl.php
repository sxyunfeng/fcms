<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class GoodsAttrsKindSelTpl extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    public $attr_id;

    /**
     *
     * @var integer
     */
    public $kind_id;

    /**
     *
     * @var integer
     */
    public $indetail;

    /**
     *
     * @var integer
     */
    public $cat_id;

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id'       => 'id',
            'addtime'  => 'addtime',
            'delsign'  => 'delsign',
            'attr_id'  => 'attr_id',
            'kind_id'  => 'kind_id',
            'indetail' => 'indetail',
            'cat_id'   => 'cat_id'
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
    
     public function getKind( $attr_id )
    {
        $sql = 'select kind_id,indetail from \apps\admin\models\GoodsAttrsKindSelTpl where delsign=' . SystemEnums::DELSIGN_NO
                . ' and attr_id = :attr_id:';
        $rst = $this->modelsManager->executeQuery( $sql,
                        array( 'attr_id' => $attr_id ) )->getFirst();
        if( $rst )
        {
            return $rst->toArray();
        }
    }
    
       public function updatekind( $data )
    {
        $phql = 'update \apps\admin\models\GoodsAttrsKindSelTpl set kind_id=:kind_id:, indetail=:indetail: where attr_id=:attr_id:';
        $result = $this->modelsManager->executeQuery( $phql, $data );
        return $result->success();
    }

}
