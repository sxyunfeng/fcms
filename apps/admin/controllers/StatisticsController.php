<?php

namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\StatisticsEnums;
use enums\SystemEnums;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use apps\admin\models\MemMembers;
use apps\admin\models\StatMembers;
use apps\admin\models\StatAgeSegment;
use apps\admin\models\StatMember;
use apps\admin\models\StatOrders;
use apps\admin\models\StatAds;
use apps\admin\models\Ad;
use apps\admin\models\StatAd;
use apps\admin\models\StatGoodsAmt;
use apps\admin\models\StatGoodsSale;
use apps\admin\models\StatGoodsAff;
use apps\admin\models\GoodsTechan;
use apps\admin\models\StatGoodAmt;
use apps\admin\models\StatGoodSale;
use apps\admin\models\StatGoodAff;
use apps\admin\models\StatGoodsSource;
use apps\admin\models\StatGoodSource;
use apps\admin\models\Shops;
use apps\admin\models\StatUserDistrict;
use apps\admin\models\CommonDistrictDic;

/**
 * 统计中心
 * 
 * 默认以 天 为单位进行统计
 * @author Carey
 * time 2015-09-09
 */
class StatisticsController extends AdminBaseController{
    
	
	
	public $today;
	private $find = array( '-00',':00','00' );
	private $arrFind = array( '回族自治区','维吾尔自治区','壮族自治区','特别行政区','自治区','省','市' );
	
    public function initialize()
    {
    	parent::initialize();
		$this->today = date( 'Y-m-d' , strtotime( "-1 day" ) );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.11' )
     * @comment( comment = '会员统计中心 ' )
     * @method( method = 'statMemberAction' )
     * @op( op = 'r' )
     */
    public function statMemberAction()
    {
    	$format = date( 'Y-m' , strtotime( $this->today ) );
    	
    	// 日 会员信息统计
    	$userWhere = array(
    		'conditions'	=> 'delsign=:del: and unit=:unit: and p_time like :time: ',
    		'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => StatisticsEnums::UNIT_TYPE_DAY, 'time' => $format.'%' ),
    	);
    	$usersList = StatMembers::find( $userWhere );
    	$strXalias 		= '['; //坐标 x 轴数据
    	$strMemAdds 	= '['; //总会员增加
    	$strMemAmts		= '['; //会员消费总量
    	$strMaleAdds 	= '['; //男会员增加量
    	$strFemaleAdds 	= '['; //女会员增加 
    	if( count( $usersList ) > 0 )
    	{
    		foreach( $usersList as $row )
    		{
    			$strXalias 	.= '"' . date( 'd号' , strtotime( $row->p_time ) ) . '",';
    			$strMemAdds .= $row->mem_sum . ',';
    			$strMemAmts	.= $row->total_amt. ',';
    			$strMaleAdds.= intval( $row->mem_sum - $row->female_num ). ',';
    			$strFemaleAdds.= $row->female_num. ',';
    		}
    	}
    	else 
    	{
    		$strXalias 	.= 0;
    		$strMemAdds .= 0;
    		$strMemAmts	.= 0;
    		$strMaleAdds.= 0;
    		$strFemaleAdds.= 0;
    	}
    	$this->view->title = date( 'Y年m月', strtotime( $this->today ) );
    	$this->view->xalias		= rtrim( $strXalias , ',' ) . ']';
    	$this->view->memAdds	= rtrim( $strMemAdds , ',' ) . ']';
    	$this->view->amtAdds	= rtrim( $strMemAmts, ',' ) . ']';
    	$this->view->maleAdds	= rtrim( $strMaleAdds, ',' ) . ']';
    	$this->view->femaleAdds	= rtrim( $strFemaleAdds , ',' ) . ']';

    	
    	//会员年龄分布
    	$ageWhere = array(
    		'conditions'	=> 'delsign=:del: and unit=:unit: and p_time like :time:',
    		'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => StatisticsEnums::UNIT_TYPE_DAY, 'time' => $format.'%' ),
    	);
    	$agesList = StatAgeSegment::find( $ageWhere );
    	$strAgeAlias= '['; //时间线
    	$strAllMem 	= '['; //总人数
    	$strMidlife	= '['; //中年
    	$strYouth	= '['; //青年
    	$strPubertas= '['; //青少年
  		if( count( $agesList ) > 0 )
  		{
  			foreach( $agesList as $row )
  			{
  				$strAgeAlias	.= '"' . date( 'd号' , strtotime( $row->p_time ) ) . '",';
  				$strAllMem 		.=  $row->mem_num . ',';
  				$strMidlife		.= $row->midlife . ',';
  				$strYouth		.= $row->youth . ',';
  				$strPubertas	.= $row->pubertas . ',';
  			}
  		}
  		else
  		{
  			$strAgeAlias	.= 0;
  			$strAllMem 		.=  0;
  			$strMidlife		.= 0;
  			$strYouth		.= 0;
  			$strPubertas	.= 0;
  		}
    	$this->view->agexalias 	= rtrim( $strAgeAlias , ',' ) . ']';
    	$this->view->allmem 	= rtrim( $strAllMem , ',' ) . ']';
    	$this->view->midlife	= rtrim( $strMidlife , ',' ) . ']';
    	$this->view->youth		= rtrim( $strYouth , ',' ) . ']';
    	$this->view->pubertas	= rtrim( $strPubertas , ',' ) . ']';
    	
    	//会员区域分布
		$arrProInfo = array();
		$proWhere = array(
			'column'	=> 'id,name,level,upid',
			'conditions'=> 'level=:l: and upid=:pid:',
			'bind'		=> array( 'l' => 1,  'pid' => 0 ),
		);
		$pRes = CommonDistrictDic::find( $proWhere );
		$i=0;
		foreach( $pRes as $row )
		{
			$arrProInfo[$i][ 'id' ] = $row->id;
			$arrProInfo[$i][ 'name' ] = $row->name;
			$i++;
		}
    	$strMapsProvince = '['; //统计省
    	$arrData = array();
    	if( count( $arrProInfo ) > 0 )
    	{
    		foreach( $arrProInfo as $pinfo )
    		{
    			$pWhere = array(
    					'column'	=> 'id,delsign,province,p_num,percent,unit,p_time,',
    					'conditions'=> 'delsign=:del: and p_time like :time: and unit=:unit: and province=:provinceid: ORDER BY province,city ASC',
    					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'unit' => StatisticsEnums::UNIT_TYPE_DAY , 'time' => $this->today . '%', 'provinceid' => $pinfo['id'] ),
    			);
    			$pStats = StatUserDistrict::find( $pWhere );
    			$iPnumber = 0;
    			if( count( $pStats ) > 0 )
    			{
    				foreach( $pStats as $row )
    				{
    					$iPnumber += intval( $row->p_num );
    					$arrData[ 'province' ] = $iPnumber;
    				}
    				$strMapsProvince .= '{name:"'.trim(  str_replace( $this->arrFind,  '', $pinfo['name'] ) ). '",value:' . $iPnumber . '},'; 
    			}
    		}
    	}
    	$where = array(
    			'column'	=> 'id,delsign,province,city,p_num,percent,unit,p_time,',
    			'conditions'=> 'delsign=:del: and p_time like :time: and unit=:unit: ORDER BY province,city ASC',
    			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'unit' => StatisticsEnums::UNIT_TYPE_DAY , 'time' => $this->today . '%' ),
    	);
    	$res = StatUserDistrict::find( $where );
    	$strMapsData = '['; //统计市
    	if( count( $res ) > 0 )
    	{
    		$arrFinding= array( '省', '特别行政区'  );
    		foreach( $res as $row )
    		{
    			if( false != $row->city )
    			{
    				$strMapsData .= '{name:"'.trim( str_replace( $arrFinding , '', $row->city_info->name ) ). '",value:' . intval( $row->p_num ) . '},';
    				$arrData[ 'city' ] = $row->p_num;
    			}
    			else
    			{
    				$pWhere = array(
    						'column'	=> 'id,delsign,province,p_num,percent,unit,p_time,',
    						'conditions'=> 'delsign=:del: and p_time like :time: and unit=:unit: and province=:provinceid: ORDER BY province,city ASC',
    						'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'unit' => StatisticsEnums::UNIT_TYPE_DAY , 'time' => $this->today . '%', 'provinceid' => $row->province ),
    				);
    				$pStats = StatUserDistrict::find( $pWhere );
    				$iPnumber = 0;
    				if( count( $pStats ) > 0 )
    				{
    					foreach( $pStats as $mun )
    					{
    						$iPnumber += intval( $mun->p_num );
    					}
	    				$strMapsData .= '{name:"'.trim(  str_replace( $arrFinding,  '', $row->district->name ) ). '",value:' . $iPnumber . '},';
    				}
    			}
    		}
    	}
    	
    	rsort( $arrData );
    	if( !empty( $arrData ) && false != $arrData['province'][0] )
    	{
    		if( $arrData['province'][0] > 0 && $arrData['province'][0]< 1000 )
    			$max = 1000;
    		else if( $arrData['province'][0] >= 1000 && $arrData['province'][0] < 5000 )
    			$max = 5000;
    		else if( $arrData['province'][0] >= 5000 && $arrData['province'][0] < 10000 )
    			$max = 10000;
    		else if( $arrData['province'][0] >= 10000 && $arrData['province'][0]< 50000 )
    			$max = 50000;
    		else if( $arrData['province'][0] < 50000 )
    			$max = intval( ceil( $arrData['province'][0] ) );
    	}
    	else
    		$max = 1000;
    	$this->view->hMax = $max;
    	$this->view->pMap = rtrim( $strMapsProvince , ',' ) . ']';
    	$this->view->cMap = rtrim( $strMapsData , ',' ) . ']';
    	
    	//总会员个数
    	$arrWhere = array(
    		'conditions'	=> 'delsign=:del:',
    		'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO ),
    	);
    	$allUser = MemMembers::find( $arrWhere );
    	$this->view->allUserNum = count( $allUser );
    	
