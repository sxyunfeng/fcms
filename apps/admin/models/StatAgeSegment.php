<?php

namespace apps\admin\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use \Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

/**
 * 会员年龄段
 * @author Carey
 *
 */
class StatAgeSegment extends Model{
	
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
     * @var int
     */
    public $mem_num;
	
    /**
     * @var int
     */
    public $midlife;
    
    /**
     * @var int
     */
    public $youth;
    
    /**
     * @var int
     */
    public $pubertas;
    
    /**
     *
     * @var int
     */
    public $unit;
    
    /**
     * @var string
     */
    public $p_time;

    /**
     *
     * @var string
     */
    public $descr;
    
    
    public function initialize()
    {
    	$this->useDynamicUpdate( true );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
    }
    
    public function getSource()
    {
    	return 'stat_age_segment';
    }

	public function columnMap()
    {
        return array(
            'id'          => 'id',
            'addtime'     => 'addtime',
            'uptime'      => 'uptime',
            'delsign'     => 'delsign',
            'descr'       => 'descr',
            'mem_num'     => 'mem_num',
            'midlife'     => 'midlife',
            'youth'    	  => 'youth',
            'pubertas'    => 'pubertas',
            'unit' 		  => 'unit',
            'p_time'      => 'p_time',
        );
    }
	
}

?>