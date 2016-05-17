<?php
namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use apps\admin\models\ArticleCats;
use apps\admin\models\Articles;
use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use libraries\TimeUtils;

/**
 * 文章
 * @author New
 * time 2015-12-24
 */

class ArticletrashController extends AdminBaseController
{
    
    public function initialize()
    {
        parent::initialize();
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2015-12-24' )
     * @comment( comment = '文章回收站主页' )
     * @method( method = 'index' )
     * @op( op = '' )
     */
    public function indexAction()
    {
        $pageNum = $this->dispatcher->getParam( 'page', 'int' );
        $currentPage = $pageNum ? $pageNum : 1;
        
    	$articles = Articles::find( array(
    		'conditions' => 'delsign=?0',
            'bind' => [ SystemEnums::DELSIGN_YES ],
    	) );
    	
    	$pagination = new PaginatorModel( array(
            'data'  => $articles,
            'limit' => 10,
            'page'  => $currentPage
    	) );
    	
    	$page = $pagination->getPaginate();
    	$this->view->page = $page;
    	
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2015-12-24' )
     * @comment( comment = '将文章delsign从1修改为0' )
     * @method( method = 'deleteOne' )
     * @op( op = 'r' )
     */
    public function recoverSelectAction()
    {
        $this->csrfCheck();
        
        $ids = $this->request->getPost( 'ids' );
        $type = $this->request->getPost( 'type' );
        if( false != $type && 'all' == $type )
        {
            $where = array(
                'conditions' => 'delsign=:del:',
                'bind'       => array( 'del' => SystemEnums::DELSIGN_YES ),
            );
        }
        else 
       {
           if( false == $ids || strlen( $ids ) < 0 )
           {
               $this->error( '参数错误', array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
           }
            $where = array(
                'conditions'    => 'delsign=:del: and id in (' . $ids . ')',
                'bind'          => array( 'del' => SystemEnums::DELSIGN_YES ),
            );
        }
        $articles = Articles::find( $where );
        if( false !=  $articles && count( $articles ) > 0 )
        {
            $arrIds = array();
            foreach( $articles as $row )
            {
                $row->delsign = SystemEnums::DELSIGN_NO;
                $row->uptime  = TimeUtils::getFullTime();
                $row->save();
                
                array_push( $arrIds , $row->id );
            }
            $this->success( '恢复成功', array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken(), 'optids' => $arrIds ) );
        }
        else 
       {
            $this->error( '恢复失败', array( 'csrfname' => $this->security->getTokenKey(), 'csrfval' => $this->security->getToken() ) );
        }
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2015-12-24' )
     * @comment( comment = '将回收站中的所有文章delsign从1修改为0' )
     * @method( method = 'deleteOne' )
     * @op( op = 'r' )
     */
    public function recoverAllAction()
    {
         
    }
    
}
