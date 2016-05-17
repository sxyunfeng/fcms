<?php

namespace apps\cms\libraries;

use Phalcon\DI\InjectionAwareInterface;
use enums\SystemEnums;
use apps\admin\models\Slide;
use apps\admin\enums\SlideEnums;


class SlideData implements InjectionAwareInterface{
	
	private $_di;
	
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
	 * @author( author='New' )
	 * @date( date = '2016-3-23' )
	 * @comment( comment = '获取所需要的幻灯片信息（后期若只需要哪个组的幻灯片时在conditions里加上groupid限制条件即可）' )	
	 * @method( method = 'getSlides' )
	 * @op( op = 'r' )		
	*/
	public function getSlides()
	{
	    $where = [
	    	'columns' => 'id, title, content, delsign, sort, width, height, dir, url, alt, isshow',
	        'conditions' => 'delsign=?0 and isshow=?1 order by sort DESC',
	        'bind' => [ SystemEnums::DELSIGN_NO, SlideEnums::SLIDE_SHOW_YES ]
	    ];
		$slides = Slide::find( $where );
		return $slides;
	}
}


?>