<?php

namespace apps\admin\models;

class GoodsCatsAttrs extends \Phalcon\Mvc\Model
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
     * 获得分类的属性
     * @param id $cateId
     * @return array
     */
    function getAttrs( $cateId )
    {
        $phql = 'select a.id, a.name from \apps\admin\models\GoodsCatsAttrs as c join \apps\admin\models\GoodsAttrsDic as a on c.attr_id = a.id '.
            ' where c.cat_id = :cateId:';
        $attrs = $this->getModelsManager()->executeQuery( $phql, array( 'cateId' => $cateId ) );
        return $attrs->toArray();
    }
}
