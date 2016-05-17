<?php

namespace apps\admin\controllers;

use apps\admin\models\SystemDic;

/**
 * @comment( comment = '系统配置' )
 * @author(  author = 'hfc' )
 * @date ( date = '2015-8-28' )
 */
class ConfigController extends AdminBaseController
{
    public function initialize()
    {
        parent::initialize();
    }
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-31' )
     * @comment( comment = '支付的配置' )	
     * @method( method = 'payAction' )
     * @op( op = '' )		
    */
    public function seoAction()
    {
        $seo = SystemDic::find( 'kind="seo"' );
        
        if( $seo )
        {
            $this->view->seo = $seo->toArray();
        }
        
    }
    
     /**
     * @author( author='hfc' )
     * @date( date = '2015-8-31' )
     * @comment( comment = '支付的配置' )	
     * @method( method = 'seoSaveAction' )
     * @op( op = '' )		
    */
    public function seoSaveAction()
    {
        $key = $this->request->getPost( 'key' );
        $value = $this->request->getPost( 'value' );
        
        $data = array();
        $seos = SystemDic::find( 'kind="seo"' );
        foreach( $seos as $k => $seo )
        {
            $data[ $key[ $k ] ] = $value[ $k ];    
            $status = $seo->update( array( 'key' => $key[ $k], 'value' => $value[ $k ] ) );
        }
        if( $status )
        {
            //把数据保存到文件中
            $path = APP_ROOT . 'config/seo.php';

            file_put_contents( $path, '<?php return new \Phalcon\Config(' . var_export( $data, true ) . ');');
            $this->success( '更新成功' );
        }
        $this->error( '更新失败' );
    }
    
    /**
     * @author( author='hfc' )
     * @date( date = '2015-8-28' )
     * @comment( comment = '邮箱，消息等的配置' )	
     * @method( method = 'cmmAction' )
     * @op( op = '' )		
    */
    public function cmmAction()
    {
      
       $seo = SystemDic::find( 'kind="email"' );
        
        if( $seo )
        {
            $this->view->email = $seo->toArray();
        }
    }
    
     /**
     * @author( author='hfc' )
     * @date( date = '2015-8-28' )
     * @comment( comment = '邮箱保存' )	
     * @method( method = 'emailSaveAction' )
     * @op( op = '' )		
    */
    public function emailSaveAction()
    {
      
        $key = $this->request->getPost( 'key' );
        $value = $this->request->getPost( 'value' );
        
        $data = array();
        $seos = SystemDic::find( 'kind="email"' );
        foreach( $seos as $k => $seo )
        {
            $data[ $key[ $k ] ] = $value[ $k ];    
            $status = $seo->update( array( 'key' => $key[ $k], 'value' => $value[ $k ] ) );
        }
        if( $status )
        {
            //把数据保存到文件中
            $path = APP_ROOT . 'config/email.php';
            $str = "<?php !defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' ); \n return new \Phalcon\Config(";
            file_put_contents( $path,  $str . var_export( $data, true ) . ');');
            $this->success( '更新成功' );
        }
        $this->error( '更新失败' );
    }
}
