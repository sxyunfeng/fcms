<?php

namespace apps\admin\models;

class PaymentPlugin extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $class_name;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var string
     */
    public $logo;

    /**
     *
     * @var tinyint
     */
    public $delsign;
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
            'class_name' => 'class_name', 
            'description' => 'description', 
            'logo' => 'logo',
            'delsign' => 'delsign'
        );
    }

}
