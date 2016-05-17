<?php

namespace apps\admin\models;

use enums\SystemEnums;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class MemMembers extends Model
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
    public $create_time;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $login_name;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var integer
     */
    public $gender;

    /**
     *
     * @var string
     */
    public $birthdate;

    /**
     *
     * @var double
     */
    public $money_left;

    /**
     *
     * @var integer
     */
    public $accu_points;

    /**
     *
     * @var integer
     */
    public $rest_points;

    /**
     *
     * @var integer
     */
    public $rank;

    /**
     *
     * @var integer
     */
    public $visit_count;

    /**
     *
     * @var string
     */
    public $salt;

    /**
     *
     * @var integer
     */
    public $parent_id;

    /**
     *
     * @var string
     */
    public $qq;

    /**
     *
     * @var string
     */
    public $office_phone;

    /**
     *
     * @var string
     */
    public $home_phone;

    /**
     *
     * @var string
     */
    public $mobile_phone;

    /**
     *
     * @var string
     */
    public $passwd_question;

    /**
     *
     * @var string
     */
    public $passwd_answer;

    /**
     *
     * @var string
     */
    public $user_icon;

    /**
     *
     * @var integer
     */
    public $active;

    /**
     *
     * @var string
     */
    public $activation_key;

    /**
     *
     * @var string
     */
    public $ucode;

    /**
     *
     * @var string
     */
    public $nickname;

    /**
     *
     * @var integer
     */
    public $province;

    /**
     *
     * @var integer
     */
    public $city;

    /**
     *
     * @var integer
     */
    public $district;

    /**
     *
     * @var string
     */
    public $addr;

    /**
     *
     * @var integer
     */
    public $bind_email;

    /**
     *
     * @var integer
     */
    public $bind_mobile;

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
    public $delsign;

    /**
     *
     * @var integer
     */
    public $height;

    /**
     *
     * @var integer
     */
    public $weight;

    /**
     *
     * @var integer
     */
    public $waistline;

    /**
     *
     * @var integer
     */
    public $chest;

    /**
     *
     * @var integer
     */
    public $hipline;

    /**
     *
     * @var integer
     */
    public $legline;

    /**
     *
     * @var integer
     */
    public $shoesize;

    /**
     *
     * @var integer
     */
    public $marital_status;

    /**
     *
     * @var string
     */
    public $alipay;
    public $head_img;
    /**
     * Validations and business logic
     */
    public function validation()
    {

    }
    
    public function initialize()
    {
        $this->useDynamicUpdate( true );
		
		$this->addBehavior( new SoftDelete( array(
            'field' => 'delsign',
            'value' => SystemEnums::DELSIGN_YES,
        ) ) );
    }
    
    /**
     * 获得会员(买了该商家的商品就是该商家的会员了)
     */
    public function getMemeber( $shop )
    {
        $phql = 'select m.id,m.login_name,m.username,m.email,m.rest_points,m.status from apps\admin\models\MemMembers as m '.
                ' join apps\admin\models\OrdersSub as c on c.mem_id = m.id  ' .
                ' where c.shop_id =  ' . $shop  . ' and m.delsign = ' .SystemEnums::DELSIGN_NO . ' group by m.id';
     
        $list = $this->modelsManager->executeQuery( $phql );
        return $list;
    }
}
