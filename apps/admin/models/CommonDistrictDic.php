<?php

namespace apps\admin\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class CommonDistrictDic extends \Phalcon\Mvc\Model
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
    public $name;

    /**
     *
     * @var integer
     */
    public $level;

    /**
     *
     * @var integer
     */
    public $usetype;

    /**
     *
     * @var integer
     */
    public $upid;

    /**
     *
     * @var integer
     */
    public $displayorder;

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
            'name' => 'name', 
            'level' => 'level', 
            'usetype' => 'usetype', 
            'upid' => 'upid', 
            'displayorder' => 'displayorder'
        );
    }

}
