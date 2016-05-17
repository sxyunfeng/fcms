<?php
namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

/**
 * @author Bruce
 * date 2014-11-05
 */
class StringUtils
{
	/**
	 * trans html tags to plain text
	 * 
	 * @param string $strHtml
	 * @return string
	 */
	public static function transHtmlTagsToPlainText( $strHtml )
	{
		$strHtml = str_replace( '&nbsp;', ' ', $strHtml );
		$strHtml = str_replace( "<br>", "\r\n", $strHtml );
		$strHtml = strip_tags( $strHtml );
		
		return $strHtml;
	}
}

?>