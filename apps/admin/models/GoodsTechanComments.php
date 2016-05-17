<?php

namespace apps\admin\models;

class GoodsTechanComments extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $descr;

    /**
     *
     * @var string
     */
    public $comment;

    /**
     *
     * @var integer
     */
    public $serv_marks;

    /**
     *
     * @var integer
     */
    public $goods_marks;

    /**
     *
     * @var integer
     */
    public $mem_id;

    /**
     *
     * @var integer
     */
    public $goods_id;
     /**
     *
     * @var tinytext
     */
    public $reply_content; 
    /**
     *
     * @var datetime
     */
    public $reply_time;
     /**
     *
     * @var tinyint
     */
    public $is_reply;
    /**
     *
     * @var tinyint
     */
    public $is_display;
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
            'delsign' => 'delsign', 
            'descr' => 'descr', 
            'comment' => 'comment', 
            'serv_marks' => 'serv_marks', 
            'goods_marks' => 'goods_marks', 
            'mem_id' => 'mem_id', 
            'goods_id' => 'goods_id',
            'reply_content' => 'reply_content',
            'reply_time' => 'reply_time',
            'is_reply' => 'is_reply',
            'is_display' => 'is_display'
        );
    }

}
