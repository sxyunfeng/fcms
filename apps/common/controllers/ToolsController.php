<?php
/**
 * 系统主框架以及公共显示区域
 * @author Bruce
 * time 2014-10-30
 */
namespace apps\common\controllers;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class ToolsController extends \Phalcon\Mvc\Controller
{
	public function initialize()
	{
	}
	
	/**
	 * @author( author='qzf' )
	 * @date( date = '?' )
	 * @comment( comment = '取验证码' )
	 * @method( method = 'getVerifyAction' )
	 * @op( op = 'r' )
	 */
	public function getVerifyAction( )
	{
		$iWidth = (( $iWidth = $this->dispatcher->getParam( 'w' )) != null ) ? $iWidth : 150;//width
		$iHeight = (( $iHeight = $this->dispatcher->getParam( 'h' )) != null ) ? $iHeight : 30;//height
		$iFontSize = (( $iFontSize = $this->dispatcher->getParam( 'fontsize' )) != null) ? $iFontSize : 18;//fontsize
		$bUseCurve = (( $bUseCurve = $this->dispatcher->getParam( 'curve' )) != null ) ? intval( $bUseCurve ) : true; //curve
		$bImg = (( $bImg = $this->dispatcher->getParam( 'image' )) != null ) ? intval( $bImg ) : false;//image
		$bNoise = (( $bNoise = $this->dispatcher->getParam( 'noise' )) != null ) ? intval( $bNoise ) : true;//noise
		$iLength = (( $iLength = $this->dispatcher->getParam( 'length' )) != null ) ? $iLength : 5;//length
		$id = (( $id = $this->dispatcher->getParam( 'id' )) != null ) ? $id : 1;
		
		$verify = $this->di->get( 'verify' );
		$verify->useImgBg = $bImg;
		$verify->fontSize = $iFontSize;
		$verify->useCurve = $bUseCurve;
		$verify->useNoise = $bNoise;
		$verify->imageH = $iHeight;
		$verify->imageW = $iWidth;
		$verify->length = $iLength;
		
		echo $verify->entry( $id );
	}
	
	/**
	 * @author( author='zlw' )
	 * @date( date = '2015.8.20' )
	 * @comment( comment = '扫描文件，解析方法注释并将其存入memcache中' )	
	 * @method( method = 'setCtrlCacheAction' )		
	 * @op( op = '' )		
	 */
	public function setCtrlCacheAction()
	{
		//控制器路径和命名空间
		$controller = array(
				'admin' => array(
						'controllerNameSpace' => \enums\LogEnums::ADMIN_CONTROLLER_NAMESPACE,
						'controllersDir' => APP_ROOT . \enums\LogEnums::ADMIN_CONTROLLER_PATH
				),
				'mem' => array(
						'controllerNameSpace' => \enums\LogEnums::MEM_CONTROLLER_NAMESPACE,
						'controllersDir' => APP_ROOT . \enums\LogEnums::MEM_CONTROLLER_PATH
				)
		);
		
		$reader = new \Phalcon\Annotations\Adapter\Memory();
		foreach( $controller as $key => $value )
		{
			$controllers = scandir( $value['controllersDir'] );
			if( !$controllers )
			{
				return;
			}
			
			$controllerNameSpace = $value['controllerNameSpace'];
			//遍历控制器
			foreach( $controllers as $con )
			{
				if( !$con || '.' == $con || '..' == $con )
				{
					continue;
				}
				
				//去后缀.php
				$con = explode( '.', $con );
				$controllerName = $con[0];
				//使用Annotations获取注释信息
				$reflector = $reader->get( $controllerNameSpace . $controllerName );
				
				//获取方法的注释信息
				$annotations = $reflector->getMethodsAnnotations();
				
				if( !$annotations )
				{
					continue;
				}
			
				//遍历方法注释
				foreach ($annotations as $annotation) 
				{
					$methodName = '';
					$item = array();
					$annoInfo = $annotation->getAnnotations();
					//逐条解析数据
					foreach( $annoInfo as $value )
					{
						$name = $value->getName();
						$anno = $value->getArguments();
						
						if( !$anno || !$name )
						{
							continue;
						}
						
						$item[$name] = $anno[$name];	
						( $name == 'method' ) && ( $methodName = $anno[$name] );
					}
					
					//该方法没有注释
					if( !$methodName && $item )
					{
						continue;
					}
					
					//默认缓存保存一天
					$this->memCache->save( $key . '_' . strtolower( $controllerName ) . '_' . 
							strtolower( $methodName ) . '_cache', $item, 86400 );
				}
			}
		}
	}
}























