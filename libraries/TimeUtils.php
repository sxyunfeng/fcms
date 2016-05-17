<?php
namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

/**
 * 格式化时间工具类
 * @author Bruce
 * date 2014-11-05
 */
class TimeUtils
{

	function __construct( )
	{
	
	}
	
	/**
	 * 格式：2013-03-21 19：21：38 
	 */
	public static function getFullTime()
	{
		return date( 'Y-m-d H:i:s', $_SERVER[ 'REQUEST_TIME' ] );
	}
	
	/**
	 * 取以时间文件名
	 * @return string
	 */
	public static function getTimeFileName()
	{
		return date( 'Ymd', $_SERVER['REQUEST_TIME'] );
	}
	
	/**
	 * 取time search string
	 */
	public static function getTimeSearchStr( $timeFrom, $timeTo, $strKey )
	{
		$strSearch = ' ';
	
		if( $timeFrom != '' && $timeFrom != false && $timeTo != '' && $timeTo != false )
		{ //from to
			$strSearch .= ' ' . $strKey . ' between \'' . $timeFrom . '\' and \'' . $timeTo . '\'';
		}
		else if( $timeFrom != '' && $timeFrom != false && ( $timeTo == '' || $timeTo == false) )
		{ //from
			$strSearch .= '' . $strKey . ' > \'' . $timeFrom . '\'';
		}
		else if( $timeTo != '' && $timeTo != false && ($timeFrom == '' || $timeFrom != false) )
		{ //to
			$strSearch .=  '' . $strKey . ' <\'' . $timeTo . '\'';
		}
	
		return $strSearch;
	}
	
	/**
	 * get year
	 * format: 2014
	 * @return string
	 */
	public static function getYear()
	{
		return date( 'Y', $_SERVER[ 'REQUEST_TIME' ] );
	}

}

?>