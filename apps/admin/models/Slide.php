<?php

namespace apps\admin\models;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

class Slide extends \Phalcon\Mvc\Model
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
    public $title;

    /**
     *
     * @var string
     */
    public $content;

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
    public $sort;

    /**
     *
     * @var integer
     */
    public $groupid;

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
     * @var string
     */
    public $dir;

    /**
     *
     * @var string
     */
    public $url;

    /**
     *
     * @var string
     */
    public $alt;

    /**
     *
     * @var integer
     */
    public $nofollow;

    /**
     *
     * @var integer
     */
    public $isshow;

    public function columnMap()
    {
        return array(
            'id'       => 'id',
            'addtime'  => 'addtime',
            'uptime'   => 'uptime',
            'title'    => 'title',
            'content'  => 'content',
            'delsign'  => 'delsign',
            'descr'    => 'descr',
            'sort'     => 'sort',
            'groupid'  => 'groupid',
            'width'    => 'width',
            'height'   => 'height',
            'dir'      => 'dir',
            'url'      => 'url',
            'alt'      => 'alt',
            'nofollow' => 'nofollow',
            'isshow'   => 'isshow',
        );
    }

    public function initialize()
    {
        $this->useDynamicUpdate( true );
        $this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );

        $this->belongsTo( 'groupid', '\apps\admin\models\SlideGroup', 'id', array( 'alias' => 'slidegroup' ) );
        $this->setSource( $this->di[ 'config' ][ 'database' ][ 'prefix' ] . $this->getSource() );
    }

}
