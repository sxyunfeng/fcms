<?php

namespace apps\admin\models;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\oa\enums\FlowEnums;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

class PriRoles extends \Phalcon\Mvc\Model
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
    public $shopid;

    /**
     *
     * @var string
     */
    public $name;

         /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */

    public function initialize()
    {
        $this->useDynamicUpdate( true );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
		
        $this->hasMany( 'id', 'apps\admin\models\PriGroupsRoles', 'roleid', array( 'alias' => 'priGroupsRoles' ));
        $this->hasMany( 'id', 'apps\admin\models\PriRolesPris', 'roleid', array( 'alias' => 'priRolesPris' ));
        //与oa关联
        $this->hasMany( 'id' , '\apps\oa\models\FlowRefer', 'userid', array( 'alias' => 'FlowRefer' ) );
    }
    
    /**
     * 获取角色
     */
    public function findRoles()
    {
        return self::find( array(
            'delsign' => FlowEnums::DELSIGN_NO,
            'columns' => 'id, name'
        ))->toArray();
    }
            
}














