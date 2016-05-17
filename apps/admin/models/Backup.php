<?php

namespace apps\admin\models;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

class Backup extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $name;
    
    /**
     *
     * @var integer
     */
    public $type;
    
    /**
     *
     * @var string
     */
    public $creator;

    /**
     *
     * @var string
     */
    public $size;

    /**
     *
     * @var integer
     */
    public $delsign;
    
    /**
     *
     * @var integer
     */
    public $method;
    

    public function columnMap()
    {
        return array(
            'id'      => 'id',
            'addtime' => 'addtime',
            'uptime'  => 'uptime',
            'name'    => 'name',
            'type'    => 'type',
            'creator' => 'creator',
            'size'    => 'size',
            'delsign' => 'delsign',
            'method'  => 'method'
        );
    }

    public function initialize()
    {
        $this->useDynamicUpdate( true );
        $this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );

        $this->setSource( $this->di[ 'config' ][ 'database' ][ 'prefix' ] . $this->getSource() );
    }

}
