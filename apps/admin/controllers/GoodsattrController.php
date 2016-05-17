<?php

/**
 * 商品属性
 * @author yyl
 * time 2015-9-24
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\GoodsAttrsDic;
use apps\admin\models\GoodsAttrsDicValues;
use apps\admin\models\GoodsAttrsKindDic;
use apps\admin\models\GoodsAttrsKindSelTpl;
use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class GoodsattrController extends AdminBaseController
{

    public function initialze()
    {
        parent::initialize();
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.24' )
     * @comment( comment = '商品属性首页' )
     * @method( method = 'indexAction' )		
     * @op( op = 'r' )		
     */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;

        $phql = 'select * from apps\admin\models\GoodsAttrsDic  '
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
     * @comment( comment = '添加商品属性页' )
     * @method( method = 'addAction' )		
     * @op( op = 'r' )		
     */
    public function addAction()
    {
        $kind = new GoodsAttrsKindDic();
        $this->view->kind = $kind->getKinds();
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.24' )
     * @comment( comment = '编辑商品属性' )
     * @method( method = 'editAction' )		
     * @op( op = 'r' )		
     */
    public function editAction()
    {
        $attr_id = $this->request->getQuery( 'id', 'int' );
        $goodsAttr = GoodsAttrsDic::findFirst( array( 'id=?0', 'bind'    => array(
                        $attr_id ),
                    'columns' => 'id,name,length,unit,itype' ) );

        $goodsAttrV = new GoodsAttrsDicValues();
        $goodsAttrVal = $goodsAttrV->getGoodsAttrVal( $attr_id );

        $kind = new GoodsAttrsKindDic();
        $this->view->kinds = $kind->getKinds();

        $kindTpl = new GoodsAttrsKindSelTpl();
        $this->view->kind = $kindTpl->getKind( $attr_id );
        if( $goodsAttrVal )
        {
            $sum = '';
            for( $i = 0; $i <= count( $goodsAttrVal ) - 1; ++$i )
            {
                $sum.=$goodsAttrVal[ $i ][ 'value' ] . ',';
            }
            $newSum = substr( $sum, 0, -1 );
            $this->view->goodsAttrVal = $newSum;
        }

        if( $goodsAttr )
        {
            $this->view->goodsAttr = $goodsAttr->toArray();
        }
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.24' )
     * @comment( comment = '添加商品属性' )
     * @method( method = 'insertAction' )		
     * @op( op = 'c' )		
     */
    public function insertAction()
    {
//        $this->csrfCheck();

        $data[ 'name' ] = $this->request->getPost( 'name', 'string' );
        $data[ 'length' ] = $this->request->getPost( 'length', 'string' );
        $data[ 'unit' ] = $this->request->getPost( 'unit', 'string' );
        $data[ 'itype' ] = $this->request->getPost( 'itype', 'int' );
        $data[ 'addtime' ] = date( 'Y-m-d H:i:s' );
        $data[ 'delsign' ] = 0;

        $kind_id = $this->request->getPost( 'kind_id', 'int' );
        $indetail = $this->request->getPost( 'indetail', 'int' );

        $str = $this->request->getPost( 'val', 'string' );
        $arr = explode( ',', $str );

        $goodsAttr = new GoodsAttrsDic();
        if( $goodsAttr->save( $data ) )
        {
            if( $kind_id != 0 )
            {//保存属性归类
                $k[ 'attr_id' ] = $goodsAttr->id;
                $k[ 'kind_id' ] = $kind_id;
                $k[ 'delsign' ] = 0;
                $k[ 'indetail' ] = $indetail;
                $k[ 'addtime' ] = date( 'Y-m-d H:i:s' );
                $kind = new GoodsAttrsKindSelTpl;
                $kind->save( $k );
            }

            foreach( $arr as $v )
            {//保存属性值
                $goodsAttrVal = new GoodsAttrsDicValues();
                $rst[ 'attr_id' ] = $goodsAttr->id;
                $rst[ 'value' ] = $v;
                $rst[ 'addtime' ] = $rst[ 'uptime' ] = date( 'Y-m-d H:i:s' );
                $rst[ 'delsign' ] = 0;
                $goodsAttrVal->save( $rst );
            }

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
     * @comment( comment = '更新商品属性' )
     * @method( method = 'updateAction' )		
     * @op( op = 'u' )		
     */
    public function updateAction()
    {
        $data[ 'id' ] = $this->request->getPost( 'id', 'int' );
        $data[ 'name' ] = $this->request->getPost( 'name', 'string' );
        $data[ 'length' ] = $this->request->getPost( 'length', 'string' );
        $data[ 'unit' ] = $this->request->getPost( 'unit', 'string' );
        $data[ 'itype' ] = $this->request->getPost( 'itype', 'int' );
        if( $this->shopId ) //只有本店的才可以操作广告
        {
            $this->error( '你没有权限更新' );
        }
        $goodsAttrVal = new GoodsAttrsDicValues();
        $goodsAttrVal->delGoodsAttr( $data[ 'id' ] );

        $goodsAttr = new GoodsAttrsDic();
        $status = $goodsAttr->updateGoodsAttr( $data );
        
        $kind_id = $this->request->getPost( 'kind_id', 'int' );
        $indetail = $this->request->getPost( 'indetail', 'int' );
        
        if( $kind_id != 0 )
        {//保存属性归类
            $k[ 'attr_id' ] = $data[ 'id' ];
            $k[ 'kind_id' ] = $kind_id;
            $k[ 'indetail' ] = $indetail;
            $kind = new GoodsAttrsKindSelTpl;
            $kind->updatekind( $k );
        }

        $str = $this->request->getPost( 'val', 'string' );
        $arr = explode( ',', $str );
        foreach( $arr as $v )
        {
            $goodsAttrVal = new GoodsAttrsDicValues();
            $rst[ 'attr_id' ] = $data[ 'id' ];
            $rst[ 'value' ] = $v;
            $rst[ 'addtime' ] = $rst[ 'uptime' ] = date( 'Y-m-d H:i:s' );
            $rst[ 'delsign' ] = 0;
            $goodsAttrVal->save( $rst );
        }


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
     * @comment( comment = '删除商品属性' )
     * @method( method = 'deleteAction' )		
     * @op( op = 'd' )		
     */
    public function deleteAction()
    {
        $data[ 'id' ] = $this->request->getPost( 'id', 'int' );

        if( $this->shopId ) //只有本店的才可以操作广告
        {
            $this->error( '你没有权限删除' );
        }

        $goodsAttr = new GoodsAttrsDic();
        $status = $goodsAttr->deleteGoodsAttr( $data );

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
