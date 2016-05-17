<?php

namespace apps\cms\models;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\SystemEnums;
use Phalcon\Mvc\Model;
/**
 * 文章分类模型
 * @author Carey
 *
 */
class ArticleCats extends Model
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
    public $title;

    /**
     *
     * @var string
     */
    public $keywords;

    /**
     *
     * @var integer
     */
    public $type;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var integer
     */
    public $nofollow;

    /**
     *
     * @var string
     */
    public $img;

    /**
     *
     * @var integer
     */
    public $parent_id;

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id'          => 'id',
            'addtime'     => 'addtime',
            'uptime'      => 'uptime',
            'delsign'     => 'delsign',
            'descr'        => 'descr',
            'name'        => 'name',
            'title'       => 'title',
            'keywords'    => 'keywords',
            'type'        => 'type',
            'description' => 'description',
            'nofollow'    => 'nofollow',
            'img'         => 'img',
            'parent_id'   => 'parent_id'
        );
    }

    public function initialize()
    {
        $this->useDynamicUpdate( TRUE );
        
        $this->hasMany( 'id' , '\apps\cms\models\Articles', 'cat_id' , array( 'alias' => 'articlelist' ) );
        $this->setSource( 'xuxu_article_cats' );
    }
    
    /**
     * 更新
     */
    public function updateCats( $data )
    {
        $phql = 'update \apps\admin\models\ArticleCats set name=:name:, parent_id=:parent_id:, uptime=:uptime: where id=:id:' ;
        $result = $this->_modelsManager->executeQuery($phql, $data );
        return $result->success();
    }
    
    /**
     * 删除
     */
    public function deleteCats( $data )
    {
        $phql = 'update \apps\admin\models\ArticleCats set  delsign=' .SystemEnums::DELSIGN_YES . ', uptime=:uptime: where id=:id:' ;
        $result = $this->_modelsManager->executeQuery($phql, $data );
        return $result->success();
    }

}
