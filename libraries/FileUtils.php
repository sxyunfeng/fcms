<?php

namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class FileUtils
{

	function __construct( )
	{
	
	}

	public static function getFileExt( $strFileName )
	{
		$info = pathinfo( $strFileName );
		
		return $info['extension'];
	}
	
	/**
	 * 创建文件夹
	 * @param unknown $fname
	 * @return boolean
	 */
	public static function mkdir( $path, $fname )
	{
		if( false == $path || false == $fname )
			return false;
		
		if( is_dir( $path ) )
			mkdir( $path . $fname, 0777 );
	}
}

?>