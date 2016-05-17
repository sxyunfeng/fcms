<?php
/**
 * 商品评论管理
 * @author hfc
 * @time 2015-7-23
 */

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\GoodsTechanComments;
use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class GoodscommentsController extends AdminBaseController
{
    
    public function initialize()
    {
        parent::initialize();
      
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '商品评论的首页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;
        
        $phql = 'select c.id, c.comment, c.serv_marks, c.goods_marks, c.is_reply, m.username, g.name as goods_name '
                . ' from apps\admin\models\GoodsTechanComments as c  ' .
                 'join apps\admin\models\MemMembers as m on c.mem_id = m.id  ' .
                 'join apps\admin\models\GoodsTechan as g on c.goods_id = g.id  ' .
                 'where c.delsign = ' .SystemEnums::DELSIGN_NO;  
        
        if( $this->userId != SystemEnums::SUPER_ADMIN_ID && $this->shopId ) //超级管理员可以看所有的，其他商铺只可以看到买了自己I商品的会员
        {
             $phql .=   ' and g.shop_id =  ' . $this->shopId ;
        }
       
        $list = $this->modelsManager->executeQuery( $phql );
        $pagination = new PaginatorModel( array(
          'data' => $list,
          'limit' => 10,
          'page' => $currentPage
        ) );
        
        $page = $pagination->getPaginate();
       
        $page->shop_id = $this->shopId;
        $this->view->page = $page;
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 请求 删除评论' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function deleteAction()
    {
        $this->csrfCheck();
        $id = $this->request->getPost( 'id', 'int' );
        $comment = GoodsTechanComments::findFirst( array( 'id=?0', 'bind' => array( $id ))  );
        
        if( $comment )
        {
            $status = $comment->update( array( 'delsign' => SystemEnums::DELSIGN_YES, 'uptime' => date( 'Y-m-d H:i:s'))); 
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
     * @comment( comment = 'ajax 请求 隐藏 显示评论' )	
     * @method( method = 'toggleAction' )
     * @op( op = 'u' )		
    */
    public function toggleAction()
    {
        $id = $this->request->getPost( 'id', 'int' );
        $toggle = $this->request->getPost( 'toggle', 'int' );
        $comment = GoodsTechanComments::findFirst( array( 'id=?0', 'bind' => array( $id )) );
    
        if( $comment )
        {
            $status = $comment->update( array( 'is_display' => $toggle, 'uptime' => date( 'Y-m-d H:i:s'))); 
            if( $status )
            {
                $this->success( '切换成功' );
            }
        }
        $this->error( '切换失败' );
    }
   
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '回复显示' )	
     * @method( method = 'replyAction' )
     * @op( op = '' )		
    */
    public function replyAction()
    {
        $id = $this->request->getQuery( 'id', 'int' );  //回复的id
        if( $id )
        {
            $phql = 'select c.id, c.addtime, c.serv_marks, c.goods_marks, c.comment,c.is_display, c.reply_content,c.reply_time,c.comment, ' . 
                    'm.username,g.name as goods_name ' .
                    'from \apps\admin\models\GoodsTechanComments as c ' .
                    'join apps\admin\models\MemMembers as m on c.mem_id = m.id  ' .
                    'join apps\admin\models\GoodsTechan as g on c.goods_id = g.id  where c.id=?0  limit 1';
           $comment =  $this->modelsManager->executeQuery($phql,  array( $id ) );

           if( $comment )
           {
               $this->view->comment = $comment->getFirst()->toArray();
           }
        }
      
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = 'ajax 保存回复' )	
     * @method( method = 'saveAction' )
     * @op( op = 'u' )		
    */
    public function saveAction()
    {
        $id = $this->request->getPost( 'id', 'int' );
        $replyContent = $this->request->getPost( 'replyContent', 'string' );
       
        $comment = GoodsTechanComments::findFirst( array( 'id=?0', 'bind' => array( $id ) ) );
    
        if( $comment )
        {
            $status = $comment->update( array( 'reply_content' => $replyContent, 'is_reply' => 1, 'reply_time' => date( 'Y-m-d H:i:s'))); 
            if( $status )
            {
                $this->success( '回复成功' );
            }
        }
        $this->error( '回复失败' );
    }
}
