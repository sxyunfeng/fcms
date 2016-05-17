<?php
namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class DirUtils
{

	function __construct( )
	{
	
	}

	/**
	 * Goofy 2011-11-30
	* getDir()去文件夹列表，getFile()去对应文件夹下面的文件列表,二者的区别在于判断有没有“.”后缀的文件，其他都一样
	*/
	
	//获取文件目录列表,该方法返回数组
	public static function getDir( $dir )
	{
		$dirArray [] = NULL;
		if( false != ($handle = opendir( $dir )) )
		{
			$i = 0;
			while ( false !== ($file = readdir( $handle )) )
			{
				//去掉"“.”、“..”以及带“.xxx”后缀的文件
				if( $file != "." && $file != ".." && ! strpos( 
						$file, "." ) )
				{
					$dirArray [$i] = $file;
					$i ++;
				}
			}
			//关闭句柄
			closedir( $handle );
		}
		return $dirArray;
	
	}

	/**
	 * 获取文件列表
	 * @param string $dir
	 */
	public static function getFile( $dir )
	{
		$fileArray [] = NULL;
		if( false != ($handle = opendir( $dir )) )
		{
			while ( false !== ($file = readdir( $handle )) )
			{
				//去掉"“.”、“..”以及带“.xxx”后缀的文件
				if( $file != "." && $file != ".." && strpos( 
						$file, "." ) )
				{
					$fileArray [] = $file;
				}
			}
			//关闭句柄
			closedir( $handle );
		}
		
		return $fileArray;
	
	}
	
	/**
	 * e.g. getSpecExtFiles( "./", 'php' );
	 * @param string $strDir
	 * @param string $strExt
	 */
	public function getSpecExtFiles( $strDir, $strExt )
	{
		$fileArray [] = NULL;
		if( false != ($handle = opendir( $strDir )) )
		{
			while ( false !== ($file = readdir( $handle )) )
			{
				//去掉"“.”、“..”以及带“.xxx”后缀的文件
				if( $file != "." && $file != ".." && strpos( $file, "." ) && 
						$strExt == mb_substr( $file, mb_strlen( $file ) - strlen( $strExt )))
				{
					$fileArray [] = $file;
				}
			}
			//关闭句柄
			closedir( $handle );
		}
		return $fileArray;
	}
	//
}

?>