<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class OrdersReturnsFlow extends \Phalcon\Mvc\Model
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
    public $return_id;

    /**
     *
     * @var string
     */
    public $content;

    /**
     *
     * @var string
     */
    public $user_id;

    /**
     *
     * @var integer
     */
    public $node_id;

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
            'id'       => 'id',
            'addtime'  => 'addtime',
            'uptime'   => 'uptime',
            'delsign'  => 'delsign',
            'descr'    => 'descr',
             'mem_id' => 'mem_id',
            'return_id' => 'return_id',
            'content'  => 'content',
            'user_id'  => 'user_id',
            'node_id'  => 'node_id',
            'value'    => 'value',
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
     * 获得跟踪信息
     * @param  int $returnId
     * @return type
     */
    public function getLog( $returnId )
    {
        $sql = 'SELECT u.name,f.addtime,f.content FROM apps\admin\models\OrdersReturnsFlow as f ' .
                ' LEFT JOIN apps\admin\models\PriUsers as u ON f.user_id=u.id WHERE f.return_id=:return_id: AND f.delsign=' . SystemEnums::DELSIGN_NO;
        $rst = $this->modelsManager->executeQuery( $sql, array( 'return_id' =>  $returnId ) );
        if( $rst )
        {
            return $rst->toArray();
        }
    }
}
