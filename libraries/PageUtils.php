<?php


namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class PageUtils
{

	/**
	 * 裁剪返回值
	 * @param 查询结果集 $res
	 * @param $pageVO
	 * @param 返回值 $strRetName
	 * 返回object or array
	 */
	public static function cutPage( $query, &$pageVO, $strRetName, $strRetType = 'object' )
	{
		$pageVO->recordCount = $query->num_rows();//记录总条数
		
		if( $pageVO->recordCount <= 0 )
		{
			$pageVO->pageCount = 0;
			$pageVO->pageNo = 1;
			$pageVO->$strRetName = array ();
			return;
		}
		
		if( $pageVO->pageSize <= 0 )//每页最大记录数
			$pageVO->pageSize = 10;
		
		if( $pageVO->pageNo > ceil( $pageVO->recordCount / $pageVO->pageSize ))//当前页数
		{
			$pageVO->pageNo = 1;
		}

		if( $pageVO->pageNo <= 0 )
			$pageVO->pageNo = 1;
		
		$iStart = ($pageVO->pageNo - 1) * $pageVO->pageSize;
		
		$pageVO->pageCount = ceil( $pageVO->recordCount / $pageVO->pageSize );//页数
		
		if( $pageVO->recordCount < $iStart )
		{
			$pageVO->$strRetName = array ();
			
			return;
		}
		
		$iCount = ($pageVO->pageNo * $pageVO->pageSize) > $pageVO->recordCount ? ( $pageVO->recordCount % $pageVO->pageSize ) : $pageVO->pageSize;
		
		$pageVO->curSize = $iCount;
		$pageVO->$strRetName = $query->result( $strRetType, $iStart, $iCount );
	
	}

	
}

?>