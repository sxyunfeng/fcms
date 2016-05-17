<?php

/**
 * 文章分类
 * @author hfc
 * time 2015-7-27
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\ArticleCats;
use enums\SystemEnums;

class ArticlecatsController extends AdminBaseController {
    
    private $categorys = array(); 
    
    public function initialze()
    {
        parent::initialize();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '文章分类首页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction( )
    {
        $this->view->articleCats = $this->_getCategoryTree();
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
       $this->view->articleCats = $this->_getCategoryTree();
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
        $articleCats =  ArticleCats::findFirst( array( 'id=?0', 'bind' => array( $cateId), 'columns' => 'id,name,parent_id as pid'));
        
        if( $articleCats )
        {
            $this->view->articleCats = $articleCats->toArray();
        }
        $this->view->allCats = $this->_getCategoryTree(); //所有分类
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
        $data[ 'parent_id' ] = $this->request->getPost( 'parentId', 'int' );
        $data[ 'addtime' ] = $data[ 'uptime' ] = date(  'Y-m-d H:i:s' );
        $data[ 'delsign' ] = $data[ 'type'] = $data[ 'title' ] = 0;
        
         //判断一下是否重命名了
        $isExist = ArticleCats::findFirst( array( 'name=?0', 'bind' => array( $data[ 'name' ] )));
        if( $isExist )
        {
            $this->error( '分类已经存在了', array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
        }
        $articleCats = new ArticleCats();
        if( $articleCats->save( $data ) )
        {
            $this->success( '保存成功', array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
        }
        else
        {
            $this->error( '保存失败', array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
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
        $data[ 'id' ] = $this->request->getPost( 'id', 'int' );
        $data[ 'name' ] = $this->request->getPost( 'cateName', 'string' );
        $data[ 'parent_id' ] = $this->request->getPost( 'parentId', 'int' );
        $data[ 'uptime' ] = date( 'Y-m-d H:i:s' ); 
        
        //判断一下是否重命名了
        $isExist = ArticleCats::findFirst( array( 'name=?0 and id != ?1', 'bind' => array( $data[ 'name' ], $data[ 'id' ] )));
        if( $isExist )
        {
            $this->error( '分类已经存在了' );
        }
        $articleCats = new ArticleCats();
        $status = $articleCats->updateCats( $data );

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
     * @date( date = '2015-8-24' )
     * @comment( comment = '删除分类' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function deleteAction()
    {
        $data[ 'id' ] = $this->request->getPost( 'id', 'int' );
        $data[ 'uptime' ] = date( 'Y-m-d H:i:s' ); 
        
        $articleCats = new ArticleCats();
        $status = $articleCats->deleteCats( $data );
        
        if( $status )
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
        $status = ArticleCats::findFirst( array( 'name=?0', 'bind' => array( $name )));
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
    private function _getCategoryTree( $pid = 0 )
    {
        if( ! $this->categorys )
        {
            $where =  'delsign=' . SystemEnums::DELSIGN_NO;
            $objCates = ArticleCats::find( array(  $where, 'columns' => 'id,parent_id as pid,name','order' => 'parent_id' ));
            if( $objCates )
            {
                 $this->categorys = $objCates->toArray();
            }
        } 
     
        $arrCates = array();
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
