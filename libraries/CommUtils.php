<?php
namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class CommUtils
{

	function __construct( )
	{
	
	}

	/**
	 * Generates an UUID with dash
	 * 32位+4
	 * @author     Anis uddin Ahmad <admin@ajaxray.com>
	 * @param      string  an optional prefix
	 * @return     string  the formatted uuid
	 */
	public static function UUIDMd5( $prefix = '' )
	{
		$chars = md5( uniqid( mt_rand(), true ) );
		$uuid = substr( $chars, 0, 8 ) . '-';
		$uuid .= substr( $chars, 8, 4 ) . '-';
		$uuid .= substr( $chars, 12, 4 ) . '-';
		$uuid .= substr( $chars, 16, 4 ) . '-';
		$uuid .= substr( $chars, 20, 12 );
		return $prefix . $uuid;
	
	}
	
	/**
	 * Generates an UUID with no dash
	 * 32位
	 * @author     Anis uddin Ahmad <admin@ajaxray.com>
	 * @param      string  an optional prefix
	 * @return     string  the formatted uuid
	 */
	public static function UUIDNoDash( $prefix = '' )
	{
		$chars = md5( uniqid( mt_rand(), true ) );
		
		return $prefix . $chars;
	
	}

	/**
	 * Generates a uniqe id
	 * 最多32位
	 * @author     Anis uddin Ahmad <admin@ajaxray.com>
	 * @param      string  an optional prefix
	 * @return     string  the formatted uuid
	 */
	public static function UNID( $prefix = '' )
	{
		$chars = uniqid( mt_rand(), true );
		$uuid = str_replace( '.', '', $chars );
		
		return $prefix . $uuid;
	
	}

	/**
	 * 取得指定长度的random num
	 * @param number $iLen
	 * @return string
	 */
	public static function getRandNum( $iLen = 8 )
	{
		$chars = substr( md5( uniqid( time(), true ) ), 0, 8);
		return substr( hexdec( $chars ), 0, 8 );
	}
	/**
	 * 取得函数签名
	 * @param string $strClsSerialID
	 * @param string $strClass
	 * @param string $strFunc
	 * @return string
	 */
	public static function getFuncSignature( $strClsSerialID, $strClass, $strFunc )
	{
		return $strClsSerialID . $strClass . $strFunc;
	}

	/**
	 * 判断用户是否使用微信登录
	 */
	public static function isWeChatLogin()
	{
		if( strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'MicroMessenger' ) !== false )
		{//
			return true;
		}
		
		return false;
	}
}


?>