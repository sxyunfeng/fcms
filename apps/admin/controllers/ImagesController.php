<?php

/**
 * 图片管理器
 *
 * @author hfc
 * @time 2015-8-11
 */

namespace apps\admin\controllers;

use enums\SystemEnums;
use MongoId;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

class ImagesController extends AdminBaseController
{
    private $mdb = null;
    
    public function initialize()
    {
        parent::initialize();
        $this->mdb = $this->mongodb->selectCollection( 'space' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '首页' )	
     * @method( method = 'indexAction' )
     * @op( op = 'r' )		
    */
    public function indexAction()
    {
        $pageNum = $this->dispatcher->getParam( 'page' );
        $currentPage = $pageNum ? $pageNum : 1; //默认当前页为 1 

        $pid = $this->dispatcher->getParam( 'pid' ); //当前的目录id ,为字符串类型
        $where[ 'pid' ] = $pid ? $pid : '0';
        $nav = $this->getParent( $where[ 'pid' ]);
        if( $nav )
        {
            $this->view->nav = $nav;
        }
        $where[ 'delsign' ] =  SystemEnums::DELSIGN_NO;
        $where[ 'shopid' ] = $this->shopId  ;

        $data =  iterator_to_array( $this->mdb ->find( $where )->sort( array( 'addtime' => -1 ) ) );

        $paginator = new PaginatorArray(
            array(
            "data" => $data,
            "limit" => 12,
            "page" => $currentPage
            )
        );
        $page = $paginator->getPaginate();

        if( $page )
        {
            $page->pid = $where[ 'pid' ];
            $this->view->page = $page;
        }

    }
    
    /**
     * 选择图片空间的图片
     */
    public function selectAction()
    {
        $this->indexAction();
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '获得目录下的图片' )	
     * @method( method = 'getFilesAction' )
     * @op( op = '' )		
    */
    public function getFilesAction()
    {
        $id = $this->request->getQuery( 'id', 'string' );
        $data[ 'images' ] = iterator_to_array( $this->mdb->find( array( 'pid' => $id, 'delsign' => SystemEnums::DELSIGN_NO )) );

        if( $data[ 'images'] )
        {
            $this->success( '打开目录成功', $data  );
        }
        else
        {
            $this->error( '打开目录失败' );
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '重命名 文件夹或者图片' )	
     * @method( method = 'renameAction' )
     * @op( op = 'u' )		
    */
    public function renameAction()
    {
        $id = $this->request->getPost( 'id', 'string' );
        $folderName = $this->request->getPost( 'folderName', 'string' );
  
        $where[ '_id' ] = ( object ) new MongoId( $id );
        $where[ 'shopid' ] =  $this->shopId ; //只可重命名自己的图片或者文件夹
        
        $ret = $this->mdb->update( $where, array( '$set' => array( 'original' => $folderName ) ) );
        if(  $ret[ 'updatedExisting']  )
        {
            $this->success( '重命名成功' );
        }
        else
        {
            $this->error( '重命名失败' );
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '新建文件夹' )	
     * @method( method = 'newFolderAction' )
     * @op( op = 'c' )		
    */
    public function newFolderAction()
    {
        $data[ 'pid' ] = $this->request->getPost( 'pid', 'string' ); //当前目录的id
        $data[ 'original' ] = $this->request->getPost( 'folderName', 'string' );
        $this->validation( $data );
        
        $data[ 'type' ] = '.';//代表是目录
        $data[ 'addtime' ] = $data[ 'uptime' ] = time();
        $data[ 'delsign' ] = 0;
        $data[ 'shopid' ] =  $this->shopId;
        
        $this->mdb->insert( $data );
        if( isset( $data[ '_id']) )
        {
            $this->success( '新建成功', $data );
        }
        else
        {
            $this->error( '新建失败' );
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '删除文件夹或者图片' )	
     * @method( method = 'deleteAction' )
     * @op( op = 'd' )		
    */
    public function deleteAction()
    {
        $id = $this->request->getPost( 'id', 'string' );
        $where[ '_id' ] = ( object ) new MongoId( $id );
        $where[ 'shopid' ] = intval( $this->shopId ); //只可删除自己的图片
        
        $ret = $this->mdb->update( $where, array( '$set' => array( 'delsign' => 1 )));
        if(  $ret[ 'updatedExisting']  )
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
     * @comment( comment = '删除多个文件夹或者图片' )	
     * @method( method = 'deleteMoreAction' )
     * @op( op = 'd' )		
    */
    public function deleteMoreAction()
    {
        $arrId = $this->request->getPost( 'id');

        foreach( $arrId as $id )
        {
            $aId[] = ( object ) new MongoId( $id );
        }
        $where[ '_id' ] =  array( '$in' => $aId );
        $where[ 'shopid' ] = intval( $this->shopId ); //只可删除自己的图片

        $ret = $this->mdb->update( $where, array( '$set' => array( 'delsign' => 1 )), array("multiple" => true)); //删除多个文件
        if(  $ret[ 'updatedExisting']  )
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
     * @comment( comment = '上传图片 页面显示' )	
     * @method( method = 'uploadAction' )
     * @op( op = '' )		
    */
    public function uploadAction()
    {
        $this->view->id = $this->request->getQuery( 'id', 'string' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '保存图片到数据库中' )	
     * @method( method = 'saveImageAction' )
     * @op( op = 'c' )		
    */
    public function saveImageAction()
    {
        $id = $this->request->getPost( 'pid', 'string' );
        $pid = $id ? $id : '0'; 
        if ($this->request->hasFiles() == true) {
            $config = include APP_ROOT . '/config/ueditor.php';
            
            foreach ($this->request->getUploadedFiles() as $file) {
                $root = $_SERVER[ 'DOCUMENT_ROOT' ];
                if( strpos( $root, 'public') == false )
                {
                    $root .= '/public';
                }
                $name = $file->getName();
               
                if( $config[ 'type'] )   //把数据放在fastdfs
                {
//                    include_once dirname( __DIR__ ). '/plugins/fastdfs_upload.php';
                    $arrFileInfo = $this->fastdfs->uploadFile( $file->getTempName(), $file->getExtension());

                    if( $arrFileInfo !== false )
                    {
                         $url = 'http://' . $arrFileInfo[ 'ip_addr' ] . '/' . $arrFileInfo[ 'group_name' ] . '/' . $arrFileInfo[ 'filename' ];
                    }
                }
                else
                {
                    
                    $url =  '/upload/image/space/' . $this->shopId . '/goods/' . $name;
                    $filePath = $root . $url;
                    
                    $dirname = dirname( $filePath );
                    if( !file_exists( $dirname ) && ! mkdir( $dirname, 777, true ))
                    {
                        $ret[ 'status' ] = 'error';
                        echo json_encode( $ret );
                        return;
                    }
                    $file->moveTo( $filePath );
                }
                
                $pos = strpos( $name, '.' );
                $original = substr( $name, 0, $pos );
                
                $data[ 'original' ] = $original;
                $data[ 'url' ] = $url;
                $data[ 'pid' ] = $pid;
                $data[ 'size' ] = $file->getSize();
                $data[ 'type'] = $file->getExtension();
                $data[ 'addtime' ] = $data[ 'uptime' ] = time();
                $data[ 'shopid' ] = $this->shopId;
                $data[ 'delsign' ] = 0;
                $this->mdb->insert( $data );

                $ret[ 'status' ] =  'success';
                echo json_encode( $ret );
            }
        }
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-24' )
     * @comment( comment = '对输入的数据进行验证' )	
     * @method( method = 'validation' )
     * @op( op = '' )		
    */
    private  function validation( $data = array() )
    {
        $validation = new Validation();
        $validation->add( 'original', new PresenceOf(array(
            'message' => '文件夹名必填'
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
     * 根据id，查找自己所有的父
     * param type $id
     */
    private function getParent( $id = '0' )
    {
        $ret = array();
        if( $id != '0' )
        {
            while(1)
            {
                $_id = (object) new \MongoId( $id );
                $data = iterator_to_array( $this->mdb->find( array( '_id' => $_id ))->fields( array( '_id' =>true, 'original' => true, 'pid' => true )));
                foreach( $data as $value )
                {
                    $parent = $value;
                }
                if( ! $parent )
                {
                    return $ret;
                }
              
                array_unshift( $ret, array( 'id' => $parent[ '_id'], 'original' => $parent[ 'original'] )) ;
                if( $parent[ 'pid' ] == '0' )
                {
                    break;
                }
                $id = $parent[ 'pid' ];
            }
        }
        return $ret;
    }
}
