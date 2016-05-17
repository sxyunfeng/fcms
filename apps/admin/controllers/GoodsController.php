<?php
/**
 * 用户管理
 * @author hfc
 * time 2015-7-5
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\CommonDistrictDic;
use apps\admin\models\GoodsCats;
use apps\admin\models\GoodsTechan;
use apps\admin\models\GoodsTechanArticles;
use apps\admin\models\GoodsTechanPics;
use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use vendors\xunsearch\lib\XSDocument;

class GoodsController extends AdminBaseController
{
    private $categorys = array();
    
    public function initialize()
    {
        parent::initialize();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '商品的首页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;
        $goodsName = $this->request->getQuery( 'goodsName', 'string' );
        if( $goodsName )
        {
            $this->view->search = $goodsName;
        }
     
        $goodsModel = new GoodsTechan();
        $goods = $goodsModel->getGoods( $this->shopId, $goodsName );
        
        $pagination = new PaginatorModel( array(
          'data' => $goods,
          'limit' => 10,
          'page' => $currentPage
        ) );
        
        $page = $pagination->getPaginate();
        $this->view->page = $page;
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '编辑商品显示' )	
     * @method( method = 'editAction' )
     * @op( op = '' )		
    */
    public function editAction()
    {
        $id =  $this->request->getQuery( 'id', 'int' )  ;
        //只可以编辑自己的商品
        $goods = GoodsTechan::findFirst( array( 'id=?0 and shop_id=?1', 'bind' => array( $id, $this->shopId )));
        if( $goods != false )
        {
            $this->view->goods = $goods->toArray();
            $where = 'goods_id=' . $goods->id;
            
            $goodsPics = GoodsTechanPics::find( $where ); //图片
            if( $goodsPics != false )
            {
                $this->view->goodsPics = $goodsPics->toArray();
            }
            
            $goodsArticle = GoodsTechanArticles::findFirst( $where  ); //文章
            if( $goodsArticle != false )
            {
                $this->view->goodsArticle = $goodsArticle->toArray();
            }
            
            $this->view->categorys = $this->_getCategoryTree();
            $country =  CommonDistrictDic::findFirst( 'id=' . $goods->address );
            if( $country )
            {
                $this->view->provinces =  CommonDistrictDic::find( 'upid=0' )->toArray(); //省份
                $citys =  CommonDistrictDic::find( 'id='.$country->upid )->toArray(); //市
                $this->view->citys =  CommonDistrictDic::find( 'upid=' . $citys[0][ 'upid'] )->toArray(); //省份
                $this->view->countrys =  CommonDistrictDic::find( 'upid=' . $country->upid )->toArray();
                $this->view->countryId = $country->id;
                $this->view->cityId = $country->upid;
                $this->view->proviceId = $citys[0][ 'upid' ];
            }
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '添加商品显示' )	
     * @method( method = 'addAction' )
     * @op( op = '' )		
    */
    public function addAction()
    {
        $this->view->categorys = $this->_getCategoryTree();
        $this->view->provinces =  CommonDistrictDic::find( 'upid=0' )->toArray(); //省份
        $this->view->citys =  CommonDistrictDic::find( 'upid=27' )->toArray(); //市
        $this->view->countrys =  CommonDistrictDic::find( 'upid=438' )->toArray(); //县
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '获得商品的产地' )	
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
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 更新商品' )	
     * @method( method = 'updateAction' )
     * @op( op = 'u' )		
    */
    public function updateAction()
    {
        $this->csrfCheck(); //csrf检验
        $goodsId = $this->request->getPost( 'goodsId', 'int' );
        $data[ 'name' ] = $this->request->getPost( 'name', 'trim' );
        $data[ 'price' ] = $this->request->getPost( 'price', 'float' );
        $data[ 'cat_id' ] =  $this->request->getPost( 'categoryId', 'int' ) ;
        $data[ 'skuleft' ] = $this->request->getPost( 'skuleft', 'int' );
        $data[ 'status' ] = $this->request->getPost( 'status', 'int' );
        $data[ 'weight' ] = $this->request->getPost( 'weight', 'int' );
        $data[ 'address' ] = $this->request->getPost( 'address', 'int' );
        $data[ 'pics' ] = $this->request->getPost( 'pics' ); 
        $this->validation( $data ); //验证输入数据
        
        $pics = $data[ 'pics' ];
        if( strpos( $pics[0], 'http://') === false )
        {
            $pics[0] = SystemEnums::PIC_HOST .  $pics[0] ;
        }
        $data[ 'thumb_url' ] = $pics[0] ;
        
        unset( $data[ 'pics' ]);
        $data[ 'uptime' ]  = date( 'Y-m-d H:i:s' );
        $goods = GoodsTechan::findFirst( array( 'id=?0 and shop_id=?1','bind' =>  array(  $goodsId, $this->shopId ) ) );
        
        if( $goods && $goods->update( $data ))
        {
            $goodsPics = GoodsTechanPics::find( array( 'goods_id=?0','bind' =>  array(  $goodsId ) ) );
            foreach ( $goodsPics as $goodsPic )
            {
                $goodsPic->delete();//把以前的图片删除掉
            }
            //保存商品的图片
            $addtime = $data[ 'uptime' ];
            $phql = "insert into \apps\admin\models\GoodsTechanPics ( addtime,delsign,url,thumb_url,sort,goods_id )" . 
                     " values( '$addtime', 0, :url:, :thumb_url:, :sort:, '$goodsId' )";
            $query = $this->modelsManager->createQuery( $phql );
            foreach( $pics as $key => $pic )
            {
                if(  strpos( $pic, 'http://') === false )
                {
                    $pic = SystemEnums::PIC_HOST . $pic;
                }
                
                $picData[ 'url'] =  $pic;
                $picData[ 'thumb_url'] = $pic; //缩略图和原图一致
                $picData[ 'sort' ] = $key;
                $status = $query->execute( $picData );
                if( ! $status->success() )
                {
                    $this->error( '更新图片失败' );
                }
            }
            
            //更新全文搜索
            $this->xsuAction( $goods->toArray() );
            
            $this->success( '更新成功', array( 'id' => $goodsId ));
        }
        else
        {
            $this->error( '更新失败' );
        }
    }

    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 商品下架' )	
     * @method( method = 'unshelveAction' )
     * @op( op = 'u' )		
    */
    public function  unshelveAction()
    {
        $id = $this->request->getPost( 'id', 'int' );
        $goods = GoodsTechan::findFirst( $id );
        
        if( $goods )
        {
            $status = $goods->update( array( 'status' => SystemEnums::GOODS_UNSHELVE, 'unshelve_time' => date( 'Y-m-d H:i:s')));
            if( $status )
            {
                $this->success( '下架成功' );
            }
        }
       
        $this->error( '下架失败' );
  
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 商品上架' )	
     * @method( method = 'shelveAction' )
     * @op( op = 'u' )		
    */
    public function shelveAction()
    {
        $id = $this->request->getPost( 'id', 'int' );
        $goods = GoodsTechan::findFirst( $id );
        
        if( $goods )
        {
            $status = $goods->update( array( 'status' => SystemEnums::GOODS_SHELVE, 'shelve_time' => date( 'Y-m-d H:i:s')));
            if( $status )
            {
                $this->success( '上架成功' );
            }
        }
        $this->error( '下架失败' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 删除商品' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'u' )		
    */
    public function deleteAction()
    {
        $id = $this->request->getPost( 'id', 'int' );
        $goods = GoodsTechan::findFirst( array( 'id=?0 and shop_id=?1', 'bind' => array( $id, $this->shopId )) );
        
        if( $goods )
        {
            $status = $goods->update( array( 'delsign' => SystemEnums::DELSIGN_YES, 'uptime' => date( 'Y-m-d H:i:s')));
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
     * @comment( comment = 'ajax 请求 添加一个新商品' )	
     * @method( method = 'insertAction' )
     * @op( op = 'c' )		
    */
    public function insertAction()
    {
        $this->csrfCheck(); //csrf检验
        
        $data[ 'name' ] = $this->request->getPost( 'name', 'trim' );
        $data[ 'price' ] = $this->request->getPost( 'price', 'float' );
        $data[ 'cat_id' ] =  $this->request->getPost( 'categoryId', 'int' ) ;
        $data[ 'skuleft' ] = $this->request->getPost( 'skuleft', 'int' );
        $data[ 'status' ] = $this->request->getPost( 'status', 'int' );
        $data[ 'weight' ] = $this->request->getPost( 'weight', 'float' );
        $data[ 'address' ] = $this->request->getPost( 'address', 'int' );
        $data[ 'pics' ] = $this->request->getPost( 'pics' ); 
        $this->validation( $data );
        
        $pics = $data[ 'pics' ]; 
        if( strpos( $pics[0], 'http://' ) === false )
        {
            $pics[0] = SystemEnums::PIC_HOST . $pics[0];
        }
        $data[ 'thumb_url' ] = $pics[0];
        
        unset( $data[ 'pics' ] ); 
        $data[ 'addtime' ] = $data[ 'uptime' ] = $data[ 'shelve_time' ] = date( 'Y-m-d H:i:s' );
        $data[ 'delsign' ] =  $data[ 'descr' ] = 0;
        $data[ 'shop_id' ] = $this->shopId;
//        $code = array('HR.1', 'HR.2', 'HR.3', 'HR.4', 'HR.5', 'HR.6', 'HR.7', 'HR.8', 'HR.9', 'HR.10');
//        $data['goods_sn'] = $code[intval(date('Y')) - 2014] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        $goods = new GoodsTechan();
        
        if( $goods->save( $data ))
        {
            $goodsId = $goods->id;
            //保存商品的图片
            $addtime = $data[ 'addtime' ];
            $phql = "insert into \apps\admin\models\GoodsTechanPics ( addtime,delsign,url,thumb_url,sort, goods_id )" . 
                     " values( '$addtime', 0, :url:,:thumb_url:,:sort:, '$goodsId' )";
            $query = $this->modelsManager->createQuery( $phql );
            foreach( $pics as $key => $pic )
            {
                if( strpos( $pic, 'http://' ) === false )
                {
                    $pic = SystemEnums::PIC_HOST  . $pic;
                }
                $picData[ 'url'] = $pic;
                $picData[ 'thumb_url'] = $pic ;
                $picData[ 'sort' ] = $key;
                $status = $query->execute( $picData );
                if( ! $status->success() )
                {
                    $this->error( '保存图片失败' );
                }
            }
            //准备数据给全文搜索
            
            $this->xscAction( $goods->toArray() );
            
            $this->success( '保存成功', array( 'id' => $goodsId ));
        }
        else
        {
            foreach( $goods->getMessages() as $msg )
            {
                echo $msg, PHP_EOL;
            }
            $this->error( '保存失败' );
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '添加和更新商品文章' )	
     * @method( method = 'saveArticleAction' )
     * @op( op = 'u' )		
    */
    public function saveArticleAction()
    {
        $data[ 'content' ] = $this->request->getPost( 'content' );
        $data[ 'goods_id' ] = $this->request->getPost( 'goodsId', 'int' );
        $data[ 'delsign' ] = 0; 
        $data[ 'uptime' ] = date( 'Y-m-d H:i:s' );
      
        $goodsArticle = GoodsTechanArticles::findFirst( array( 'goods_id=?0', 'bind' => array( $data[ 'goods_id' ] )) );
        if( $goodsArticle ) //更新
        {
            if( $goodsArticle->save( $data ) ) 
            {
                $this->success( '更新文章成功' );
            }
            else
            {
                $this->error(  '更新文章失败' );
            }
        }
        else //添加新的
        {
            $goodsArticle = new GoodsTechanArticles();
            $data[ 'addtime' ]  = $data[ 'uptime' ];
            if( $goodsArticle->save( $data ) ) 
            {
                $this->success( '添加文章成功' );
            }
            else
            {
                $this->error(  '添加文章失败' );
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
     * 对输入的数据进行验证
     * param array $data
     */
    private  function validation( $data = array() )
    {
        $validation = new Validation();
        $validation->add( 'name', new PresenceOf(array(
            'message' => '商品名必须填写'
        )));
        $validation->add( 'price', new PresenceOf(array(
            'message' => '价格必须填写'
        )));
        $validation->add( 'cat_id', new PresenceOf(array(
            'message' => '分类必须选择'
        )));
        $validation->add( 'skuleft', new PresenceOf(array(
            'message' => '库存数量必须填写'
        )));
        $validation->add( 'pics', new PresenceOf(array(
            'message' => '商品图片必须上传'
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
     * create  全文搜索
     * goods array 商品数据 
     */
    private function xscAction( $goods )
    {
        $xs = $this->getDI()->get( 'xs_goods' );
        $index = $xs->index;
        $doc = new XSDocument();
        
        $data = array( 'sid' => $goods[ 'id'],
                'title' => $goods[ 'name'],
                'content' => "商品名称：{$goods[ 'name']} 商品编号：{$goods[ 'id']}上架时间：{$goods[ 'shelve_time']} 商品毛重：{$goods[ 'weight' ]}kg 商品产地：{$goods[ 'address']}",
                'pic' => $goods[ 'thumb_url' ],
                'price' => $goods[ 'price' ],
                'sn' => $goods[ 'id'],
                'sdate' => $goods[ 'shelve_time' ],
                'scnt' => 0,
                'ccnt' =>  0 );
        $doc->setFields( $data );
        $index->add( $doc );   
    }
    
    /**
     * update 全文搜索
     * goods array 商品数据 
     */
    public function xsuAction( $goods )
    {
        $xs = $this->getDI()->get( 'xs_goods' );
        $index = $xs->index;
         
        $doc = new XSDocument();
        $doc->setFields( array('sid' => $goods[ 'id'],
                'title' => $goods[ 'name'],
                'content' => "商品名称：{$goods[ 'name']} 商品编号：{$goods[ 'id']}上架时间：{$goods[ 'shelve_time']} 商品毛重：{$goods[ 'weight' ]}kg 商品产地：{$goods[ 'address']}",
                'pic' => $goods[ 'thumb_url' ],
                'price' => $goods[ 'price' ],
                'sn' => $goods[ 'id'],
                'sdate' => $goods[ 'shelve_time' ],
                'scnt' => 0,
                'ccnt' =>  0  ) );
        
        $index->update( $doc );
    }
    
    /*
     *测试全文搜索 
     */
     public function xsrAction()
    {
        $xs = $this->getDI()->get( 'xs_goods' );
        $search = $xs->search;
        $search->setQuery( '核桃' );
        var_dump( $search->search( ) );
    }
}
