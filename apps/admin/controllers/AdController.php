<?php

/**
 * 广告
 * @author yyl
 * time 2015-8-24
 */

namespace apps\admin\controllers;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\AdCats;
use apps\admin\models\Ad;
use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class AdController extends AdminBaseController
{

    private $categorys = array();

    public function initialize()
    {
        parent::initialize();
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.8.25' )
     * @comment( comment = '广告首页' )
     * @method( method = 'indexAction' )		
     * @op( op = 'r' )		
     */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;

        $phql = 'select a.id,a.end_time,a.begin_time,a.media_type,a.name,a.enabled,c.name as cat_name from apps\admin\models\Ad as a '
                . ' join apps\admin\models\AdCats as c on a.cat_id=c.id  where a.delsign=' . SystemEnums::DELSIGN_NO . ' order by a.sort_order desc';

        $ad = $this->modelsManager->executeQuery( $phql );
        $pagination = new PaginatorModel( array(
            'data'  => $ad,
            'limit' => 10,
            'page'  => $currentPage
                ) );

        $page = $pagination->getPaginate();
        $this->view->page = $page;
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.8.25' )
     * @comment( comment = '编辑商品显示' )
     * @method( method = 'editAction' )		
     * @op( op = 'r' )		
     */
    public function editAction()
    {
        $id = $this->request->getQuery( 'id', 'int' );
        $ad = Ad::findFirst( array( 'id=?0', 'bind' => array( $id ) ) );
        if( $ad != false )
        {
            $this->view->ad = $ad->toArray();
        }

        $this->view->categorys = $this->_getCategoryTree();
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.8.25' )
     * @comment( comment = '添加商品显示' )
     * @method( method = 'addAction' )		
     * @op( op = 'r' )		
     */
    public function addAction()
    {
        $this->view->categorys = $this->_getCategoryTree();
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.8.25' )
     * @comment( comment = '更新广告' )
     * @method( method = 'updateAction' )		
     * @op( op = 'u' )		
     */
    public function updateAction()
    {
//        $this->csrfCheck(); //csrf检验
        $adId = $this->request->getPost( 'adId', 'int' );

        $data[ 'title' ] = $this->request->getPost( 'title', 'string' );
        $data[ 'cat_id' ] = $this->request->getPost( 'categoryId', 'int' );
        $data[ 'name' ] = $this->request->getPost( 'name', 'string' );
        $data[ 'begin_time' ] = strtotime( $this->request->getPost( 'begin_time',
                        'string' ) );
        $data[ 'end_time' ] = strtotime( $this->request->getPost( 'end_time',
                        'string' ) );
        $data[ 'sort_order' ] = $this->request->getPost( 'sort_order', 'int' );
        $data[ 'media_type' ] = $this->request->getPost( 'media_type', 'int' );
        $data[ 'url' ] = $this->request->getPost( 'pics' );
        $data[ 'src' ] = $this->request->getPost( 'source_url', 'string' );
        $data[ 'enabled' ] = $this->request->getPost( 'enabled', 'int' );
        $this->validation( $data ); //验证输入数据
        $data[ 'user_id' ] = $this->userId;
        $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );

        $ad = Ad::findFirst( array( 'id=?0', 'bind' => array( $adId ) ) );

        if( $ad && $ad->update( $data ) )
        {
            $this->success( '更新成功' );
        }
        else
        {
            foreach( $ad->getMessages() as $msg )
            {
                echo $msg, PHP_EOL;
            }
            $this->error( '更新失败' );
        }
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.8.25' )
     * @comment( comment = '删除广告' )
     * @method( method = 'deleteAction' )		
     * @op( op = 'd' )		
     */
    public function deleteAction()
    {
        $id = $this->request->getPost( 'id', 'int' );
        $goods = Ad::findFirst( array( 'id=?0', 'bind' => array( $id ) ) );

        if( $goods )
        {
            $status = $goods->update( array( 'delsign' => SystemEnums::DELSIGN_YES,
                'uptime'  => date( 'Y-m-d H:i:s' ) ) );
            if( $status )
            {
                $this->success( '删除成功' );
            }
        }
        $this->error( '删除失败' );
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.8.25' )
     * @comment( comment = '添加广告' )
     * @method( method = 'insertAction' )		
     * @op( op = 'c' )		
     */
    public function insertAction()
    {
//        $this->csrfCheck(); //csrf检验
        /* $csrf = $this->request->getPost( 'tokenName' , 'string' );
        $csrfValue = $this->security->checkToken( 'lUx9C5gByzvMymIa' ); */
        
        
        $data[ 'title' ] = $this->request->getPost( 'title', 'string' );
        $data[ 'cat_id' ] = $this->request->getPost( 'categoryId', 'int' );
        $data[ 'name' ] = $this->request->getPost( 'name', 'string' );
        $data[ 'begin_time' ] = strtotime( $this->request->getPost( 'begin_time',
                        'string' ) );
        $data[ 'end_time' ] = strtotime( $this->request->getPost( 'end_time',
                        'string' ) );
        $data[ 'sort_order' ] = $this->request->getPost( 'sort_order', 'int' );
        $data[ 'media_type' ] = $this->request->getPost( 'media_type', 'int' );
        $data[ 'url' ] = $this->request->getPost( 'pics' );
        $data[ 'src' ] = $this->request->getPost( 'source_url', 'string' );
        $data[ 'enabled' ] = $this->request->getPost( 'enabled', 'int' );

        $this->validation( $data ); //验证输入数据
        $data[ 'delsign' ] = 0;
        $data[ 'shopid' ] = $this->shopId;
        $data[ 'user_id' ] = $this->userId;
        $data[ 'addtime' ] = $data[ 'uptime' ] = time();

        $ad = new Ad();
        
        if( $ad->save( $data ) )
        {
            $this->success( '保存成功', array( 'id' => $ad->id ) );
        }
        else
       {
            foreach( $ad->getMessages() as $msg )
            {
                echo $msg, PHP_EOL;
            }
            $this->error( '保存失败', array( 'id' => $ad->id ) );
        }
    }

    /**
     * @author( author='yyl' )
     * @date( date = '2015.8.25' )
     * @comment( comment = '获取广告分类树' )
     * @method( method = '_getCategoryTree' )		
     * @op( op = 'r' )		
     */
    protected function _getCategoryTree( $pid = 0 )
    {
        $arrCates = array();
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

    /**
     * @author( author='yyl' )
     * @date( date = '2015.8.25' )
     * @comment( comment = '数据验证' )
     * @method( method = 'validation' )		
     * @op( op = '' )		
     */
    private function validation( $data = array() )
    {
        $validation = new Validation();
        $validation->add( 'title',
                new PresenceOf( array(
            'message' => '广告标题必须填写'
        ) ) );
        $validation->add( 'cat_id',
                new PresenceOf( array(
            'message' => '广告分类必须填写'
        ) ) );

        $messages = $validation->validate( $data );
        if( count( $messages ) )
        {
            foreach( $messages as $msg )
            {
                $this->error( $msg->getMessage() );
            }
        }
    }

}
