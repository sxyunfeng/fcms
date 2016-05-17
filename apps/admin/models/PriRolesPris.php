<?php

namespace apps\admin\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

class PriRolesPris extends \Phalcon\Mvc\Model
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
    public $roleid;

    /**
     *
     * @var integer
     */
    public $priid;

    public function initialize()
    {
        $this->useDynamicUpdate( true );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
		
        $this->belongsTo( 'roleid', 'apps\admin\models\PriRoles', 'id', array( 'alias' => 'priRoles' ));
        $this->belongsTo( 'priid', 'apps\admin\models\PriPris', 'id', array( 'alias' => 'priPris' ));
    }
}
