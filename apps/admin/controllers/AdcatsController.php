<?php

/**
 * 广告分类
 * @author yyl
 * time 2015-8-24
 */

namespace apps\admin\controllers;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\AdCats;
use enums\SystemEnums;

class AdcatsController extends AdminBaseController
{

    private $categorys = array();

    public function initialze()
    {
        parent::initialize();
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.8.24' )
     * @comment( comment = '广告分类首页' )
     * @method( method = 'indexAction' )		
     * @op( op = 'r' )		
     */
    public function indexAction()
    {

        $this->view->adCats = $this->_getCategoryTree();
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.8.24' )
     * @comment( comment = '添加分类显示' )
     * @method( method = 'addAction' )		
     * @op( op = 'r' )		
     */
    public function addAction()
    {
        $this->view->adCats = $this->_getCategoryTree();
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.8.24' )
     * @comment( comment = '编辑分类显示' )
     * @method( method = 'editAction' )		
     * @op( op = 'r' )		
     */
    public function editAction()
    {
        $cateId = $this->request->getQuery( 'id', 'int' );
        $adCats = AdCats::findFirst( array( 'id=?0', 'bind'    => array(
                        $cateId ),
                    'columns' => 'id,name,pid,width,height' ) );

        if( $adCats )
        {
            $this->view->adCats = $adCats->toArray();
        }
        $this->view->allCats = $this->_getCategoryTree(); //所有分类
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.8.24' )
     * @comment( comment = '添加分类' )
     * @method( method = 'insertAction' )		
     * @op( op = 'c' )		
     */
    public function insertAction()
    {
        $this->csrfCheck();

        $data[ 'name' ] = $this->request->getPost( 'cateName', 'string' );
        $data[ 'height' ] = $this->request->getPost( 'height', 'string' );
        $data[ 'width' ] = $this->request->getPost( 'width', 'string' );
        $data[ 'pid' ] = $this->request->getPost( 'parentId', 'int' );
        $data[ 'addtime' ] = $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
        $data[ 'delsign' ] = $data[ 'type' ] = $data[ 'title' ] = 0;

        $adCats = new AdCats();
        if( $adCats->save( $data ) )
        {
            $this->success( '保存成功', array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
        }
        else
       {
            $this->error( '保存失败', array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
        }
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.8.24' )
     * @comment( comment = '更新分类' )
     * @method( method = 'updateAction' )		
     * @op( op = 'u' )		
     */
    public function updateAction()
    {
        $data[ 'id' ] = $this->request->getPost( 'id', 'int' );
        $data[ 'name' ] = $this->request->getPost( 'catName', 'string' );
        $data[ 'pid' ] = $this->request->getPost( 'parentId', 'int' );
        $data[ 'height' ] = $this->request->getPost( 'height', 'string' );
        $data[ 'width' ] = $this->request->getPost( 'width', 'string' );
        $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );

        if( $this->shopId ) //只有本店的才可以操作广告
        {
            $this->error( '你没有权限更新' );
        }

        $adCats = new AdCats();
        $status = $adCats->updateCats( $data );

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
     * @author( author='yyl' )
     * @date( date = '2015.8.24' )
     * @comment( comment = '删除分类' )
     * @method( method = 'deleteAction' )		
     * @op( op = 'd' )		
     */
    public function deleteAction()
    {
        $data[ 'id' ] = $this->request->getPost( 'id', 'int' );
        $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
        if( $this->shopId ) //只有本店的才可以操作广告
        {
            $this->error( '你没有权限删除' );
        }

        $adCats = new AdCats();
        $status = $adCats->deleteCats( $data );

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
     * @author( author='yyl' )
     * @date( date = '2015.8.24' )
     * @comment( comment = '获取广告分类树' )
     * @method( method = '_getCategoryTree' )		
     * @op( op = 'r' )		
     */
    private function _getCategoryTree( $pid = 0 )
    {
        if( !$this->categorys )
        {
            $where = 'delsign=' . SystemEnums::DELSIGN_NO;
            $objCates = AdCats::find( array( $where, 'columns' => 'id,pid,name',
                        'order'   => 'pid' ) );
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

                if( !empty( $children ) )
                {
                    $arrCates[ $cate[ 'id' ] ][ 'sub' ] = $children;
                }
            }
        }
        return $arrCates;
    }

}
