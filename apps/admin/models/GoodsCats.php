<?php

namespace apps\admin\models;

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

class GoodsCats extends \Phalcon\Mvc\Model
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
      * @var int
      */
    public $pid;
    
    /**
     * @string
     */
    public $img;
    
    /**
     * @var int
     */
    public $sort;
    
    public function initialize()
    {
		$this->useDynamicUpdate( TRUE );
		
        $this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
    }
            
}
