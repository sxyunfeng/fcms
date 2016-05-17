<?php

namespace apps\admin\models;

class GoodsCatsSpecs extends \Phalcon\Mvc\Model
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
    public $cat_id;

    /**
     *
     * @var integer
     */
    public $attr_id;

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
            'cat_id' => 'cat_id', 
            'attr_id' => 'attr_id'
        );
    }

    /**
     * 获得分类的规格
     * @param id $cateId
     * @return array
     */
    function getSpecials( $cateId )
    {
        $phql = 'select a.id, a.name from \apps\admin\models\GoodsCatsSpecs as c join \apps\admin\models\GoodsAttrsDic as a on c.attr_id = a.id '.
            'where c.cat_id = :cateId:';
        $specs = $this->getModelsManager()->executeQuery( $phql, array( 'cateId' => $cateId ) );
        return $specs->toArray();
    }
}
