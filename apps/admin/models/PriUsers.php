<?php
namespace apps\admin\models; 

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model\Validator\Email as Email;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use apps\oa\enums\FlowEnums;
use enums\SystemEnums;

class PriUsers extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $nickname;

    /**
     *
     * @var string
     */
    public $loginname;

    /**
     *
     * @var string
     */
    public $birthdate;

    /**
     *
     * @var string
     */
    public $pwd;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var integer
     */
    public $shopid;

    /**
     *
     * @var integer
     */
    public $groupid;

    /**
     *
     * @var string
     */
    public $forget_code;

    /**
     *
     * @var integer
     */
    public $status;

    /**
    *
    * @var integer
    */
    public $dept_id;
    
    /**
     * Validations and business logic
     */
    public function validation()
    {

    }

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
            'nickname' => 'nickname', 
            'loginname' => 'loginname', 
            'birthdate' => 'birthdate', 
            'pwd' => 'pwd', 
            'email' => 'email', 
            'shopid' => 'shopid', 
            'groupid' => 'groupid', 
            'forget_code' => 'forget_code', 
            'status' => 'status',
            'dept_id' => 'dept_id'
        );
    }
   public function initialize()
    {
		$this->useDynamicUpdate( true );
		
        $this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
        //与oa关联
        $this->hasMany( 'id' , '\apps\oa\models\FlowRefer', 'userid', array( 'alias' => 'FlowRefer' ) );
        $this->hasMany( 'id', '\apps\oa\models\FlowContentType', 'userid', array( 'alias' => 'FlowContentType' ) );
    }
    
    /**
     * 添加新数据
     */
    public function beforeCreate()
    {
        $this->addtime = $this->uptime = date( 'Y-m-d H:i:s' );
    }
    /**
     * 更新数据
     */
    public function beforeUpdate()
    {
        $this->uptime = date( 'Y-m-d H:i:s' );
    }
    
    /**
     * 获取用户
     */
    public function findUsers()
    {
        return self::find( array(
            'delsign' => FlowEnums::DELSIGN_NO,
            'columns' => 'id, name, groupid'
        ))->toArray();
    }
    
}















