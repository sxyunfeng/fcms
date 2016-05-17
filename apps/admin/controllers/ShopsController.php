<?php
/**
 * 商铺管理
 * @author hfc
 * time 2015-7-5
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\CommonDistrictDic;
use apps\admin\models\GoodsCats;
use apps\admin\models\PriUsers;
use apps\admin\models\ShopCats;
use apps\admin\models\ShopQq;
use apps\admin\models\Shops;
use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class ShopsController extends AdminBaseController
{
    private $categorys = null;
    public function initialize()
    {
        parent::initialize();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '商铺的首页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;

        $where = 'delsign=' . SystemEnums::DELSIGN_NO ;
        if( $this->userId != SystemEnums::SUPER_ADMIN_ID && $this->shopId ) //超级管理员可以看所有的，其他人只可以看自己的
        {
             $where = " and id=" . $this->shopId;        
        }

        $phql = 'select id,name,status,tel,linkman,province,city,district from apps\admin\models\Shops  where '  . $where ;
            
        $shops = $this->modelsManager->executeQuery( $phql );
    
        $pagination = new PaginatorModel( array(
          'data' => $shops,
          'limit' => 10,
          'page' => $currentPage
        ) );
        
        $page = $pagination->getPaginate();
        foreach( $page->items as & $vo )
        {
            switch( $vo->status )
            {
                case 0 : 
                    $vo->status = '正常';
                    break;
                case 1:
                    $vo->status = '欠款';
                    break;
                case 2:
                    $vo->status = '下架';
                    break;
                case 3:
                    $vo->status = '未审核';
                    break;
                default:
                    break;
            }
            //商铺分类名
            $shopCate = ShopCats::findFirst( 'shop_id=' . $vo->id );
            if( $shopCate )
            {
                $goodsCate = GoodsCats::findFirst( 'id=' . $shopCate->cat_id );
                if( $goodsCate )
                {
                    $vo->cateName = $goodsCate->name;
                }
            }
           
            //地址翻译
            $province = CommonDistrictDic::findFirst( 'id='. $vo->province );
            $address = ( $province ? $province->name : '' ) . ' '; 
            
            $city = CommonDistrictDic::findFirst( 'id='. $vo->city );
            $address .= ( $city ? $city->name : '' ) . ' '; 

            $district = CommonDistrictDic::findFirst( 'id='. $vo->district );
            $address .= ( $district ? $district->name : '' ) . ' '; 

            $vo->address = $address . $vo->detail_addr;
        }
        $this->view->page = $page;
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '编辑商铺显示' )	
     * @method( method = 'editAction' )
     * @op( op = '' )		
    */
    public function editAction()
    {
        $id =  $this->request->getQuery( 'id', 'int' );
        $this->checkShop( $id ); //判断一下是否是自己的商铺

        $shop = Shops::findFirst( array( 'id=?0', 'bind' => array( $id )));
        if( $shop )
        {
            $this->view->provinces =  CommonDistrictDic::find( 'upid=0' )->toArray(); //省份
            $this->view->citys =  CommonDistrictDic::find( 'upid=' . $shop->province )->toArray(); //市
            $this->view->countrys =  CommonDistrictDic::find( 'upid=' . $shop->city )->toArray(); //县
            $this->view->shop = $shop->toArray();
            $this->view->shopCateId = ShopCats::findFirst( array( 'shop_id=?0', 'bind' => array( $id )) )->cat_id;
            $this->view->categorys = $this->_getCategoryTree();
        }
        $qq = ShopQq::find( array( 'shop_id=?0', 'bind' => array( $id )));
       
        if( $qq  )
        {
            $this->view->qq = $qq->toArray();
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '添加用户界面显示' )	
     * @method( method = 'addAction' )
     * @op( op = '' )		
    */
    public function addAction()
    {
        $this->view->categorys = $this->_getCategoryTree();
        $this->view->provinces =  CommonDistrictDic::find( 'upid=0' )->toArray(); //省份
        $this->view->citys =  CommonDistrictDic::find( 'upid=27'  )->toArray(); //市
        $this->view->countrys =  CommonDistrictDic::find( 'upid=438' )->toArray(); //县
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 更新用户' )	
     * @method( method = 'updateAction' )
     * @op( op = 'u' )		
    */
    public function updateAction()
    {
        $this->csrfCheck();
        
        $shopId = $this->request->getPost( 'shopId', 'int' );
        $this->checkShop( $shopId );
       
        $data[ 'name' ] = $this->request->getPost( 'name', 'string' );
        $data[ 'linkman' ] = $this->request->getPost( 'linkman', 'string' );
        $data[ 'tel' ] = $this->request->getPost( 'tel', 'string' );
        $data[ 'province' ] = $this->request->getPost( 'province', 'int' );
        $data[ 'city' ] = $this->request->getPost( 'city', 'int' );
        $data[ 'district' ] = $this->request->getPost( 'district', 'int' );
        $data[ 'detail_addr' ] = $this->request->getPost( 'detail_addr', 'string' );
        $data[ 'status' ] = $this->request->getPost( 'status', 'int' );
        $categoryId = $this->request->getPost( 'categoryId', 'int');
        
        $qq = $this->request->getPost( 'qq' );
        $qqStatus = $this->request->getPost( 'qqStatus' );
        
        $this->validation( $data );//验证数据
        $data[ 'status' ] = $data[ 'status'] ? $data[ 'status'] - 1 : 0; //网页中已经加1
        $shop = Shops::findFirst( array( 'id=?0', 'bind' => array( $shopId )));
        
        if( $shop )
        {
            $status = $shop->update( $data );
            if( $status )
            {
                $cate = ShopCats::findFirst( array( 'shop_id=?0', 'bind' => array( $shopId )) );
                if( ! $cate )
                {
                    $shopCate[ 'cat_id' ] = $categoryId;
                    $shopCate[ 'shop_id' ] = $shop->id;
                    $shopCate[ 'delsign' ] = 0;
                    $shopCate[ 'addtime' ]  = date( 'Y-m-d H:i:s' );
                    $cate = new ShopCats();
                }
                else
                {
                    $shopCate[ 'cat_id' ] = $categoryId;
                }
                
                if( ! $cate->save( $shopCate ) )
                {
                    $this->error( '更新失败' );
                }
                
                $qqs = ShopQq::find( array( 'shop_id=?0', 'bind' => array($shopId ) ));
                foreach( $qqs as $vo )
                {
                    $vo->delete(); //先删除
                }
                //添加qq
                foreach( $qq as $key => $qqNum )
                {
                    if( $qqNum )
                    {
                        $qqData[ 'qq' ] = $qqNum;
                        $qqData[ 'status' ] = $qqStatus[ $key ];
                        $qqData[ 'shop_id'] = $shop->id;
                        $qqData[ 'delsign' ] = 0;
                        $qqData[ 'addtime' ]  = date( 'Y-m-d H:i:s' );

                        $shopQQ = new ShopQq();
                        if( ! $shopQQ->save( $qqData ) )
                        {
                            $this->error( '添加失败' );
                        }
                    }
                }
                $this->success( '添加成功' );
       
            }
         
        }
        $this->error( '更新失败' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax请求 修改密码' )	
     * @method( method = 'changePasswordAction' )
     * @op( op = 'u' )		
    */
    public function changePasswordAction()
    {
        $this->csrfCheck();
        
        $userId = $this->request->getPost( 'userId', 'int' );
        $this->checkSelf( $userId );
        
        $user = null;
        $oldPassword = $this->request->getPost( 'oldPassword', 'trim' );
        if( $oldPassword )
        {
            $user = PriUsers::findFirst( array( 'id=?0','bind' => array( $userId ))  );
            if( $user )
            {
                $pwd = md5( $this->session->getId() . $user->pwd );
                if( $pwd != $oldPassword )
                {
                    $this->error( '原密码不正确' );
                }
            }
        }
        else
        {
            $this->error( '请输入原密码' );
        }
        
        $password = $this->request->getPost( 'password', 'trim' );
        $repassword = $this->request->getPost( 'repassword', 'trim' );
        if( $password != $repassword )
        {
            $this->error( '密码不一致' );
        }
       
        if( $user )
        {
            if( $user->update( array( 'pwd' =>  $password  ) ))
            {
                $this->success( '修改密码成功' );
            }
            else
            {
                $this->error( '修改密码失败' );
            }
        }
    }

    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 删除商铺' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function deleteAction()
    {
//        $this->csrfCheck();
        $id = $this->request->getPost( 'id', 'int' );
        $shop =  Shops::findFirst( array( 'id=?0', 'bind' => array( $id )) );
        
        if( $shop )
        {
            $status = $shop->update( array( 'delsign' => SystemEnums::DELSIGN_YES, 'uptime' => date( 'Y-m-d H:i:s')));
            if( $status )
            {
                 $this->success( '删除成功' );
            }
        }
        $this->error( '删除失败' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 添加一个商铺' )	
     * @method( method = 'insertAction' )
     * @op( op = 'c' )		
    */
    public function insertAction()
    {
        $this->csrfCheck();
        $data[ 'name' ] = $this->request->getPost( 'name', 'string' );
        $data[ 'linkman' ] = $this->request->getPost( 'linkman', 'string' );
        $data[ 'tel' ] = $this->request->getPost( 'tel', 'string' );
        $data[ 'province' ] = $this->request->getPost( 'province', 'int' );
        $data[ 'city' ] = $this->request->getPost( 'city', 'int' );
        $data[ 'district' ] = $this->request->getPost( 'district', 'int' );
        $data[ 'detail_addr' ] = $this->request->getPost( 'detail_addr', 'string' );
        $data[ 'status' ] = $this->request->getPost( 'status', 'int' );
        $categoryId = $this->request->getPost( 'categoryId', 'int');
        
        $qq = $this->request->getPost( 'qq' );
        $qqStatus = $this->request->getPost( 'qqStatus' );
       
        $data[ 'delsign' ] = 0;
        $data[ 'addtime' ] = $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
        
        $this->validation( $data );//验证数据
        $data[ 'status' ] = $data[ 'status'] ? $data[ 'status'] - 1 : 0; //网页中已经加1
        $shop = new Shops();
        
        if( $shop->save( $data ) )
        {
            $shopCate[ 'cat_id' ] = $categoryId;
            $shopCate[ 'shop_id' ] = $shop->id;
            $shopCate[ 'delsign' ] = 0;
            $shopCate[ 'addtime' ]  = date( 'Y-m-d H:i:s' );
            $cate = new ShopCats();
            if( ! $cate->save( $shopCate ) )
            {
                $this->error( '添加失败' );
            }
            //添加qq
            foreach( $qq as $key => $qqNum )
            {
                if( $qqNum )
                {
                    $qqData[ 'qq' ] = $qqNum;
                    $qqData[ 'status' ] = $qqStatus[ $key ];
                    $qqData[ 'shop_id'] = $shop->id;
                    $qqData[ 'delsign' ] = 0;
                    $qqData[ 'addtime' ]  = date( 'Y-m-d H:i:s' );
                    
                    $shopQQ = new ShopQq();
                    if( ! $shopQQ->save( $qqData ) )
                    {
                        $this->error( '添加失败' );
                    }
                }
            }
            $this->success( '添加成功' );
        }
      
        $this->error( '添加失败' );
    }
    
    /**
     * 对输入的数据进行验证
     * param array $data
     */
    private  function validation( $data = array() )
    {
        $validation = new Validation();
        $validation->add( 'name', new PresenceOf(array(
            'message' => '商铺名称必须填写'
        )));
        $validation->add( 'tel', new PresenceOf(array(
            'message' => '商铺电话必须填写'
        )));
        $validation->add( 'linkman', new PresenceOf(array(
            'message' => '联系人必须填写'
        )));
        $validation->add( 'province', new PresenceOf(array(
            'message' => '省必须填写'
        )));
        $validation->add( 'city', new PresenceOf(array(
            'message' => '市必须填写'
        )));
        $validation->add( 'district', new PresenceOf(array(
            'message' => '区必须填写'
        )));
        $validation->add( 'detail_addr', new PresenceOf(array(
            'message' => '详细地址必须填写'
        )));
        $validation->add( 'status', new PresenceOf(array(
            'message' => '状态必须填写'
        )));
        
        $messages =  $validation->validate( $data );
        
        if( count( $messages ))
        {
            foreach( $messages as $msg )
            {
                $this->error( $msg->getMessage() );
            }
        }
    }
    /**
     * 根据父类，获得所有子类
     * param type $pid
     * return type
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
    
     /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '获得商鋪的地址' )	
     * @method( method = 'getAddressAction' )
     * @op( op = '' )		
    */
    public function getAddressAction()
    {
        $id = $this->request->getQuery( 'id', 'int' );
        $address = CommonDistrictDic::find( array( 'upid=?0', 'bind' => array( $id ) ));
        
        if( $address != false )
        {
            $data[ 'address' ] = $address->toArray();
            $this->success( '获得地址成功', $data );
        }
        else
        {
            $this->error( '获得地址失败');

        }
    }
}
