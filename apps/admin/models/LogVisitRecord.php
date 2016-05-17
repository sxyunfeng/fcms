<?php

namespace apps\admin\models;

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use enums\SystemEnums;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

/**
 * @author  zlw
 * @date	2015.9.6
 * @desc	前台用户访问记录表
 */
class LogVisitRecord extends \Phalcon\Mvc\Model
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $memid;
    
    /**
     * @var varchar
     */
    public $ip;
    
    /**
     * @var varchar
     */
    public $addtime;
    
    /**
     * @var varchar
     */
    public $agent;
    
    /**
     * @var int
     */
	public $itemid;

	/**
	 * @var varchar
	 */
	public $url;
	
	/**
	 * @var refer
	 */
	public $refer;
	
	/**
	 * @var int
	 */
	public $biztype;
	
    
    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap() 
    {
        return array(
            'id'                => 	'id',
            'memid'            	=> 	'memid',
            'ip'          		=> 	'ip',
        	'addtime'			=>	'addtime',
        	'agent'				=>	'agent',
        	'itemid'			=>	'itemid',
            'url'           	=> 	'url',
        	'refer'				=> 	'refer',
        	'biztype'			=>  'biztype',
        );
    }

    public function initialize()
    {
        $this->useDynamicUpdate( true );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
		
        $this->belongsTo( 'memid', '\models\MemMembers', 'id' , array( 'alias' => 'members' ) );
        
        $this->setSource( 'log_visit_record' );
    }
    
    /**
     * @author( author='zlw' )
     * @date( date = '2015-9-6' )
     * @comment( comment = '保存前台用户访问记录' )	
     * @method( method = 'saveLogInfo' )
     * @op( op = 'c' )		
    */
    public function saveLogInfo( $logInfo )
    {
    	if( !$logInfo )
    	{
    		return false;
    	}
    	
    	$url = str_replace( '\\', '/', $logInfo['url'] );
    	
    	$log = new LogVisitRecord;
    	$log->memid = $logInfo['memId'];
    	$log->ip = $logInfo['ip'];
    	$log->addtime = date( 'Y-m-d H:i:s', $logInfo['addTime'] );
    	$log->agent = $logInfo['agent'];
    	$log->itemid = $logInfo['goodId'];
    	$log->biztype = $logInfo[ 'biztype' ];
    	$log->url = $url;
    	$log->refer = 'http://www.huaer.dev/' ? 'http://www.huaer.dev/home/index/index' : $logInfo['refer'];
    	
    	return $log->save();
    }
}










