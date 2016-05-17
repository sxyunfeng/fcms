<?php
namespace enums;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class DBEnums {
	/**
	 * 数据库返回object
	 * Database result object
	 */
	const DB_RESULT_OBJECT = 'object';
	
	/**
	 * 数据库返回array
	 * Database result array
	 */
	const DB_RESULT_ARRAY = 'array';
	
	/**
	 * 数据库 排序
	 *
	 * asc
	 */
	const DB_SORT_ASC = 'asc';
	
	/**
	 * 数据库 排序
	 *
	 * desc
	 */
	const DB_SORT_DESC = 'desc';
}

?>