    	//女会员个数
    	$arrWhere = array(
    			'conditions'	=> 'delsign=:del: and gender=:gender: ',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'gender' => 1 ),
    	);
    	$allFemale = MemMembers::find( $arrWhere );
    	$this->view->allFemaleNum = count( $allFemale );
    	$this->view->allMaleNum	 = intval( count($allUser) - count( $allFemale ) );
    	
    	//删除会员
    	$arrWhere = array(
    			'conditions'	=> 'delsign=:del: and status=:status:',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO , 'status' => 2 ),
    	);
    	$delUser = MemMembers::find( $arrWhere );
    	$this->view->deluser = count( $delUser );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.11' )
     * @comment( comment = '统计不同期间所有会员增长率 ' )
     * @method( method = 'getUserDetailAction' )
     * @op( op = 'r' )
     */
    public function getUserDetailAction()
    {
    	$objRet = new \stdClass();
  		$timeStmp = $this->dispatcher->getParam( 'point' );
  		$timeType = $this->dispatcher->getParam( 'timeType' );
		if( false == $timeStmp )
		{
			$objRet->state = 1;
			$objRet->msg = '参数配置错误,请稍后再试';
			
			echo json_encode( $objRet );
			exit;
		}
		//通过 时间类型 + 时间点 方式取出所需要的数据
		if( $timeType != 1 )
			$where = array(
	    		'conditions'	=> 'delsign=:del: and unit=:unit: and p_time like :time: ORDER BY p_time ASC ',
				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType, 'time' => $timeStmp.'%' ),
	    	);
		else
			$where = array(
					'conditions'	=> 'delsign=:del: and unit=:unit: ORDER BY p_time ASC ',
					'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType ),
			);
  		$users = StatMembers::find( $where );
  		if( count( $users ) > 0 )
    	{
    		$arrXalias 		= array();
    		$arrMemAdds 	= array();
    		$arrMaleAdds 	= array();
    		$arrFemaleAdds 	= array();
    		foreach( $users as $row )
    		{
    			switch( $timeType )
    			{
    				case 1://年
    					$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    					$arrXalias[]	= $row->p_time . '年';
    				break;
    				case 2://月
    					$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    					$arrXalias[]	= $row->p_time . '月';
    				break;
    				case 3://时
    					$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    				break;
    				case 4://段
    					$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    				break;
    				case 0://天
    				default:
    					$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    				break;
    			}
    			$arrMemAdds[]	= $row->mem_sum;
    			$arrMaleAdds[]	= intval( $row->mem_sum - $row->female_num );
    			$arrFemaleAdds[]= $row->female_num;
    		}
    		$objRet->state = 0;
    		$objRet->xalias		= $arrXalias;
    		$objRet->memAdds	= $arrMemAdds;
    		$objRet->maleAdds	= $arrMaleAdds;
    		$objRet->femaleAdds	= $arrFemaleAdds;
    		switch( $timeType )
    		{
    			case 1://年
    				$objRet->title = '用户增长统计 (单位/年)';
    			break;
    			case 2://月
    				$objRet->title = $timeStmp.'年  用户增长统计 (单位/月)';
    			break;
    			case 3://时
    				$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户增长统计  (单位/小时)';
    			break;
    			case 4://段
    				$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户增长统计  (单位/时间段)';
    			break;
    			case 0://天
    			default:
    				$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 用户增长统计  (单位/天)';
    			break;
    		}
    	}
    	else
    	{
    		$objRet->state = 1;
    		$objRet->msg = '对不起, <strong>' . $timeStmp . '</strong> 暂无统计数据.' ;
    	}
    	
    	echo json_encode( $objRet );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.15' )
     * @comment( comment = '统计不同期间所有会员消费增长率 ' )
     * @method( method = 'getAmtDetailAction' )
     * @op( op = 'r' )
     */
    public function getAmtDetailAction()
    {
    	$objRet = new \stdClass();
    	$timeStmp = $this->dispatcher->getParam( 'point' );
    	$timeType = $this->dispatcher->getParam( 'timeType' );
    	if( false == $timeStmp )
    	{
    		$objRet->state = 1;
    		$objRet->msg = '参数配置错误,请稍后再试';
    			
    		echo json_encode( $objRet );
    		exit;
    	}
    	//通过 时间类型 + 时间点 方式取出所需要的数据
    	if( $timeType != 1 )
    		$where = array(
    			'conditions'	=> 'delsign=:del: and unit=:unit: and p_time like :time: ORDER BY p_time ASC ',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType, 'time' => $timeStmp.'%' ),
    		);
    	else
    		$where = array(
    			'conditions'	=> 'delsign=:del: and unit=:unit: ORDER BY p_time ASC',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType ),
    		);
    	$users = StatMembers::find( $where );
    	if( count( $users ) > 0 )
    	{
    		$arrXalias 		= array();
    		$arrMemAmts		= array();
    		foreach( $users as $row )
    		{
    			switch( $timeType )
    			{
    				case 1://年
    					$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    					$arrXalias[]	= $row->p_time . '年';
    				break;
    				case 2://月
    					$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    					$arrXalias[]	= $row->p_time . '月';
    				break;
    				case 3://时
    					$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    				break;
    				case 4://段
    					$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    				break;
    				case 0://天
    				default:
    					$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    				break;
    			}
    				$arrMemAdds[]	= $row->mem_sum;
    				$arrMemAmts[]	= $row->total_amt;
    				$arrMaleAdds[]	= intval( $row->mem_sum - $row->female_num );
    				$arrFemaleAdds[]= $row->female_num;
    		}
    		$objRet->state = 0;
    		$objRet->xalias		= $arrXalias;
    		$objRet->amtAdds	= $arrMemAmts;
    		switch( $timeType )
    		{
    			case 1://年
    				$objRet->title = '用户消费增长统计 (单位/年)';
    			break;
    			case 2://月
    				$objRet->title = $timeStmp. '年  用户消费增长统计 (单位/月)';
    			break;
    			case 3://时
    				$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户消费增长统计  (单位/小时)';
    			break;
    			case 4://段
    				$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户消费增长统计  (单位/时间段)';
    			break;
    			case 0://天
    			default:
    				$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 用户消费增长统计  (单位/天)';
    			break;
    		}
    	}
    	else
    	{
    		$objRet->state = 1;
    		$objRet->msg = '对不起, <strong>' . $timeStmp . '</strong> 暂无统计数据.' ;
    	}
    	
    	echo json_encode( $objRet );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.15' )
     * @comment( comment = '统计不同期间所有会员年龄段 ' )
     * @method( method = 'getAgeDetailAction' )
     * @op( op = 'r' )
     */
    public function getAgeDetailAction()
    {
    	$objRet = new \stdClass();
    	$timeStmp = $this->dispatcher->getParam( 'point' );
    	$timeType = $this->dispatcher->getParam( 'timeType' );
    	if( false == $timeStmp )
    	{
    		$objRet->state = 1;
    		$objRet->msg = '参数配置错误,请稍后再试';
    		 
    		echo json_encode( $objRet );
    		exit;
    	}
    	if( $timeType != 1 )
    		$where = array(
    				'conditions'	=> 'delsign=:del: and unit=:unit: and p_time like :time: ORDER BY p_time ASC ',
    				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType, 'time' =>$timeStmp.'%' ),
    		);
    	else
    		$where = array(
    				'conditions'	=> 'delsign=:del: and unit=:unit: ORDER BY p_time ASC',
    				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType ),
    		);
    	$agesList = StatAgeSegment::find( $where );
    	$arrAgeAlias	= array();
    	$arrAllMem 		= array();
    	$arrMidlife		= array();
    	$arrYouth		= array();
    	$arrPubertas	= array();
    	if( count( $agesList ) > 0 )
    	{
    		foreach( $agesList as $row )
    		{
    			switch( $timeType )
    			{
    				case 1://年
    					$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    					$arrAgeAlias[]	= $row->p_time . '年';
    				break;
    				case 2://月
    					$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    					$arrAgeAlias[]	= $row->p_time . '月';
    				break;
    				case 3://时
    					$arrAgeAlias[]	= date( 'H点' , strtotime( $row->p_time ) );
    				break;
    				case 4://段
    					$arrAgeAlias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    				break;
    				case 0://天
    				default:
    					$arrAgeAlias[]	= date( 'd号' , strtotime( $row->p_time ) );
    				break;
    			}
    			$arrAllMem[] 	=  $row->mem_num;
    			$arrMidlife[]	= $row->midlife;
    			$arrYouth[]		= $row->youth;
    			$arrPubertas[]	= $row->pubertas;
    		}
    		$objRet->state = 0;
    		$objRet->agexalias 	= $arrAgeAlias;
    		$objRet->allmem 	= $arrAllMem;
    		$objRet->midlife	= $arrMidlife;
    		$objRet->youth		= $arrYouth;
    		$objRet->pubertas	= $arrPubertas;
    		switch( $timeType )
    		{
    			case 1://年
    				$objRet->title = '用户年龄段增长统计 (单位/年)';
    			break;
    			case 2://月
    				$objRet->title = $timeStmp.'年  用户年龄段增长统计 (单位/月)';
    			break;
    			case 3://时
    				$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户年龄段增长统计  (单位/小时)';
    			break;
    			case 4://段
    				$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户年龄段增长统计  (单位/时间段)';
    			break;
    			case 0://天
    			default:
    				$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 用户年龄段增长统计  (单位/天)';
    			break;
    		}
    	}
    	else
    	{
    		$objRet->state = 1;
    		$objRet->msg = '对不起, <strong>' . $timeStmp . '</strong> 暂无统计数据.' ;
    	}
    	
    	echo json_encode( $objRet );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.29' )
     * @comment( comment = '用户区域 ' )
     * @method( method = 'getPitDetailAction' )
     * @op( op = 'r' )
     */
    public function getPitDetailAction()
    {
    	$objRet =  new \stdClass();
    	$timeStmp = $this->dispatcher->getParam( 'point' );
    	$timeType = $this->dispatcher->getParam( 'timeType' );
    	if( false == $timeStmp )
    	{
    		$objRet->state = 1;
    		$objRet->msg = '参数配置错误,请稍后再试';
    		 
    		echo json_encode( $objRet );
    		exit;
    	}
    	if( $timeType != 1 )
    		$where = array(
    				'conditions'	=> 'delsign=:del: and unit=:unit: and p_time like :time: ORDER BY p_time ASC ',
    				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType, 'time' =>$timeStmp.'%' ),
    		);
    	else
    		$where = array(
    				'conditions'	=> 'delsign=:del: and unit=:unit: ORDER BY p_time ASC',
    				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType ),
    		);
    	$res = StatUserDistrict::find( $where );
    	if( count( $res ) > 0 )
    	{
    		$arrData = array();
    		if( count( $res ) > 0 )
    		{
				$arrData = array();
				$i=0;
    			foreach( $res as $row )
    			{
    				$arrData[$i][ 'label' ] = $row->district->name;
    				$arrData[$i][ 'value' ] = $row->percent;
    				$i++;
    			}
    		}
    		$objRet->state = 0;
    		$objRet->data = $arrData;
    		$objRet->p_time = $timeStmp;
    	}
    	else
    	{
    		$objRet->state = 1;
    		$objRet->msg = '对不起, <strong>' . $timeStmp . '</strong> 暂无统计数据.' ;
    	}
    	
    	echo json_encode( $objRet );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.16' )
     * @comment( comment = '用户列表页面 ' )
     * @method( method = 'showUserListAction' )
     * @op( op = 'r' )
     */
    public function showUserListAction()
    {
    	$pageNum = $this->request->getQuery( 'page', 'int' );
    	$currentPage = $pageNum ? $pageNum : 1;
    	//用户列表
    	$arrWhere = array(
    			'conditions'	=> 'delsign=:del:',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO ),
    	);
    	$userList = MemMembers::find( $arrWhere );
    	$pagination = new PaginatorModel( array(
    			'data' => $userList,
    			'limit' => 15,
    			'page' => $currentPage
    	));
    	$page = $pagination->getPaginate();
    	
    	$this->view->page = $page;
    }
    
    
     /**
     * @author( author='Carey' )
     * @date( date = '2015.9.16' )
     * @comment( comment = '单用户消费金额曲线图 ' )
     * @method( method = 'getItemAmtAction' )
     * @op( op = 'r' )
     */
    public function getItemAmtAction()
    {
    	$objRet = new \stdClass();
    	
    	$uid = $this->dispatcher->getParam( 'uid' );
    	$timeStmp = $this->dispatcher->getParam( 'point' )?$this->dispatcher->getParam( 'point' ):date( 'Y-m' , strtotime( $this->today ) );
    	$timeType = $this->dispatcher->getParam( 'timeType' )?$this->dispatcher->getParam( 'timeType' ):0;
    	if( false == $uid || false == $timeStmp )
    	{
    		$objRet->state = 1;
    		$objRet->msg = '对不起,参数配置错误,请刷新后重试.';

    		echo json_encode( $objRet );
    		exit;
    	}
    	if( $timeType != 1 )
    		$where = array(
    			'conditions'	=> 'delsign=:del: and u_id=:sign: and unit=:unit: and p_time like :time: ORDER BY p_time ASC',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'sign' => $uid, 'unit' => $timeType, 'time' =>$timeStmp.'%' ),
    		);
    	else
    		$where = array(
    			'conditions'	=> 'delsign=:del: and u_id=:sign: and unit=:unit: ORDER BY p_time ASC',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'sign' => $uid, 'unit' => $timeType ),
    		);
    	$user = StatMember::find( $where );
    	$arrXalias 		= array();
    	$arrMemAmts		= array();
    	foreach( $user as $row )
    	{
    		switch( $timeType )
    		{
    			case 1://年
    				$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    				$arrXalias[]	= $row->p_time.'年';
    			break;
    			case 2://月
    				$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    				$arrXalias[]	= $row->p_time . '月';
    			break;
    			case 3://时
    				$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    			break;
    			case 4://段
    				$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    			break;
    			case 0://天
    			default:
    				$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    			break;
    		}
    		$arrMemAmts[]	= $row->total_amt;
    	}
    	$objRet->state = 0;
    	$objRet->xalias		= $arrXalias;
    	$objRet->amtAdds	= $arrMemAmts;
    	switch( $timeType )
    	{
    		case 1://年
    			$objRet->title = '用户消费金额增长统计 (单位/年)';
    		break;
    		case 2://月
    			$objRet->title = $timeStmp .'年  用户消费金额增长统计 (单位/月)';
    		break;
    		case 3://时
    			$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户消费金额增长统计  (单位/小时)';
    		break;
    		case 4://段
    			$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户消费金额增长统计  (单位/时间段)';
    		break;
    		case 0://天
    		default:
    			$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 用户消费金额增长统计  (单位/天)';
    		break;
    	}
    	
    	echo json_encode( $objRet );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.16' )
     * @comment( comment = '单用户订单量曲线图 ' )
     * @method( method = 'getItemAmtAction' )
     * @op( op = 'r' )
     */
    public function getItemOrderAction()
    {
    	$objRet = new \stdClass();
    	 
    	$uid = $this->dispatcher->getParam( 'uid' );
    	$timeStmp = $this->dispatcher->getParam( 'point' )?$this->dispatcher->getParam( 'point' ):date( 'Y-m' , strtotime( $this->today ) );
    	$timeType = $this->dispatcher->getParam( 'timeType' )?$this->dispatcher->getParam( 'timeType' ):0;
    	if( false == $uid || false == $timeStmp )
    	{
    		$objRet->state = 1;
    		$objRet->msg = '对不起,参数配置错误,请刷新后重试.';
    
    		echo json_encode( $objRet );
    		exit;
    	}
    	if( $timeType != 1 )
    		$where = array(
    			'conditions'	=> 'delsign=:del: and u_id=:sign: and unit=:unit: and p_time like :time: ORDER BY p_time ASC ',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'sign' => $uid, 'unit' => $timeType, 'time' =>$timeStmp.'%' ),
    		);
    	else
    		$where = array(
    			'conditions'	=> 'delsign=:del: and u_id=:sign: and unit=:unit: ORDER BY p_time ASC',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'sign' => $uid, 'unit' => $timeType ),
    		);
    	$user = StatMember::find( $where );
    	$arrXalias 		= array();
    	$arrOrders		= array();
    	foreach( $user as $row )
    	{
    		switch( $timeType )
    		{
    			case 1://年
    				$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    				$arrXalias[]	= $row->p_time.'年';
    			break;
    			case 2://月
    				$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    				$arrXalias[]	= $row->p_time.'月';
    			break;
    			case 3://时
    				$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    			break;
    			case 4://段
    				$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    			break;
    			case 0://天
    			default:
    				$arrXalias[]	= date( 'd日' , strtotime( $row->p_time ) );
    			break;
    		}
    		$arrOrders[]	= $row->order_num;
    	}
    	$objRet->state = 0;
    	$objRet->xalias		= $arrXalias;
    	$objRet->orderAdds	= $arrOrders;
    	switch( $timeType )
    	{
    		case 1://年
    			$objRet->title = '用户订单量增长统计 (单位/年)';
    		break;
    		case 2://月
    			$objRet->title = $timeStmp .'年  用户订单量增长统计 (单位/月)';
    		break;
    		case 3://时
    			$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户订单量增长统计  (单位/小时)';
    		break;
    		case 4://段
    			$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户订单量增长统计  (单位/时间段)';
    		break;
    		case 0://天
    		default:
    			$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 用户订单量增长统计  (单位/天)';
    		break;
    	}
    	
    	echo json_encode( $objRet );
    }
    
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.16' )
     * @comment( comment = ' 广告统计中心 ' )
     * @method( method = 'statAdsAction' )
     * @op( op = 'r' )
     */
    public function statAdsAction()
    {
    	//总广告数
    	$where = array(
    		'column'	=> 'id,name,delsign,addtime',
    		'conditions'=> 'delsign=:del:',
    		'bind'		=> array( 'del'=> SystemEnums::DELSIGN_NO ),
    	);
    	$allAds = Ad::find( $where );
    	$this->view->all = count( $allAds );
    	//商家广告数
    	$shopWhere = array(
    		'column'	=> 'id,name,delsign,addtime',
    		'conditions'=> 'delsign=:del: and shopid <> 0',
    		'bind'		=> array( 'del'=> SystemEnums::DELSIGN_NO ),
    	);
    	$shopAds = Ad::find( $shopWhere );
    	$this->view->shopad = count( $shopAds );
    	$this->view->selfad = intval( count( $allAds ) - count( $shopAds ) );
    	//展示个数
    	$showWhere = array(
    			'column'	=> 'id,name,delsign,addtime',
    			'conditions'=> 'delsign=:del: and enabled=:show:',
    			'bind'		=> array( 'del'=> SystemEnums::DELSIGN_NO, 'show' => 1 ),
    	);
    	$showAds = Ad::find( $showWhere );
    	$this->view->isShow = count( $showAds );
    	
    	$format = date( 'Y-m' , strtotime( $this->today ) );
    	//日  广告点击率 以及 点击广告男女比例
    	$where = array(
    		'conditions'	=> 'delsign =:del: and unit=:unit: and p_time like :time: ORDER BY p_time ASC',
    		'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO , 'unit' => StatisticsEnums::UNIT_TYPE_DAY, 'time' => $format . '%' ),
    	);
    	$ads = StatAds::find( $where );
    	$strAdsAlias	= '['; 
    	$strClickNum	= '[';
    	$strAllMem 		= '[';
    	$strAllFemale	= '[';
    	$strAllMale		= '[';
    	if( count( $ads ) > 0 )
    	{
    		foreach( $ads as $row )
    		{
    			$strAdsAlias	.= '"' . date( 'd号' , strtotime( $row->p_time ) ) . '",';
    			$strClickNum	.= $row->click_num . ',';
    			$strAllMem 		.= $row->all_mem . ',';
    			$strAllFemale	.= $row->female_num . ',';
    			$strAllMale		.= intval( $row->all_mem - $row->female_num ) . ',';
    		}
    	}
    	$this->view->title		= date( 'Y年m月d日', strtotime( $this->today ) );
    	$this->view->xalias 	= rtrim( $strAdsAlias , ',' ) . ']';
    	$this->view->click_num	= rtrim( $strClickNum , ',' ) . ']';
    	$this->view->allmem 	= rtrim( $strAllMem , ',' ) . ']';
    	$this->view->female		= rtrim( $strAllFemale , ',' ) . ']';
    	$this->view->male		= rtrim( $strAllMale , ',' ) . ']';
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.17' )
     * @comment( comment = '获取指定时间点的广告统计信息' )
     * @method( method = 'getAdsPointAction' )
     * @op( op = 'r' )
     */
    public function getAdsPointAction()
    {
    	$objRet = new \stdClass();
    	$type = $this->dispatcher->getParam( 'type' );
    	$timeStmp = $this->dispatcher->getParam( 'point' )?$this->dispatcher->getParam( 'point' ):date( 'Y-m' , strtotime( $this->today ) );
    	$timeType = $this->dispatcher->getParam( 'timeType' )?$this->dispatcher->getParam( 'timeType' ):0;
    	if( false == $type || false == $timeStmp )
    	{
    		$objRet->state = 1;
    		$objRet->msg = '对不起,参数配置错误,请刷新后重试.';
    	
    		echo json_encode( $objRet );
    		exit;
    	}
    	if( $timeType != 1 )
    		$where = array(
    			'conditions'	=> 'delsign=:del: and unit=:unit: and p_time like :time: ORDER BY p_time ASC ',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType, 'time' =>$timeStmp.'%' ),
    		);
    	else
    		$where = array(
    			'conditions'	=> 'delsign=:del: and unit=:unit: ORDER BY p_time ASC ',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType ),
    		);
    	$ads = StatAds::find( $where );
    	if( count( $ads ) > 0 )
    	{
    		$arrXalias 		= array();
    		$arrAdsClick	= array();
    		$arrMems		= array();
    		$arrFemale		= array();
    		$arrMale		= array();
    		foreach( $ads as $row )
    		{
    			switch( $timeType )
    			{
    				case 1://年
    					$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    					$arrXalias[]	= $row->p_time . '年';
    				break;
    				case 2://月
    					$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    					$arrXalias[]	= $row->p_time . '月';
    				break;
    				case 3://时
    					$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    				break;
    				case 4://段
    					$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    				break;
    				case 0://天
    				default:
    					$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    				break;
    			}
    			$arrAdsClick[]	= $row->click_num;
    			$arrMems[] 		= $row->all_mem ;
    			$arrFemale[]	= $row->female_num;
    			$arrMale[]		= intval( $row->all_mem - $row->female_num );
    		}
    		$objRet->state = 0;
    		$objRet->xalias = $arrXalias;
    		if( 'all' == $type )
    		{
    			$objRet->click = $arrAdsClick;
    			switch( $timeType )
    			{
    				case 1://年
    					$objRet->title = '广告点击率增长统计 (单位/年)';
    				break;
    				case 2://月
    					$objRet->title = $timeStmp.'年  广告点击率增长统计 (单位/月)';
    				break;
    				case 3://时
    					$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 广告点击率增长统计  (单位/小时)';
    				break;
    				case 4://段
    					$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 广告点击率增长统计  (单位/时间段)';
    				break;
    				case 0://天
    				default:
    					$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 广告点击率增长统计  (单位/天)';
    				break;
    			}
    		}
    		else if( 'gender' == $type )
    		{
    			$objRet->mems 	= $arrMems;
    			$objRet->female = $arrFemale;
    			$objRet->male	= $arrMale;
    			
    			switch( $timeType )
    			{
    				case 1://年
    					$objRet->title = '用户订单量增长统计 (单位/年)';
    				break;
    				case 2://月
    					$objRet->title =  date( 'Y年', strtotime( $timeStmp ) ) .' 用户点击广告统计信息 (单位/月)';
    				break;
    				case 3://时
    					$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户点击广告统计信息  (单位/小时)';
    				break;
    				case 4://段
    					$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户点击广告统计信息  (单位/时间段)';
    				break;
    				case 0://天
    				default:
    					$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 用户点击广告统计信息  (单位/天)';
    				break;
    			}
    		}
    	}
    	else
    	{
    		$objRet->state = 1;
    		$objRet->msg = '对不起,   <strong>' . $timeStmp . '</strong>  暂无统计数据.' ;
    	}
    	
    	echo json_encode( $objRet );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.16' )
     * @comment( comment = '单广告列表页面' )
     * @method( method = 'getItemAmtAction' )
     * @op( op = 'r' )
     */
    public function showAdListAction()
    {
    	$pageNum = $this->request->getQuery( 'page', 'int' );
    	$currentPage = $pageNum ? $pageNum : 1;
    	$arrWhere = array(
    			'conditions'	=> 'delsign=:del: ',
    			'order'			=> 'uptime,weight,sort_order desc',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO ),
    	);
    	$adsList = Ad::find( $arrWhere );
    	$pagination = new PaginatorModel( array(
    			'data' => $adsList,
    			'limit' => 15,
    			'page' => $currentPage
    	));
    	$page = $pagination->getPaginate();
    	$this->view->page = $page;
    	
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.17' )
     * @comment( comment = '单广告点击率以及时间点点击率' )
     * @method( method = 'getItemClickAction' )
     * @op( op = 'r' )
     */
    public function getItemClickAction()
    {
    	$objRet = new \stdClass();
    	$iID	= $this->dispatcher->getParam( 'uid' );
    	$timeStmp = $this->dispatcher->getParam( 'point' )?$this->dispatcher->getParam( 'point' ):date( 'Y-m' , strtotime( $this->today ) );
    	$timeType = $this->dispatcher->getParam( 'timeType' )?$this->dispatcher->getParam( 'timeType' ):0;
    	if( false == $iID || false == $timeStmp )
    	{
    		$objRet->state = 1;
    		$objRet->msg = '对不起,参数配置错误,请刷新后重试.';
    	
    		echo json_encode( $objRet );
    		exit;
    	}
    	if( $timeType != 1 )
    		$where = array(
    			'conditions'	=> 'delsign=:del: and a_id=:sign: and unit=:unit: and p_time like :time: ORDER BY p_time ASC ',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'sign' => $iID, 'unit' => $timeType, 'time' =>$timeStmp.'%' ),
    		);
    	else
    		$where = array(
    			'conditions'	=> 'delsign=:del: and a_id=:sign: and unit=:unit: ORDER BY p_time ASC',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'sign' => $iID, 'unit' => $timeType ),
    		);
    	$ad = StatAd::find( $where );
    	$arrXalias 		= array();
    	$arrClicks		= array();
    	foreach( $ad as $row )
    	{
    		switch( $timeType )
    		{
    			case 1://年
    				$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    				$arrXalias[]	= $row->p_time . '年';
    			break;
    			case 2://月
    				$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    				$arrXalias[]	= $row->p_time . '月';
    			break;
    			case 3://时
    				$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    			break;
    			case 4://段
    				$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    			break;
    			case 0://天
    			default:
    				$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    			break;
    		}
    		$arrClicks[]	= $row->click_num;
    	}
    	$objRet->state = 0;
    	$objRet->xalias	= $arrXalias;
    	$objRet->click	= $arrClicks;
    	switch( $timeType )
    	{
    		case 1://年
    			$objRet->title = '广告点击率增长统计 (单位/年)';
    		break;
    		case 2://月
    			$objRet->title = $timeStmp .'年   广告点击率增长统计 (单位/月)';
    		break;
    		case 3://时
    			$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 广告点击率增长统计  (单位/小时)';
    		break;
    		case 4://段
    			$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 广告点击率增长统计  (单位/时间段)';
    		break;
    		case 0://天
    		default:
    			$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 广告点击率增长统计  (单位/天)';
    		break;
    	}
    	
    	echo json_encode( $objRet );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.17' )
     * @comment( comment = '单广告点男女点击比例以及时间点点击率' )
     * @method( method = 'getItemClickAction' )
     * @op( op = 'r' )
     */
    public function getItemGenderAction()
    {
    	$objRet = new \stdClass();
    	$iID	= $this->dispatcher->getParam( 'uid' );
    	$timeStmp = $this->dispatcher->getParam( 'point' )?$this->dispatcher->getParam( 'point' ):date( 'Y-m' , strtotime( $this->today ) );
    	$timeType = $this->dispatcher->getParam( 'timeType' )?$this->dispatcher->getParam( 'timeType' ):0;
    	if( false == $iID || false == $timeStmp )
    	{
    		$objRet->state = 1;
    		$objRet->msg = '对不起,参数配置错误,请刷新后重试.';
    		 
    		echo json_encode( $objRet );
    		exit;
    	}
    	
    	if( $timeType != 1 )
    		$where = array(
    				'conditions'	=> 'delsign=:del: and a_id=:sign: and unit=:unit: and p_time like :time: ORDER BY p_time ASC ',
    				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'sign' => $iID, 'unit' => $timeType, 'time' =>$timeStmp.'%' ),
    		);
    	else
    		$where = array(
    				'conditions'	=> 'delsign=:del: and a_id=:sign: and unit=:unit: ORDER BY p_time ASC ',
    				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'sign' => $iID, 'unit' => $timeType ),
    		);
    	$ad = StatAd::find( $where );
    	$arrXalias 		= array();
    	$arrMemAll		= array();
    	$arrFemale		= array();
    	$arrMale		= array();
    	foreach( $ad as $row )
    	{
    		switch( $timeType )
    		{
    			case 1://年
    				$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    				$arrXalias[]	= $row->p_time .'年';
    			break;
    			case 2://月
    				$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    				$arrXalias[]	= $row->p_time . '月';
    			break;
    			case 3://时
    				$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    			break;
    			case 4://段
    				$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    			break;
    			case 0://天
    			default:
    				$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    			break;
    		}
    	
    		$arrMemAll[]	= $row->all_mem;
    		$arrFemale[]	= $row->female_num;
    		$arrMale[]		= intval( $row->all_mem - $row->female_num );
    	}
    	$objRet->state = 0;
    	$objRet->xalias	= $arrXalias;
    	$objRet->mem_num = $arrMemAll;
    	$objRet->female = $arrFemale;
    	$objRet->male	= $arrMale;
    	switch( $timeType )
    	{
    		case 1://年
    			$objRet->title = '用户订单量增长统计 (单位/年)';
    		break;
    		case 2://月
    			$objRet->title = $timeStmp .'年   用户订单量增长统计(单位/月)';
    		break;
    		case 3://时
    			$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户订单量增长统计 (单位/小时)';
    		break;
    		case 4://段
    			$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 用户订单量增长统计 (单位/时间段)';
    		break;
    		case 0://天
    		default:
    			$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 用户订单量增长统计  (单位/天)';
    		break;
    	}
    	
    	echo json_encode( $objRet );
    }
    
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.16' )
     * @comment( comment = '总订单统计页面' )
     * @method( method = 'statOrderAction' )
     * @op( op = 'r' )
     */
    public function statOrderAction()
    {
    	$format = date( 'Y-m' , strtotime( $this->today ) );
    	
    	//日  订单量 以及 订单总额
    	$where = array(
    		'conditions'=> 'delsign=:del: and unit=:unit: and p_time like :time: ORDER BY p_time ASC',
    		'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'unit' => StatisticsEnums::UNIT_TYPE_DAY , 'time' => $format . '%' ),
    	);
    	$orders = StatOrders::find( $where );
    	$strXalias 		= '[';
    	$strOrderAmt 	= '[';
    	$strOrderAdds	= '[';
    	if( count( $orders ) > 0 )
    	{
    		foreach( $orders as $row )
    		{
    			$strXalias 	.= '"' . date( 'd日' , strtotime( $row->p_time ) ) . '",';
    			$strOrderAmt.= $row->order_amt. ',';
    			$strOrderAdds.= $row->order_num. ',';
    		}
    	}
    	$this->view->title = date( 'Y年m月', strtotime( $this->today ) );
    	$this->view->xalias		= rtrim( $strXalias , ',' ) . ']';
    	$this->view->ordersAmt	= rtrim( $strOrderAmt, ',' ) . ']';
    	$this->view->ordersAdds	= rtrim( $strOrderAdds , ',' ) . ']';
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.17' )
     * @comment( comment = '获取不同时间段订单增长率以及订单总额' )
     * @method( method = 'getPointOrderAction' )
     * @op( op = 'r' )
     */
    public function getPointOrderAction()
    {
    	$objRet = new \stdClass();
    	
    	$type = $this->dispatcher->getParam( 'type' );
    	$timeStmp = $this->dispatcher->getParam( 'point' )?$this->dispatcher->getParam( 'point' ):date( 'Y-m' , strtotime( $this->today ) );
    	$timeType = $this->dispatcher->getParam( 'timeType' )?$this->dispatcher->getParam( 'timeType' ):0;
    	if( false == $type || false == $timeStmp )
    	{
    		$objRet->state = 1;
    		$objRet->msg = '对不起,参数配置错误,请刷新后重试.';
    	
    		echo json_encode( $objRet );
    		exit;
    	}
    	if( $timeType != 1 )
    		$where = array(
    				'conditions'	=> 'delsign=:del: and unit=:unit: and p_time like :time: ORDER BY p_time ASC',
    				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType, 'time' =>$timeStmp.'%' ),
    		);
    	else
    		$where = array(
    			'conditions'	=> 'delsign=:del: and unit=:unit: ORDER BY p_time ASC',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType ),
    		);
    	$orders = StatOrders::find( $where );
    	if( count( $orders ) > 0 )
    	{
    		$arrXalias 	= array();
    		$arrDatas	= array();
    		foreach( $orders as $row )
    		{
    			switch( $timeType )
    			{
    				case 1://年
    					$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    					$arrXalias[]	= $row->p_time . '年';
    				break;
    				case 2://月
    					$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    					$arrXalias[]	= $row->p_time . '月';
    				break;
    				case 3://时
    					$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    				break;
    				case 4://段
    					$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    				break;
    				case 0://天
    				default:
    					$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    				break;
    			}
    			if( 'amt' == $type )
	    			$arrDatas[]	= $row->order_amt;
    			else if( 'num' == $type )
    				$arrDatas[]	= $row->order_num;
    		}
	    	$objRet->state = 0;
	    	$objRet->xalias		= $arrXalias;
	    	$objRet->datas		= $arrDatas;
	    	if( 'amt' == $type )
	    	{
	    		switch( $timeType )
	    		{
	    			case 1://年
	    				$objRet->title = '订单总销售金额统计 (单位/年)';
	    			break;
	    			case 2://月
	    				$objRet->title = $timeStmp.'年   订单总销售金额统计 (单位/月)';
	    			break;
	    			case 3://时
	    				$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 订单总销售金额统计  (单位/小时)';
	    			break;
	    			case 4://段
	    				$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 订单总销售金额统计  (单位/时间段)';
	    			break;
	    			case 0://天
	    			default:
	    				$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 订单总销售金额统计  (单位/天)';
	    			break;
	    		}
	    	}
	    	else if( 'num' == $type )
	    	{
	    		switch( $timeType )
	    		{
	    			case 1://年
	    				$objRet->title = '订单总销量增长统计 (单位/年)';
	    			break;
	    			case 2://月
	    				$objRet->title = $timeStmp.'年  订单总销量增长统计(单位/月)';
	    			break;
	    			case 3://时
	    				$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 订单总销量增长统计 (单位/小时)';
	    			break;
	    			case 4://段
	    				$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 订单总销量增长统计  (单位/时间段)';
	    			break;
	    			case 0://天
	    			default:
	    				$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 订单总销量增长统计 (单位/天)';
	    			break;
	    		}
	    	}
    	}
	    else
	    {
	    	$objRet->state = 1;
	    	$objRet->msg = '对不起,  <strong>' . $timeStmp . '</strong>  暂无统计数据.' ;
	    }
	    
	    echo json_encode( $objRet );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.17' )
     * @comment( comment = '商品统计' )
     * @method( method = 'statGoodsAction' )
     * @op( op = 'r' )
     */
    public function statGoodsAction()
    {
		$format = date( 'Y-m' , strtotime( $this->today ) );
		$where = array(
			'conditions'	=> 'delsign=:del: and unit = :unit: and p_time like :time: ORDER BY p_time ASC',
			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO , 'unit' => StatisticsEnums::UNIT_TYPE_DAY, 'time' => $format . '%' ),
		);
		
		//销售总金额
		$goodsAmtList = StatGoodsAmt::find( $where );
		$strXalias 		= '['; //坐标 x 轴数据
		$strGoodsAmt 	= '[';
		if( count( $goodsAmtList ) > 0 )
		{
			foreach( $goodsAmtList as $row )
			{
				$strXalias 	.= '"' . date( 'd号' , strtotime( $row->p_time ) ) . '",';
				$strGoodsAmt .= $row->goods_amt . ',';
			}
		}
		$this->view->title 		= date( 'Y年m月d日', strtotime( $this->today ) );
		$this->view->xalias		= rtrim( $strXalias , ',' ) . ']';
		$this->view->amtadds	= rtrim( $strGoodsAmt , ',' ) . ']';
		
		//销售总量趋势
		$goodsNumList = StatGoodsSale::find( $where );
		$strGoodsSale = '[';
		if( count( $goodsNumList ) > 0 )
		{
			foreach( $goodsNumList as $row )
			{
				$strGoodsSale .= $row->goods_total . ',';
			}
		}
		$this->view->saleadds	= rtrim( $strGoodsSale , ',' ) . ']';
		
		//浏览量 + 收藏量 + 好评率
		$res = StatGoodsAff::find( $where );
		$strGlance		= '[';
		$strCollect		= '[';
		$strFavourite	= '[';
		if( count( $res ) > 0 )
		{
			foreach( $res as $row )
			{
				$strGlance  .= $row->glance . ',';
				$strCollect .= $row->collect . ',';
				$strFavourite.= $row->favourite . ',';
			}
		}
		$this->view->glance		= rtrim( $strGlance , ',' ) . ']';
		$this->view->collect	= rtrim( $strCollect , ',' ) . ']';
		$this->view->favourite	= rtrim( $strFavourite , ',' ) . ']';
		
		//来源
		$source = StatGoodsSource::find( $where );
		$strBaidu  = '[';
		$strSougou = '[';
		$strGoogle = '[';
		$strQihu   = '[';
		if( count( $source ) > 0 )
		{
			foreach( $source as $row )
			{
				$strBaidu  .= $row->baidu . ',';
				$strSougou .= $row->sougou . ',';
				$strGoogle .= $row->google . ',';
				$strQihu   .= $row->qihu . ',';
			}
		}
		$this->view->baidu	= rtrim( $strBaidu , ',' ) . ']';
		$this->view->sougou	= rtrim( $strSougou , ',' ) . ']';
		$this->view->google	= rtrim( $strGoogle , ',' ) . ']';
		$this->view->qihu	= rtrim( $strQihu , ',' ) . ']';
		
		// 商品总数   入住商家数   线上商品   下架商品
		$where = array(
			'column' => 'id,name,delsign',
		);
		$goods = GoodsTechan::find( $where );
		$this->view->goods = count( $goods );
		
		$sWhere = array(
			'column'	=> 'id,delsign,name',
			'conditions'=> 'delsign=:del:',
			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO )
		);
		$shops = Shops::find( $sWhere );
		$this->view->shops = count( $shops );
		
		$upWhere = array(
				'column' => 'id,name,delsign',
				'conditions'=> 'delsign=:del:',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO )
		);
		$lineup = GoodsTechan::find( $upWhere );
		$this->view->lineup = count( $lineup );
		
		$downWhere = array(
				'column' => 'id,name,delsign',
				'conditions'=> 'delsign=:del:',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_YES )
		);
		$linedown = GoodsTechan::find( $downWhere );
		$this->view->linedown = count( $linedown );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.18' )
     * @comment( comment = '获取不同时间段商品统计数据' )
     * @method( method = 'goodsAmtDetailAction' )
     * @op( op = 'r' )
     */
    public function goodsChartDetailAction()
    {
    	$objRet = new \stdClass();
    	$type = $this->dispatcher->getParam( 'type' );
    	$timeStmp = $this->dispatcher->getParam( 'point' )?$this->dispatcher->getParam( 'point' ):date( 'Y-m' , strtotime( $this->today ) );
    	$timeType = $this->dispatcher->getParam( 'timeType' )?$this->dispatcher->getParam( 'timeType' ):0;
    	if( false == $type || false == $timeStmp )
    	{
    		$objRet->state = 1;
    		$objRet->msg = '对不起,参数配置错误,请刷新后重试.';
    		 
    		echo json_encode( $objRet );
    		exit;
    	}
    	if( $timeType != 1 )
    		$where = array(
    				'conditions'	=> 'delsign=:del: and unit=:unit: and p_time like :time: ORDER BY p_time ASC',
    				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType, 'time' =>$timeStmp.'%' ),
    		);
    	else
    		$where = array(
    				'conditions'	=> 'delsign=:del: and unit=:unit: ORDER BY p_time ASC',
    				'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType ),
    		);
    	switch( $type )
    	{
    		case 'amt':
    			$goodsAmtList = StatGoodsAmt::find( $where );
    			if( count( $goodsAmtList ) > 0 )
    			{
    				$arrXalias 	= array();
    				$arrDatas	= array();
    				foreach( $goodsAmtList as $row )
    				{
    					switch( $timeType )
    					{
    						case 1://年
    							$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    							$arrXalias[]	= $row->p_time. '年';
    						break;
    						case 2://月
    							$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    							$arrXalias[]	= $row->p_time . '月';
    						break;
    						case 3://时
    							$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    						break;
    						case 4://段
    							$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    						break;
    						case 0://天
    						default:
    							$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    						break;
    					}
    					$arrDatas[] = $row->goods_amt;
    				}
    				$objRet->state = 0;
    				$objRet->xalias		= $arrXalias;
    				$objRet->datas		= $arrDatas;
    				switch( $timeType )
    				{
    					case 1://年
    						$objRet->title = '商品销售金额统计 (单位/年)';
    					break;
    					case 2://月
    						$objRet->title = $timeStmp .'年   商品销售金额统计(单位/月)';
    					break;
    					case 3://时
    						$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品销售金额统计 (单位/小时)';
    					break;
    					case 4://段
    						$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品销售金额统计  (单位/时间段)';
    					break;
    					case 0://天
    					default:
    						$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 商品销售金额统计 (单位/天)';
    					break;
    				}
    			}
    			else 
    			{
    				$objRet->state = 1;
	    			$objRet->msg = '对不起,  <strong>' . $timeStmp . '</strong>  暂无统计数据.' ;
    			}
    		break;
    		case 'sale':
    			$goodsSaleList = StatGoodsSale::find( $where );
    			if( count( $goodsSaleList ) > 0 )
    			{
    				$arrXalias 	= array();
    				$arrDatas	= array();
    				foreach( $goodsSaleList as $row )
    				{
    					switch( $timeType )
    					{
    						case 1://年
    							$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    							$arrXalias[]	= $row->p_time.'年';
    						break;
    						case 2://月
    							$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    							$arrXalias[]	= $row->p_time.'月';
    						break;
    						case 3://时
    							$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    						break;
    						case 4://段
    							$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    						break;
    						case 0://天
    						default:
    							$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    						break;
    					}
    					$arrDatas[] = $row->goods_total;
    				}
    				$objRet->state = 0;
    				$objRet->xalias		= $arrXalias;
    				$objRet->datas		= $arrDatas;
    				switch( $timeType )
    				{
    					case 1://年
    						$objRet->title = '商品销售量统计 (单位/年)';
    					break;
    					case 2://月
    						$objRet->title = $timeStmp .'年  商品销售量统计(单位/月)';
    					break;
    					case 3://时
    						$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品销售量统计 (单位/小时)';
    					break;
    					case 4://段
    						$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品销售量统计  (单位/时间段)';
    					break;
    					case 0://天
    					default:
    						$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 商品销售量统计 (单位/天)';
    					break;
    				}
    			}
    			else
    			{
    				$objRet->state = 1;
    				$objRet->msg = '对不起,  <strong>' . $timeStmp . '</strong>  暂无统计数据.' ;
    			}
    		break;
    		case 'glance':
    		case 'collect':
    			$res = StatGoodsAff::find( $where );
    			if( count( $res ) > 0 )
    			{
    				$arrXalias 	= array();
    				$arrGlance	= array();
    				$arrCollect	= array();
    				$arrFavourite=array();
    				foreach( $res as $row )
    				{
    					switch( $timeType )
    					{
    						case 1://年
    							$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    							$arrXalias[]	= $row->p_time.'年';
    						break;
    						case 2://月
    							$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    							$arrXalias[]	= $row->p_time . '月';
    						break;
    						case 3://时
    							$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    						break;
    						case 4://段
    							$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    						break;
    						case 0://天
    						default:
    							$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    						break;
    					}
    				
    					if( 'glance' == $type )
    					{
    						$arrGlance[] = $row->glance;
    					}
    					else if( 'collect' == $type )
    					{
    						$arrCollect[] = $row->collect;
    						$arrFavourite[]=$row->favourite;
    					}
    				}
    				$objRet->state 		= 0;
    				$objRet->xalias		= $arrXalias;
    				$objRet->glance		= $arrGlance;
    				$objRet->collect 	= $arrCollect;
    				$objRet->fovourite	= $arrFavourite;
    				if( 'glance' == $type )
    				{
    					switch( $timeType )
    					{
    						case 1://年
    							$objRet->title = '商品浏览量统计 (单位/年)';
    						break;
    						case 2://月
    							$objRet->title = $timeStmp .'年  商品浏览量统计(单位/月)';
    						break;
    						case 3://时
    							$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品浏览量统计 (单位/小时)';
    						break;
    						case 4://段
    							$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品浏览量统计  (单位/时间段)';
    						break;
    						case 0://天
    						default:
    							$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 商品浏览量统计 (单位/天)';
    						break;
    					}
    				}
    				else if( 'collect' == $type )
    				{
    					switch( $timeType )
    					{
    						case 1://年
    							$objRet->title = '商品收藏量、好评率统计 (单位/年)';
    						break;
    						case 2://月
    							$objRet->title = $timeStmp .'年  商品收藏量、好评率统计(单位/月)';
    						break;
    						case 3://时
    							$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品收藏量、好评率统计 (单位/小时)';
    						break;
    						case 4://段
    							$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品收藏量、好评率统计  (单位/时间段)';
    						break;
    						case 0://天
    						default:
    							$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 商品收藏量、好评率统计 (单位/天)';
    						break;
    					}
    				}
    			}
    			else
    			{
    				$objRet->state = 1;
    				$objRet->msg = '对不起,  <strong>' . $timeStmp . '</strong>  暂无统计数据.' ;
    			}
    		break;
    		case 'source':
    			$source = StatGoodsSource::find( $where );
    			if( count( $source ) > 0 )
    			{
    				$arrBaidu  = array();
    				$arrSougou = array();
    				$arrGoogle = array();
    				$arrQihu   = array();
    				foreach( $source as $row )
    				{
    					switch( $timeType )
    					{
    						case 1://年
    							$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    							$arrXalias[]	= $row->p_time.'年';
    						break;
    						case 2://月
    							$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    							$arrXalias[]	= $row->p_time. '月';
    						break;
    						case 3://时
    							$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    						break;
    						case 4://段
    							$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    						break;
    						case 0://天
    						default:
    							$arrXalias[]	= date( 'd日' , strtotime( $row->p_time ) );
    						break;
    					}
    					$arrBaidu[]  = $row->baidu;
    					$arrSougou[] = $row->sougou;
    					$arrGoogle[] = $row->google;
    					$arrQihu[]   = $row->qihu;
    				}
    				$objRet->state 	= 0;
    				$objRet->xalias	= $arrXalias;
    				$objRet->baidu	= $arrBaidu;
    				$objRet->sougou	= $arrSougou;
    				$objRet->google	= $arrGoogle;
    				$objRet->qihu	= $arrQihu;
    				switch( $timeType )
    				{
    					case 1://年
    						$objRet->title = '商品到达来源统计 (单位/年)';
    					break;
    					case 2://月
    						$objRet->title = $timeStmp.'年  商品到达来源统计(单位/月)';
    					break;
    					case 3://时
    						$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品到达来源统计 (单位/小时)';
    					break;
    					case 4://段
    						$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品到达来源统计  (单位/时间段)';
    					break;
    					case 0://天
    					default:
    						$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 商品到达来源统计 (单位/天)';
    					break;
    				}
    			}
    			else 
    			{
    				$objRet->state = 1;
    				$objRet->msg = '对不起,  <strong>' . $timeStmp . '</strong>  暂无统计数据.' ;
    			}
    		break;
    		default:
    		break;
    	}
    	
    	echo json_encode( $objRet );
    }
    
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.18' )
     * @comment( comment = '商品详细页面' )
     * @method( method = 'goodsListAction' )
     * @op( op = 'r' )
     */
    public function goodsListAction()
    {
    	$pageNum = $this->request->getQuery( 'page', 'int' );
    	$currentPage = $pageNum ? $pageNum : 1;
    		
    	$gWhere = array(
    		'column'	 => 'id,addtime,uptime,shelve_time,name,delsign,cat_id,shop_id,status',
    		'conditions' => 'delsign=:del:',
    		'bind'		 => array( 'del' => SystemEnums::DELSIGN_NO ),
    	);
    	$goods = GoodsTechan::find( $gWhere );
    	if( count( $goods ) > 0 )
    	{
    		$pagination = new PaginatorModel( array(
    				'data' => $goods,
    				'limit' => 15,
    				'page' => $currentPage
    		) );
    		$page = $pagination->getPaginate();
    		$this->view->page = $page;
    	}
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.9.18' )
     * @comment( comment = '商品详细统计信息' )
     * @method( method = 'getItemGoodAction' )
     * @op( op = 'r' )
     */
    public function getItemGoodAction()
    {
    	$objRet = new \stdClass();
    	$format = date( 'Y-m' , strtotime( $this->today ) );
    	
    	$iID = $this->dispatcher->getParam( 'uid' );
    	$type = $this->dispatcher->getParam( 'type' );
    	$timeStmp = $this->dispatcher->getParam( 'point' )?$this->dispatcher->getParam( 'point' ):date( 'Y-m' , strtotime( $this->today ) );
    	$timeType = $this->dispatcher->getParam( 'timeType' )?$this->dispatcher->getParam( 'timeType' ):0;
    	if( false == $iID || false == $timeStmp )
    	{
    		$objRet->state = 1;
    		$objRet->msg = '对不起,参数配置错误,请刷新后重试.';
    	
    		echo json_encode( $objRet );
    		exit;
    	}
    	if( $timeType != 1 )
    		$where = array(
    			'conditions'	=> 'delsign=:del: and g_id=:sign: and unit=:unit: and p_time like :time: ORDER BY p_time ASC ',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'sign' => $iID, 'unit' => $timeType, 'time' =>$timeStmp.'%' ),
    		);
    	else
    		$where = array(
    			'conditions'	=> 'delsign=:del: and g_id=:sign: and unit=:unit: ORDER BY p_time ASC ',
    			'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'sign' => $iID, 'unit' => $timeType ),
    		);

    	switch( $type )
    	{
    		case 'amt':
    			$goodAmtList = StatGoodAmt::find( $where );
    			$arrXalias 	= array();
    			$arrDatas	= array();
    			foreach( $goodAmtList as $row )
    			{
    				switch( $timeType )
    				{
    					case 1://年
    						$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    						$arrXalias[]	= $row->p_time . '年';
    					break;
    					case 2://月
    						$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    						$arrXalias[]	= $row->p_time . '月';
    					break;
    					case 3://时
    						$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    					break;
    					case 4://段
    						$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    					break;
    					case 0://天
    					default:
    						$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    					break;
    				}
    				$arrDatas[] = $row->goods_amt;
    			}
    			$objRet->state = 0;
    			$objRet->xalias		= $arrXalias;
    			$objRet->datas		= $arrDatas;
    			switch( $timeType )
    			{
    				case 1://年
    					$objRet->title = '商品销售金额统计 (单位/年)';
    				break;
    				case 2://月
    					$objRet->title =  $timeStmp .'年 商品销售金额统计(单位/月)';
    				break;
    				case 3://时
    					$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品销售金额统计 (单位/小时)';
    				break;
    				case 4://段
    					$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品销售金额统计  (单位/时间段)';
    				break;
    				case 0://天
    				default:
    					$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 商品销售金额统计 (单位/天)';
    				break;
    			}
    		break;
    		case 'sale':
    			$goodSaleList = StatGoodSale::find( $where );
    			$arrXalias 	= array();
    			$arrDatas	= array();
    			foreach( $goodSaleList as $row )
    			{
    				switch( $timeType )
    				{
    					case 1://年
    						$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    						$arrXalias[]	= $row->p_time . '年';
    					break;
    					case 2://月
    						$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    						$arrXalias[]	= $row->p_time. '月';
    					break;
    					case 3://时
    						$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    					break;
    					case 4://段
    						$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    					break;
    					case 0://天
    					default:
    						$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    					break;
    				}
    				$arrDatas[] = $row->goods_total;
    			}
    			$objRet->state = 0;
    			$objRet->xalias		= $arrXalias;
    			$objRet->datas		= $arrDatas;
    			switch( $timeType )
    			{
    				case 1://年
    					$objRet->title = '商品销售量统计 (单位/年)';
    				break;
    				case 2://月
    					$objRet->title = $timeStmp.'年 商品销售量统计(单位/月)';
    				break;
    				case 3://时
    					$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品销售量统计 (单位/小时)';
    				break;
    				case 4://段
    					$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品销售量统计  (单位/时间段)';
    				break;
    				case 0://天
    				default:
    					$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 商品销售量统计 (单位/天)';
    				break;
    			}
    		break;
    		case 'glance':
    		case 'collect':
    			$res = StatGoodAff::find( $where );
    			$arrXalias 	= array();
    			$arrGlance	= array();
    			$arrCollect	= array();
    			$arrFavourite=array();
    			foreach( $res as $row )
    			{
    				switch( $timeType )
    				{
    					case 1://年
    						$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    						$arrXalias[]	= $row->p_time . '年';
    					break;
    					case 2://月
    						$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    						$arrXalias[]	= $row->p_time . '月';
    					break;
    					case 3://时
    						$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    					break;
    					case 4://段
    						$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    					break;
    					case 0://天
    					default:
    						$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    					break;
    				}
    				if( 'glance' == $type )
    					$arrGlance[] = $row->glance;
    				else if( 'collect' == $type )
    				{
    					$arrCollect[] = $row->collect;
    					$arrFavourite[]=$row->favourite;
    				}
    			}
    			$objRet->state 		= 0;
    			$objRet->xalias		= $arrXalias;
    			$objRet->glance		= $arrGlance;
    			$objRet->collect 	= $arrCollect;
    			$objRet->fovourite	= $arrFavourite;
    			if( 'amt' == $type )
    			{
    				switch( $timeType )
    				{
    					case 1://年
    						$objRet->title = '订单总销售金额统计 (单位/年)';
    					break;
    					case 2://月
    						$objRet->title = $timeStmp.'年 订单总销售金额统计 (单位/月)';
    					break;
    					case 3://时
    						$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 订单总销售金额统计  (单位/小时)';
    					break;
    					case 4://段
    						$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 订单总销售金额统计  (单位/时间段)';
    					break;
    					case 0://天
    					default:
    						$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 订单总销售金额统计  (单位/天)';
    					break;
    				}
    			}
    			else if( 'num' == $type )
    			{
    				switch( $timeType )
    				{
    					case 1://年
    						$objRet->title = '订单总销量增长统计 (单位/年)';
    					break;
    					case 2://月
    						$objRet->title = $timeStmp .'年 订单总销量增长统计(单位/月)';
    					break;
    					case 3://时
    						$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 订单总销量增长统计 (单位/小时)';
    					break;
    					case 4://段
    						$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 订单总销量增长统计  (单位/时间段)';
    					break;
    					case 0://天
    					default:
    						$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 订单总销量增长统计 (单位/天)';
    					break;
    				}
    			}
    		break;
    		case 'source':
    			$source = StatGoodSource::find( $where );
    			$arrXalias = array();
    			$arrBaidu  = array();
    			$arrSougou = array();
    			$arrGoogle = array();
    			$arrQihu   = array();
    			foreach( $source as $row )
    			{
    				switch( $timeType )
    				{
    					case 1://年
    						$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    						$arrXalias[]	= $row->p_time . '年';
    					break;
    					case 2://月
    						$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    						$arrXalias[]	= $row->p_time . '月';
    					break;
    					case 3://时
    						$arrXalias[]	= date( 'H点' , strtotime( $row->p_time ) );
    					break;
    					case 4://段
    						$arrXalias[]	= date( 'H:i' , strtotime( $row->p_time ) );
    					break;
    					case 0://天
    					default:
    						$arrXalias[]	= date( 'd号' , strtotime( $row->p_time ) );
    					break;
    				}
    				$arrBaidu[]  = $row->baidu;
    				$arrSougou[] = $row->sougou;
    				$arrGoogle[] = $row->google;
    				$arrQihu[]   = $row->qihu;
    			}
    			$objRet->state 	= 0;
    			$objRet->xalias	= $arrXalias;
    			$objRet->baidu	= $arrBaidu;
    			$objRet->sougou	= $arrSougou;
    			$objRet->google	= $arrGoogle;
    			$objRet->qihu	= $arrQihu;
    			switch( $timeType )
    			{
    				case 1://年
    					$objRet->title = '商品到达来源统计 (单位/年)';
    				break;
    				case 2://月
    					$objRet->title =  $timeStmp .'年 商品到达来源统计(单位/月)';
    				break;
    				case 3://时
    					$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品到达来源统计 (单位/小时)';
    				break;
    				case 4://段
    					$objRet->title = date( 'Y年m月d日', strtotime( $timeStmp ) ) .' 商品到达来源统计  (单位/时间段)';
    				break;
    				case 0://天
    				default:
    					$objRet->title	= date( 'Y年m月', strtotime( $timeStmp ) ) .' 商品到达来源统计 (单位/天)';
    				break;
    			}
    		break;
    		default:
    		break;
    	}
    	echo json_encode( $objRet );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.10.19' )
     * @comment( comment = '会员分布详细信息' )
     * @method( method = 'getDistListAction' )
     * @op( op = 'r' )
     */
    public function getDistListAction()
    {
    	$arrProInfo = array();
    	$proWhere = array(
    			'column'	=> 'id,name,level,upid',
    			'conditions'=> 'level=:l: and upid=:pid:',
    			'bind'		=> array( 'l' => 1,  'pid' => 0 ),
    	);
    	$pRes = CommonDistrictDic::find( $proWhere );
    	$i=0;
    	foreach( $pRes as $row )
    	{
    		$arrProInfo[$i][ 'id' ] = $row->id;
    		$arrProInfo[$i][ 'name' ] = $row->name;
    		$i++;
    	}
    	$arrProvince = array();
    	if( count( $arrProInfo ) > 0 )
    	{
    		$i=0;
    		foreach( $arrProInfo as $pinfo )
    		{
    			$pWhere = array(
    					'column'	=> 'id,delsign,province,p_num,percent,unit,p_time,',
    					'conditions'=> 'delsign=:del: and p_time like :time: and unit=:unit: and province=:provinceid: ORDER BY province,city ASC',
    					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'unit' => StatisticsEnums::UNIT_TYPE_DAY , 'time' => $this->today . '%', 'provinceid' => $pinfo['id'] ),
    			);
    			$pStats = StatUserDistrict::find( $pWhere );
    			$iPnumber = 0;
    			if( count( $pStats ) > 0 )
    			{
    				foreach( $pStats as $row )
    				{
    					$iPnumber += $row->p_num;
    				}
    			}
    			$arrProvince[$i][ 'son' ] = count( $pStats );
    			$arrProvince[$i][ 'pid' ] = $pinfo['id'];
    			$arrProvince[$i][ 'pname' ] = $pinfo['name'];
    			$arrProvince[$i][ 'num' ]	= $iPnumber;
    			$i++;
    		}
    	}
    	$this->view->plist = $arrProvince;
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.10.19' )
     * @comment( comment = '会员分布详细信息' )
     * @method( method = 'getCityListAction' )
     * @op( op = 'r' )
     */
    public function getCityListAction()
    {
    	$arrDatas = array();
    	$proId  = $this->dispatcher->getParam( 'pid' );
    	$timeStmp = $this->dispatcher->getParam( 'point' )?$this->dispatcher->getParam( 'point' ):date( 'Y-m' , strtotime( $this->today ) );
    	$timeType = $this->dispatcher->getParam( 'timeType' )?$this->dispatcher->getParam( 'timeType' ):0;
    	
    	if( false == $proId )
    	{
    		$arrDatas[ 'state' ] = 1;
    		$arrDatas[ 'msg' ] = '获取数据失败,请刷新后再试.';
    		
    		echo json_encode( $arrDatas );
    		exit;
    	}
    	$where = array(
    			'column'	=> 'id,delsign,province,p_num,percent,unit,p_time,',
    			'conditions'=> 'delsign=:del: and p_time like :time: and unit=:unit: and province=:provinceid: ORDER BY province,city ASC',
    			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'unit' => $timeType , 'time' => $timeStmp . '%', 'provinceid' => $proId ),
    	);
    	$res = StatUserDistrict::find( $where );
    	if( count( $res ) > 0 )
    	{
    		$i=0;
    		foreach( $res as $row )
    		{
    			$arrDatas[ 'data' ][$i][ 'city' ] = $row->city?$row->city_info->name:$row->district->name;
    			$arrDatas[ 'data' ][$i][ 'num' ]	= $row->p_num;
    			switch( $timeType )
    			{
    				case 1://年
    					$arrDatas[ 'data' ][$i][ 'time' ]	= '';
    				break;
    				case 2://月
    					$row->p_time = trim( str_replace( $this->find, '', $row->p_time ) );
    					$arrDatas[ 'data' ][$i][ 'time' ]	= $row->p_time. '月';
    				break;
    				case 3://时
    					$arrDatas[ 'data' ][$i][ 'time' ]	= date( 'H点' , strtotime( $row->p_time ) );
    				break;
    				case 4://段
    					$arrDatas[ 'data' ][$i][ 'time' ]	= date( 'H:i' , strtotime( $row->p_time ) );
    				break;
    				case 0://天
    				default:
    					$arrDatas[ 'data' ][$i][ 'time' ]	= date( 'd号' , strtotime( $row->p_time ) );
    				break;
    			}
    			$i++;
    		}
    		$arrDatas[ 'state' ] = 0;
    		$arrDatas[ 'type' ] = $timeType;
    		$arrDatas[ 'selTime' ] = $timeStmp;
    	}
    	else
    	{
    		$arrDatas[ 'state' ] = 1;
    		$arrDatas[ 'msg' ] = '未获取到数据,请稍后再试.';
    	}
    	echo json_encode( $arrDatas );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.10.19' )
     * @comment( comment = '会员分区域图 按时间节点' )
     * @method( method = 'getDetailMapAction' )
     * @op( op = 'r' )
     */
    public function getDetailMapAction()
    {
    	$arrDatas = array();
    	$type = $this->dispatcher->getParam( 'type' );
    	$timeStmp = $this->dispatcher->getParam( 'point' )?$this->dispatcher->getParam( 'point' ):date( 'Y-m' , strtotime( $this->today ) );
    	$timeType = $this->dispatcher->getParam( 'timeType' )?$this->dispatcher->getParam( 'timeType' ):0;
    	
    	if( false == $timeStmp )
    	{
    		$arrDatas['state'] = 1;
    		$arrDatas['msg']   = '对不起,参数配置错误,请刷新后重试.';
    		 
    		echo json_encode( $arrDatas );
    		exit;
    	}
    	$arrProInfo = array();
    	$proWhere = array(
    			'column'	=> 'id,name,level,upid',
    			'conditions'=> 'level=:l: and upid=:pid:',
    			'bind'		=> array( 'l' => 1,  'pid' => 0 ),
    	);
    	$pRes = CommonDistrictDic::find( $proWhere );
    	$i=0;
    	foreach( $pRes as $row )
    	{
    		$arrProInfo[$i][ 'id' ] = $row->id;
    		$arrProInfo[$i][ 'name' ] = $row->name;
    		$i++;
    	}
    	//省
    	if( count( $arrProInfo ) > 0 )
    	{
    		$i=0;
    		foreach( $arrProInfo as $info )
    		{
    			if( $timeType != 1 )
    				$where = array(
    						'column'	=> 'id,delsign,province,p_num,percent,unit,p_time,',
    						'conditions'	=> 'delsign=:del: and unit=:unit: and province=:provinceid: and p_time like :time:  ORDER BY p_time ASC ',
    						'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType, 'time' => $timeStmp . '%', 'provinceid'=> $info[ 'id' ] ),
    				);
    			else
    				$where = array(
    						'conditions'	=> 'delsign=:del: and unit=:unit:  and province=:provinceid: ORDER BY p_time ASC ',
    						'bind'			=> array( 'del' => SystemEnums::DELSIGN_NO, 'unit' => $timeType , 'provinceid'=> $info[ 'id' ] ),
    				);
    				
    			$res = StatUserDistrict::find( $where );
    			if( count( $res ) > 0 )
    			{
    				$iPnumber = 0;
    				foreach( $res as $row )
    				{
    					$iPnumber += intval( $row->p_num );
    				}
    				$arrDatas['province'][$i][ 'name' ] = trim(  str_replace( $this->arrFind,  '', $info['name'] ) );
    				$arrDatas['province'][$i][ 'value' ]= $iPnumber;
    				$i++;
    			}
    		}
    		
    		$arrDatas[ 'state' ] = 0;
    	}
    	//市
    	$where = array(
    			'column'	=> 'id,delsign,province,city,p_num,percent,unit,p_time,',
    			'conditions'=> 'delsign=:del: and p_time like :time: and unit=:unit: ORDER BY province,city ASC',
    			'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'unit' => $timeType , 'time' => $timeStmp . '%' ),
    	);
    	$res = StatUserDistrict::find( $where );
    	if( count( $res ) > 0 )
    	{
    		$arrFinding= array( '省', '特别行政区'  );
    		$i=0;
    		foreach( $res as $row )
    		{
    			if( false != $row->city )
    			{
    				$arrDatas[ 'city' ][$i]['name'] = trim( str_replace( $arrFinding , '', $row->city_info->name ) );
    				$arrDatas[ 'city' ][$i]['value' ] = intval( $row->p_num );
    			}
    			else
    			{
    				$pWhere = array(
    						'column'	=> 'id,delsign,province,p_num,percent,unit,p_time,',
    						'conditions'=> 'delsign=:del: and p_time like :time: and unit=:unit: and province=:provinceid: ORDER BY province,city ASC',
    						'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'unit' => StatisticsEnums::UNIT_TYPE_DAY , 'time' => $this->today . '%', 'provinceid' => $row->province ),
    				);
    				$pStats = StatUserDistrict::find( $pWhere );
    				$iPnumber = 0;
    				if( count( $pStats ) > 0 )
    				{
    					foreach( $pStats as $mun )
    					{
    						$iPnumber += intval( $mun->p_num );
    					}
    					$arrDatas['province'][$i][ 'name' ] = trim(  str_replace( $this->arrFind,  '', $info['name'] ) );
    					$arrDatas['province'][$i][ 'value' ]= $iPnumber;
    				}
    			}
    			$i++;
    		}
    	}
    	 
    	if( !empty( $arrDatas['province'] ) )
    		rsort( $arrDatas[ 'province' ] );
    	
    	if( !empty( $arrDatas[ 'province' ] ) && false != $arrDatas[ 'province' ][0]['value'] )
    	{
    		if( $arrDatas[ 'province' ][0]['value'] > 0 && $arrDatas[ 'province' ][0]['value']< 1000 )
    			$max = 1000;
    		else if( $arrDatas[ 'province' ][0]['value'] >= 1000 && $arrDatas[ 'province' ][0]['value'] < 5000 )
    			$max = 5000;
    		else if( $arrDatas[ 'province' ][0]['value'] >= 5000 && $arrDatas[ 'province' ][0]['value'] < 10000 )
    			$max = 10000;
    		else if( $arrDatas[ 'province' ][0]['value'] >= 10000 && $arrDatas[ 'province' ][0]['value'] < 50000 )
    			$max = 50000;
    		else if( $arrDatas[ 'province' ][0]['value'] < 50000 )
    			$max = intval( ceil( $arrDatas[ 'province' ][0]['value'] ) );
    	}
    	else
    		$max = 1000;
    	
    	$arrDatas['max'] = $max;
    	$arrDatas[ 'selTime' ] = $timeStmp;
    	
    	echo json_encode( $arrDatas );
    }
    
    /**
     * @author( author='Carey' )
     * @date( date = '2015.10.12' )
     * @comment( comment = '会员分区域图详细信息 按时间节点' )
     * @method( method = 'getListMapsAction' )
     * @op( op = 'r' )
     */
    public function getListMapsAction()
    {
    	$arrDatas = array();
    	$timeStmp = $this->dispatcher->getParam( 'point' )?$this->dispatcher->getParam( 'point' ):date( 'Y-m' , strtotime( $this->today ) );
    	$timeType = $this->dispatcher->getParam( 'timeType' )?$this->dispatcher->getParam( 'timeType' ):0;
    	 
    	if( false == $timeStmp )
    	{
    		
    		$arrDatas[ 'state' ] = 1;
    		$arrDatas[ 'message' ] = '对不起,参数配置错误,请刷新后重试.';
    		 
    		echo json_encode( $arrDatas );
    		exit;
    	}
    	
    	$arrProInfo = array();
    	$proWhere = array(
    			'column'	=> 'id,name,level,upid',
    			'conditions'=> 'level=:l: and upid=:pid:',
    			'bind'		=> array( 'l' => 1,  'pid' => 0 ),
    	);
    	$pRes = CommonDistrictDic::find( $proWhere );
    	$i=0;
    	foreach( $pRes as $row )
    	{
    		$arrProInfo[$i][ 'id' ] = $row->id;
    		$arrProInfo[$i][ 'name' ] = $row->name;
    		$i++;
    	}
    	if( count( $arrProInfo ) > 0 )
    	{
    		$i=0;
    		foreach( $arrProInfo as $pinfo )
    		{
    			$pWhere = array(
    					'column'	=> 'id,delsign,province,p_num,percent,unit,p_time,',
    					'conditions'=> 'delsign=:del: and p_time like :time: and unit=:unit: and province=:provinceid: ORDER BY province,city ASC',
    					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO , 'unit' => $timeType , 'time' => $timeStmp . '%', 'provinceid' => $pinfo['id'] ),
    			);
    			$pStats = StatUserDistrict::find( $pWhere );
    			$iPnumber = 0;
    			if( count( $pStats ) > 0 )
    			{
    				foreach( $pStats as $row )
    				{
    					$iPnumber += $row->p_num;
    				}
    			}
    			$arrDatas[ 'data' ][$i][ 'son' ] = count( $pStats );
    			$arrDatas[ 'data' ][$i][ 'pid' ] = $pinfo['id'];
    			$arrDatas[ 'data' ][$i][ 'pname' ] = $pinfo['name'];
    			$arrDatas[ 'data' ][$i][ 'num' ]	= $iPnumber;
    			$i++;
    		}
    		$arrDatas[ 'state' ] = 0;
    		$arrDatas[ 'type' ]  = $timeType;
    		$arrDatas[ 'selTime' ] = $timeStmp;
    	}
    	echo json_encode( $arrDatas );
    }
    
    
}

?>