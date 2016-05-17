<?php

namespace apps\admin\models;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

class SlideGroup extends \Phalcon\Mvc\Model
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
    public $type;

    /**
     *
     * @var integer
     */
    public $width;

    /**
     *
     * @var integer
     */
    public $height;

    /**
     *
     * @var integer
     */
    public $size;

    /**
     *
     * @var int
     */
    public $islimit;

    public function columnMap()
    {
        return array(
            'id'      => 'id',
            'addtime' => 'addtime',
            'uptime'  => 'uptime',
            'delsign' => 'delsign',
            'descr'   => 'descr',
            'name'    => 'name',
            'type'    => 'type',
            'size'    => 'size',
            'width'   => 'width',
            'height'  => 'height',
            'islimit' => 'islimit',
        );
    }

    public function initialize()
    {
        $this->useDynamicUpdate( true );
        $this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );

        $this->hasMany( 'id', '\apps\admin\models\Slide', 'groupid', array( 'alias' => 'slide' ) );
        $this->setSource( $this->di[ 'config' ][ 'database' ][ 'prefix' ] . $this->getSource() );
    }

}
