<?php

namespace apps\admin\enums;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );
class OrderFlowEnums 
{
	const FLOW_ONLINE = 0;
	const FLOW_LAYPAY = 1;
	
	const FLOW_ONLINE_STATUS = array( 0 => array( 'tpl' => '', 'key' =>'', 'display' => 0, 'desc' => '' ),//
								1 => array( 'tpl' => '', 'key' => '' ),
								2 => array( 'tpl' => '', 'key' => '' ),
								3 => array( 'tpl' => '', 'key' => '' ),
								4 => array( 'tpl' => '', 'key' => '' ),
								5 => array( 'tpl' => '', 'key' => '' ),
								6 => array( 'tpl' => '', 'key' => '' ),
								7 => array( 'tpl' => '', 'key' => '' ),
								8 => array( 'tpl' => '', 'key' => '' ),
								9 => array( 'tpl' => '', 'key' => '' ),
								10 => array( 'tpl' => '', 'key' => '' ),
								);
	
	const FLOW_LAYPAY_STATUS = array( 0 => array( 'tpl' => '', 'key' =>'' ),
			1 => array( 'tpl' => '', 'key' => '' ),
			2 => array( 'tpl' => '', 'key' => '' ),
			3 => array( 'tpl' => '', 'key' => '' ),
			4 => array( 'tpl' => '', 'key' => '' ),
			5 => array( 'tpl' => '', 'key' => '' ),
			6 => array( 'tpl' => '', 'key' => '' ),
			7 => array( 'tpl' => '', 'key' => '' ),
			8 => array( 'tpl' => '', 'key' => '' ),
			9 => array( 'tpl' => '', 'key' => '' ),
			10 => array( 'tpl' => '', 'key' => '' ),
	);
}

?>