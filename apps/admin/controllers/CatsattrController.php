<?php

/**
 * 广告分类
 * @author yyl
 * time 2015-9-24
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );


use apps\admin\models\GoodsAttrsKindDic;
use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class CatsattrController extends AdminBaseController
{

    public function initialze()
    {
        parent::initialize();
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.24' )
     * @comment( comment = '分类属性首页' )
     * @method( method = 'indexAction' )		
     * @op( op = 'r' )		
     */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;

        $phql = 'select * from apps\admin\models\GoodsAttrsKindDic  '
                . '   where delsign=' . SystemEnums::DELSIGN_NO . ' order by id desc';
        $list = $this->modelsManager->executeQuery( $phql );
        $pagination = new PaginatorModel( array(
            'data'  => $list,
            'limit' => 10,
            'page'  => $currentPage
                ) );

        $page = $pagination->getPaginate();
        $this->view->page = $page;
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.24' )
     * @comment( comment = '添加分类属性页' )
     * @method( method = 'addAction' )		
     * @op( op = 'r' )		
     */
    public function addAction()
    {
        
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.24' )
     * @comment( comment = '编辑分类属性' )
     * @method( method = 'editAction' )		
     * @op( op = 'r' )		
     */
    public function editAction()
    {
        $cateId = $this->request->getQuery( 'id', 'int' );
        $catsAttr = GoodsAttrsKindDic::findFirst( array( 'id=?0', 'bind'    => array(
                        $cateId ),
                    'columns' => 'id,title' ) );

        if( $catsAttr )
        {
            $this->view->catsAttr = $catsAttr->toArray();
        }
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.24' )
     * @comment( comment = '添加分类属性' )
     * @method( method = 'insertAction' )		
     * @op( op = 'c' )		
     */
    public function insertAction()
    {
//        $this->csrfCheck();

        $data[ 'title' ] = $this->request->getPost( 'title', 'string' );

        $data[ 'addtime' ] = $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
        $data[ 'delsign' ] = 0;

        $catsAttr = new GoodsAttrsKindDic();
        if( $catsAttr->save( $data ) )
        {
            $this->success( '保存成功' );
        }
        else
        {
            $this->error( '保存失败' );
        }
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.24' )
     * @comment( comment = '更新分类属性' )
     * @method( method = 'updateAction' )		
     * @op( op = 'u' )		
     */
    public function updateAction()
    {
        $data[ 'id' ] = $this->request->getPost( 'id', 'int' );
        $data[ 'title' ] = $this->request->getPost( 'title', 'string' );
        $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
        if( $this->shopId ) //只有本店的才可以操作广告
        {
            $this->error( '你没有权限更新' );
        }

        $catsAttr = new GoodsAttrsKindDic();
        $status = $catsAttr->updateCatsAttr( $data );

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
     * @date( date = '2015.9.24' )
     * @comment( comment = '删除分类属性' )
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

        $catsAttr = new GoodsAttrsKindDic();
        $status = $catsAttr->deleteCatsAttr( $data );

        if( $status )
        {

            $this->success( '删除成功' );
        }
        else
        {

            $this->error( '删除失败' );
        }
    }

}
