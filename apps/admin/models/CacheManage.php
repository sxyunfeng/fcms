<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class CacheManage extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $ename;

    /**
     *
     * @var string
     */
    public $ename_rule;

    /**
     *
     * @var integer
     */
    public $cache_time;

    /**
     *
     * @var integer
     */
    public $type;

    /**
     *
     * @var integer
     */
    public $is_warm_up;

    /**
     *
     * @var integer
     */
    public $module;

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id'         => 'id',
            'addtime'    => 'addtime',
            'uptime'     => 'uptime',
            'delsign'    => 'delsign',
            'descr'      => 'descr',
            'name'       => 'name',
            'ename'      => 'ename',
            'ename_rule' => 'ename_rule',
            'cache_time' => 'cache_time',
            'type'       => 'type',
            'is_warm_up' => 'is_warm_up',
            'module'     => 'module'
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
    public function updateCache( $data )
    {
        $phql = 'update \apps\admin\models\CacheManage set name=:name:, ename=:ename:, ename_rule=:ename_rule:, cache_time=:cache_time:, '
                . 'type=:type:, is_warm_up=:is_warm_up:, module=:module:, uptime=:uptime: where id=:id:';
        $result = $this->_modelsManager->executeQuery( $phql, $data );
        return $result->success();
    }

    /**
     * 删除
     */
    public function deleteCache( $data )
    {
        $phql = 'update \apps\admin\models\CacheManage set  delsign=' . SystemEnums::DELSIGN_YES . ', uptime=:uptime: where id=:id:';
        $result = $this->_modelsManager->executeQuery( $phql, $data );
        return $result->success();
    }

    public function searchCache( $name = '', $module = '' )
    {
        if( !empty( $name ) )
        {
            $nameSql = 'AND  name like :name:';
        }
        else
        {
            $nameSql = ' ';
        }

        if( !empty( $module ) )
        {
            switch( $module )
            {
                case 4:
                    $moduleSql = 'AND  module = 0 ';
                    break;
                case 1:
                    $moduleSql = 'AND  module = 1 ';
                    break;
                case 2:
                    $moduleSql = 'AND  module = 2 ';
                    break;
                case 3:
                    $moduleSql = 'AND  module = 3 ';
                    break;
                default :
                    $moduleSql = '';
            }
        }
        else
        {
            $moduleSql = '';
        }

        $phql = 'select * from apps\admin\models\CacheManage where '
                . 'delsign = ' . SystemEnums::DELSIGN_NO . $nameSql . $moduleSql . ' order by id desc';

        $rst = $this->modelsManager->executeQuery( $phql,
                array( 'name' => '%' . $name . '%') );

        if( $rst )
        {
            return $rst->toArray();
        }
    }

}
