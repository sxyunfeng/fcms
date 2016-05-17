<?php

/**
 * 商品分类
 * @author hfc
 * time 2015-7-11
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\GoodsAttrsDic;
use apps\admin\models\GoodsAttrsKindDic;
use apps\admin\models\GoodsCats;
use apps\admin\models\GoodsCatsAttrs;
use apps\admin\models\GoodsCatsKinds;
use apps\admin\models\GoodsCatsSpecs;
use enums\SystemEnums;

class CategorysController extends AdminBaseController {
    
    private $categorys = array(); 
    
    public function initialze()
    {
        parent::initialize();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '分类首页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction( )
    {
        $this->view->categorys = $this->_getCategoryTree();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '添加分类' )	
     * @method( method = 'addAction' )
     * @op( op = '' )		
    */
    public function  addAction()
    {
       $this->view->categorys = $this->_getCategoryTree();
       $this->getAllAttr();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-9-26' )
     * @comment( comment = '获得属性' )	
     * @method( method = 'getAllAttr' )
     * @op( op = '' )		
    */
    private function getAllAttr(){
        //所有属性
        $dic = GoodsAttrsDic::find( array( 'delsign' => SystemEnums::DELSIGN_NO, 'columns' => 'id,name' ))->toArray();
        if( $dic )
        {
            $this->view->attrDic = $dic;
        }
        //所有属性分类
        $kind = GoodsAttrsKindDic::find( array( 'delsign' => SystemEnums::DELSIGN_NO, 'columns' => 'id,title'))->toArray();
        foreach( $kind as $key=>$item )
        {
            $phql = 'select d.id,d.name from \apps\admin\models\GoodsAttrsKindSelTpl as k '
                    . 'join \apps\admin\models\GoodsAttrsDic as d on d.id = k.attr_id where k.kind_id =' . $item[ 'id' ];
            $attr  = $this->modelsManager->executeQuery( $phql );
            if( $attr && ! $attr->toArray() )
            {
                unset( $kind[ $key ] );
                continue;
            }
            $kind[ $key ][ 'attr' ] = $attr->toArray();
        }
        $this->view->attrKind = $kind;
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '编辑分类' )	
     * @method( method = 'editAction' )
     * @op( op = '' )		
    */
    public function  editAction()
    {
        $cateId = $this->request->getQuery( 'id', 'int' );
        $goodsCats =  GoodsCats::findFirst( array( 'id=?0', 'columns'=> 'id, pid, name', 'bind' => array( $cateId), 'columns'=> 'id, pid, name' ));
        
        if( $goodsCats )
        {
            $this->view->category = $goodsCats->toArray();
        }
        $this->view->allCats = $this->_getCategoryTree(); //所有分类
        $this->getAllAttr();
        //获得分类的规格和属性
        $attrModel = new GoodsCatsAttrs();
        $this->view->attrs = $attrModel->getAttrs( $cateId );
        $specModel = new GoodsCatsSpecs();
        $this->view->specials = $specModel->getSpecials( $cateId );
        $kindModel = new GoodsCatsKinds();
        $this->view->kinds = $kindModel->getKind( $cateId );
    }
    
    /**
    * @author( author='hfc' )
    * @date( date = '2015-9-24' )
    * @comment( comment = '搜索属性' )	
    * @method( method = 'searchAttrAction' )
    * @op( op = '' )		
    */
    public function searchAttrAction()
    {
        $attr = $this->request->getQuery( 'attr', 'string' );
        $dic = GoodsAttrsDic::find( array( 'name like ?0 and delsign=' . SystemEnums::DELSIGN_NO , 'bind' => array(  $attr . '%' ), 'columns' => 'id,name' )  )->toArray();
        if( $dic  )
        {
            $this->success( '成功', array( 'data' => $dic ) );
        
        }
        $this->error( '失败' );
    }
    
        /**
    * @author( author='hfc' )
    * @date( date = '2015-9-24' )
    * @comment( comment = '搜索属性分类' )	
    * @method( method = 'searchKindAction' )
    * @op( op = '' )		
    */
    public function searchKindAction()
    {
        $attr = $this->request->getQuery( 'attr', 'string' );
        $kind = GoodsAttrsKindDic::find( array( 'title like ?0 and delsign=' . SystemEnums::DELSIGN_NO , 'bind' => array(  $attr . '%' ), 'columns' => 'id,title' )  )->toArray();
        if( $kind  )
        {
            foreach( $kind as $key=>$item )
            {
                $phql = 'select k.id,d.name from \apps\admin\models\GoodsAttrsKindSelTpl as k '
                        . 'join \apps\admin\models\GoodsAttrsDic as d on d.id = k.attr_id where k.kind_id =' . $item[ 'id' ];
                $attr  = $this->modelsManager->executeQuery( $phql );
                if( $attr && ! $attr->toArray() )
                {
                    unset( $kind[ $key ] );
                    continue;
                }
                $kind[ $key ][ 'attr' ] = $attr->toArray();
            }
            $this->success( '成功', array( 'data' => $kind ) );
        
        }
        $this->error( '失败' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '添加一个新分类' )	
     * @method( method = 'insertAction' )
     * @op( op = 'c' )		
    */
    public function insertAction()
    {
        $this->csrfCheck();
        
        $data[ 'name' ] = $this->request->getPost( 'cateName', 'string' );
        $data[ 'pid' ] = $this->request->getPost( 'parentId', 'int' );
        $data[ 'addtime' ] = $data[ 'uptime' ] = date(  'Y-m-d H:i:s' );
        $data[ 'delsign' ] = 0;

        //判断一下是否重命名
        $isExist = GoodsCats::findFirst( array( 'name=?0', 'bind' => array($data[ 'name' ])));
        if( $isExist )
        {
            $this->error( '分类已经存在' );
        }
        
        $goodsCats = new GoodsCats();
        if( $goodsCats->save( $data ) )
        {
            $this->updateCates( $goodsCats->id, false );
            $this->success( '保存成功' );
        }
        else
        {
            $this->error( '保存失败' );
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '更新分类' )	
     * @method( method = 'updateAction' )
     * @op( op = 'u' )		
    */
    public function updateAction()
    {
        $id = $this->request->getPost( 'id', 'int' );
        $data[ 'name' ] = $this->request->getPost( 'cateName', 'string' );
        $data[ 'pid' ] = $this->request->getPost( 'parentId', 'int' );
        $data[ 'uptime' ] = date( 'Y-m-d H:i:s' ); 
        
        $this->updateCates( $id );
        
        //判断一下是否重命名
        $isExist = GoodsCats::findFirst( array( 'id !=?0 and name=?1', 'bind' => array( $id, $data[ 'name' ])));
        if( $isExist )
        {
            $this->error( '分类已经存在' );
        }
        $goodsCats = GoodsCats::findFirst( array( 'id=?0', 'bind' => array( $id )) );
        $status = $goodsCats->update( $data );
        
        if( $status )
        {
            $this->success( '更新成功' );
        }
        else
        {
            $this->error( '更新失败' );
        }
    }
    
     /**
     * @author( author='hfc' )
     * @date( date = '2015-9-28' )
     * @comment( comment = '更新分类属性' )	
     * @method( method = 'updateCates' )
     * @op( op = '' )		
    */
    private function updateCates( $id, $isDelete = true ) 
    {
        if( $isDelete )
        {
            $gspec =    GoodsCatsSpecs::find( array( 'cat_id=?0', 'bind' => array( $id ) ));
            foreach( $gspec as $item )  
            {
                $item->delete();
            }

            $gattrs =    GoodsCatsAttrs::find( array( 'cat_id=?0', 'bind' => array( $id ) ));
            foreach( $gattrs as $item )  
            {
                $item->delete();
            }
            $gksels =    GoodsCatsKinds::find( array( 'cat_id=?0', 'bind' => array( $id ) ));
            foreach( $gksels as $item )  
            {
                $item->delete();
            }
        }
         //分类规格
        $specs = $this->request->getPost( 'specs' );
        if( $specs )
        {
            foreach( $specs as $item )
            {
                $m = new GoodsCatsSpecs();
                $m->cat_id = $id;
                $m->attr_id = $item;
                if( ! $m->save() )
                {
                    $this->error( '添加分类规格失败' );
                }
            }
        }
        //分类属性
        $attrs = $this->request->getPost( 'attrs' );
        if( $attrs )
        {
            foreach( $attrs as $item )
            {
                $m = new GoodsCatsAttrs();
                $m->cat_id = $id;
                $m->attr_id = $item;
                if( ! $m->save() )
                {
                    $this->error( '添加分类属性失败' );
                }
            }
        }
        //分类种类参数
        $ksels = $this->request->getPost( 'ksels' );
        if( $ksels )
        {
            foreach( $ksels as $item )
            {
                $m = new GoodsCatsKinds();
                $m->cat_id = $id;
                $m->kind_sel_id = $item;
                if( ! $m->save() )
                {
                    $this->error( '添加分类属性失败' );
                }
            }
        }
    }
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '删除分类' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function deleteAction()
    {
        $data[ 'id' ] = $this->request->getPost( 'id', 'int' );
        $data[ 'uptime' ] = date( 'Y-m-d H:i:s' ); 
        
        $phql = 'update \apps\admin\models\GoodsCats set  delsign=' .SystemEnums::DELSIGN_YES . ', uptime=:uptime: where id=:id:' ;
        $result = $this->modelsManager->executeQuery($phql, $data );
        
        if( $result->success() )
        {
            $this->success( '删除成功' );
        }
        else
        {
            $this->error( '删除失败' );
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '判断分类是否重名' )	
     * @method( method = 'checkNameAction' )
     * @op( op = '' )		
    */
    public function checkNameAction()
    {
        $name = $this->request->getPost( 'name', 'string' );
        $status = GoodsCats::findFirst( array( 'name=?0', 'bind' => array( $name )));
        if( $status )
        {
            $this->error( '分类名称已经存在' );
        }
        else
        {
            $this->success( '分类可以添加' );
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '根据父类，获得所有子类' )	
     * @method( method = '_getCategoryTree' )
     * @op( op = '' )
    */
    protected function _getCategoryTree( $pid = 0 )
    {
        $arrCates = array();
        if( ! $this->categorys )
        {
            $where =  'delsign=' . SystemEnums::DELSIGN_NO;
            $objCates = GoodsCats::find( array(  $where, 'columns' => 'id,pid,name','order' => 'pid, sort' ));
            if( $objCates )
            {
                 $this->categorys = $objCates->toArray();
            }
        } 
     
        foreach( $this->categorys as $cate ) 
        {
            if( $cate[ 'pid' ] == $pid )
            {
                $arrCates[ $cate[ 'id' ] ] = $cate;
                $children = $this->_getCategoryTree( $cate[ 'id' ] );

                if( ! empty( $children ) )
                {
                    $arrCates[ $cate[ 'id' ] ][ 'sub' ] = $children; 
                }
            }
        }
   
        return $arrCates;
    }
}
