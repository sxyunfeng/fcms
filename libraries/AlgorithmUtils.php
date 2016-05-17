<?php
namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );
class AlgorithmUtils
{

	function __construct( )
	{
	
	}

	 
	public static function array_sort( $arr, $strKey, $type='asc' )
	{
		$keysvalue = $new_array = array ();
		foreach( $arr as $k => $v)
		{
			$keysvalue [$k] = $v [$strKey];
		}
		
		if( $type == 'asc' )
		{
			asort( $keysvalue );
		}
		else
		{
			arsort( $keysvalue );
		}
		
		reset( $keysvalue );
		
		foreach( $keysvalue as $k => $v)
		{
			$new_array [$k] = $arr [$k];
		}
		
		return $new_array;
	}
}

?>