<?php
namespace apps\admin\models; 
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\SystemEnums;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class PriGroups extends Model
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
     * @var int 
     */
    public $shopid;
    
    /**
     *
     * @var string
     */
    public $name;


    /**
     * Validations and business logic
     */
    public function validation()
    {

    }

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
            'uptime' => 'uptime', 
            'delsign' => 'delsign', 
            'descr' => 'descr', 
            'name' => 'name', 
            'shopid' => 'shopid'
        );
    }
   public function initialize()
    {
        $this->useDynamicUpdate( true );
        
	    $this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );

        $this->hasMany( 'id', 'apps\admin\models\PriGroupsRoles', 'groupid', array( 'alias' => 'priGroupsRoles' ));
    }
    public function getGroup()
    {
        $phql = 'select g.id as group_id, g.name as group_name, r.name as role_name from apps\admin\models\PriGroups as g ' .
                'inner join apps\admin\models\PriGroupsRoles as gr on g.id = gr.groupid inner join apps\admin\models\PriRoles as r on r.id = gr.roleid '.
                'where g.id !='. SystemEnums::SUPER_ADMIN_ID .' and g.delsign=' . SystemEnums::DELSIGN_NO;
        $result = $this->modelsManager->executeQuery( $phql );
        return $result;
    }
    
}
