<?php

namespace apps\cms\models;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

/**
 * 广告表模型
 * @author Carey
 *
 */
class Ad extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $media_type;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $url;

    /**
     *
     * @var integer
     */
    public $begin_time;

    /**
     *
     * @var integer
     */
    public $end_time;

    /**
     *
     * @var integer
     */
    public $click_count;

    /**
     *
     * @var integer
     */
    public $enabled;

    /**
     *
     * @var integer
     */
    public $cat_id;

    /**
     *
     * @var integer
     */
    public $sort_order;

    /**
     *
     * @var string
     */
    public $title;

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
     * @var integer
     */
    public $click_left;

    /**
     *
     * @var integer
     */
    public $weight;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $descr;

    /**
     *
     * @var string
     */
    public $addtime;

    /**
     *
     * @var string
     */
    public $src;

    /**
     *
     * @var integer
     */
    public $shopid;

    /**
     *
     * @var integer
     */
    public $nofollow;

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id'          => 'id',
            'media_type'  => 'media_type',
            'name'        => 'name',
            'url'         => 'url',
            'begin_time'  => 'begin_time',
            'end_time'    => 'end_time',
            'click_count' => 'click_count',
            'enabled'     => 'enabled',
            'cat_id'      => 'cat_id',
            'sort_order'  => 'sort_order',
            'title'       => 'title',
            'uptime'      => 'uptime',
            'delsign'     => 'delsign',
            'click_left'  => 'click_left',
            'weight'      => 'weight',
            'cid'     	  => 'cid',
            'descr'       => 'descr',
            'addtime'     => 'addtime',
            'src'     	  => 'src',
            'shopid'      => 'shopid',
            'nofollow'    => 'nofollow'
        );
    }

    public function initialize()
    {
        $this->useDynamicUpdate( TRUE );
        $this->belongsTo( 'cat_id' , 'apps\admin\models\AdCats' , 'id' , array( 'alias' => 'adcates' ) );
        
        $this->setSource( 'xuxu_ad' );
    }

}
