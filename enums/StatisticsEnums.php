<?php

namespace enums;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

/**
 * 统计报表
 * @author Carey
 *
 */
class StatisticsEnums {
	
	
	/**
	 * 时间分割线
	 * 日	0
	 * 年	1
	 * 月	2
	 * 时	3
	 * 时间段 	4
	 */
	const UNIT_TYPE_DAY = 0;
	
	const UNIT_TYPE_YEAR = 1;
	
	const UNIT_TYPE_MONTH = 2;
	
	const UNIT_TYPE_HOUR = 3;
	
	const UNIT_TYPE_TIME_SEGMENT = 4;
	
	
	/**
	 * 年龄段分割
	 * 0 90后
	 * 1 80后
	 * 2 00后
	 * 3 70后
	 */
	const AGE_UNIT_NINE = 0;
	
	const AGE_UNIT_EIGHT = 1;

	const AGE_UNIT_ZERO = 2;
	
	const AGE_UNIT_SEVEN = 3;
	
	
	/**
	 * 商品到达来源
	 * 0	站内
	 * 1	广告
	 * 2	扫码
	 * 3	百度
	 * 4	搜狗
	 * 5	google
	 * 6	360
	 * ......
	 */
	
	const FROM_WEBSITE = 0;
	
	const FROM_ADS = 1;
	
	const FROM_SCAN_CODE = 2;
	
	const FROM_BAIDU = 3;
	
	const FROM_SOUGOU = 4;
	
	const FROM_GOOGLE = 5;
	
	const FROM_QIHU = 6;
	
	
}

?>