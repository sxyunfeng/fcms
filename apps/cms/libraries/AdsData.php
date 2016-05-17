<?php

namespace apps\cms\libraries;

use Phalcon\DI\InjectionAwareInterface;
use enums\SystemEnums;
use apps\cms\models\Ad;
use apps\cms\vos\AdsVo;

class AdsData implements InjectionAwareInterface{
	
	/* (non-PHPdoc)
	 * @see \Phalcon\DI\InjectionAwareInterface::setDI()
	 */
	private $_di;
	private $ad_cache = 'f_cms_ad_cache';
	
	public function setDI(\Phalcon\DiInterface $dependencyInjector) {
		// TODO Auto-generated method stub
		$this->_di = $dependencyInjector;	
	}

	/* (non-PHPdoc)
	 * @see \Phalcon\DI\InjectionAwareInterface::getDI()
	 */
	public function getDI() {
		// TODO Auto-generated method stub
		return $this->_di;
	}
	
	
	/**
	 * 商家广告列表
	 * @param int $shopid -- 商家id
	 * @return object
	 */
	public function getShopAdsList( $shopid )
	{
		if( false == $shopid )
			return false;
	
		$where = array(
				'column'	=> 'id,delsign,addtime,uptime,media_type,name,url,begin_time,end_time,click_count,enabled,cat_id,sort_order,title,click_left,weight,cid,src,shopid,nofollow',
				'conditions'=> 'delsign=:del: and enabled=:abled: and shopid=:sid: ORDER BY sort_order DESC',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'abled' => 1 , 'sid' => $shopid ),
		);
		$shopAds = Ad::find( $where );
		if( count( $shopAds ) > 0 && false != $shopAds )
		{
			$vo = new AdsVo();//设置广告 vo
			foreach ( $shopAds as $row )
			{
				$vo->setData( $row );
			}
		}
	
		return $shopAds;
	}
	
	/**
	 * 获取分类下 所有图片
	 * @param int $pid
	 * @return object
	 */
	public function getTransformImg( $pid , $limit = 3 )
	{
		if( false != $pid )
			return false;
	
		$arrWhere = array(
				'column'	=> 'id,delsign,addtime,uptime,media_type,name,url,begin_time,end_time,click_count,enabled,cat_id,sort_order,title,click_left,weight,cid,src,shopid,nofollow',
				'conditions'=> 'delsign=:del: and enabled=:abled: and cat_id=:pid: ORDER BY sort_order DESC limit ' . $limit,
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'abled' => 1 ),
		);
		$turnAds = Ad::find( $arrWhere );
		if( count( $turnAds ) > 0 && false != $turnAds )
		{
			$vo = new AdsVo();//设置广告 vo
			foreach ( $turnAds as $row )
			{
				$vo->setData( $row );
			}
		}
	
		return $turnAds;
	}
	
	/**
	 * 某分类下的广告
	 * @param int $cid
	 * @return object
	 */
	public function getCateAdsList( $cid )
	{
		if( false == $cid )
			return false;
	
		$where = array(
				'column'	=> 'id,delsign,addtime,uptime,media_type,name,url,begin_time,end_time,click_count,enabled,cat_id,sort_order,title,click_left,weight,cid,src,shopid,nofollow',
				'conditions'=> 'delsign=:del: and enabled=:abled: and cat_id=:cid: ORDER BY sort_order,uptime DESC',
				'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'abled' => 1 , 'cid' => $cid ),
		);
		$catAdsList = Ad::find( $where );
		if( count( $catAdsList ) > 0 && false != $catAdsList )
		{
			$vo = new AdsVo();//设置广告 vo
			foreach ( $catAdsList as $row )
			{
				$vo->setData( $row );
			}
		}
	
		return $catAdsList;
	}
	
	/**
	 * 获取单广告信息
	 * @param int $aid  -- 广告id
	 * @return object
	 */
	public function getSingleAd( $aid )
	{
		$cache = new CacheMagCenter();
		$cacheData = $cache->getCacheConfigs( $this->ad_cache );
		if( false != $cacheData )
			return CacheDataCenter::getAdDetail( $this->_di , $cacheData , $aid );
		else
		{
			$where = array(
					'column'	=> 'id,delsign,addtime,uptime,media_type,name,url,begin_time,end_time,click_count,enabled,cat_id,sort_order,title,click_left,weight,cid,src,shopid,nofollow',
					'conditions'=> 'delsign=:del: and enabled=:abled: and id=:optid: ORDER BY sort_order DESC',
					'bind'		=> array( 'del' => SystemEnums::DELSIGN_NO, 'abled' => 1 , 'optid' => $aid ),
			);
			$ad = Ad::findFirst( $where );
			if( count( $ad ) > 0 && false != $ad )
			{
				//设置广告 vo
				$vo = new AdsVo();
				$vo->setData( $ad );
			}
			return $ad;
		}
	}
	
}
?>