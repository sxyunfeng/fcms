<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class GoodsAttrsKindDic extends \Phalcon\Mvc\Model
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
    public $title;

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
            'id'      => 'id',
            'addtime' => 'addtime',
            'uptime'  => 'uptime',
            'delsign' => 'delsign',
            'descr'   => 'descr',
            'title'   => 'title',
            'cat_id'  => 'cat_id'
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

    public function getKinds()
    {
        $sql = 'select id,title from \apps\admin\models\GoodsAttrsKindDic where delsign=' . SystemEnums::DELSIGN_NO;
        $rst = $this->modelsManager->executeQuery( $sql );
        if( $rst )
        {
            return $rst->toArray();
        }
    }

   

    /**
     * 更新
     */
    public function updateCatsAttr( $data )
    {
        $phql = 'update \apps\admin\models\GoodsAttrsKindDic set title=:title:, uptime=:uptime: where id=:id:';
        $result = $this->modelsManager->executeQuery( $phql, $data );
        return $result->success();
    }

    /**
     * 删除
     */
    public function deleteCatsAttr( $data )
    {
        $phql = 'update \apps\admin\models\GoodsAttrsKindDic set  delsign=' . SystemEnums::DELSIGN_YES . ' ,uptime=:uptime:  where id=:id:';
        $result = $this->modelsManager->executeQuery( $phql, $data );
        return $result->success();
    }

}
