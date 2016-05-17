<?php
namespace apps\admin\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

class PriPris extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    public $pid;

    /**
     *
     * @var integer
     */
    public $display;

    /**
     *
     * @var string
     */
    public $src;
    
     /**
     *
     * @var int
     */
    public $sort;
    
     /**
     *
     * @var varchar
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
            'id' => 'id', 
            'addtime' => 'addtime', 
            'uptime' => 'uptime', 
            'delsign' => 'delsign', 
            'descr' => 'descr', 
            'name' => 'name', 
            'pid' => 'pid', 
            'display' => 'display', 
            'src' => 'src',
            'sort' => 'sort',
            'module' => 'module'
        );
    }
    public function initialize()
    {
        $this->useDynamicUpdate( true );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
		
        $this->hasMany( 'id', 'apps\admin\models\PriRolesPris', 'priid', array( 'alias' => 'priRolesPris' ));
    }
}
