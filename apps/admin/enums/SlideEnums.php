<?php

namespace apps\admin\enums;

class SlideEnums{
	
	/*------------幻灯片类型配置-------------*/
	//图片类型
	const SLIDE_TYPE_IMAGE = 1;
	//FLASE类型
	const SLIDE_TYPE_FLASH = 2;
	//图片类型
	const SLIDE_TYPE_VIDEO = 3;
	
	
	/*--------------是否限制宽高---------------*/
	//限制
	const SLIDE_LIMIT_YES = 1;
	//不限制
	const SLIDE_LIMIT_NO = 0;
	
	/*--------------幻灯片是否显示---------------*/
	//限制
	const SLIDE_SHOW_YES = 1;
	//不限制
	const SLIDE_SHOW_NO = 0;
	
}

?>