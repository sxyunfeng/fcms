<?php

namespace apps\admin\models;

class GoodsCatsKinds extends \Phalcon\Mvc\Model
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
    public $kind_sel_id;

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
            'kind_sel_id' => 'kind_sel_id'
        );
    }

    /**
     * 获得分类
     * @param type $cateId
     * @return type
     */
    public function getKind( $cateId )
    {
        $phql = 'select  d.id as group_id, d.title, k.id as sel_id, a.name from \apps\admin\models\GoodsCatsKinds as c ' . 
                'join \apps\admin\models\GoodsAttrsKindSelTpl as k on k.id = c.kind_sel_id ' .
                ' join \apps\admin\models\GoodsAttrsKindDic as d on d.id = k.kind_id ' .
                ' join \apps\admin\models\GoodsAttrsDic as a on a.id = k.attr_id '.
                 ' where c.cat_id = :cateId:';
        try{
            $kind = $this->getModelsManager()->executeQuery( $phql, array( 'cateId' => $cateId ) ); 
            $cateKind = array();
            foreach( $kind as $item )            //把group_id 一样的归类
            {
                $cateKind[ $item->group_id ][ 'title' ] = $item->title;
                $cateKind[ $item->group_id ][ 'attrs' ][] = array( 'id' => $item->sel_id, 'name' => $item->name );
            }
        } catch( \Exception $e ){
            echo $e->getMessage();
        }
        return $cateKind;
    }
}
