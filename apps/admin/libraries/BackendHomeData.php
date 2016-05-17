<?php

namespace apps\admin\libraries;

use Phalcon\DI\InjectionAwareInterface;
use enums\SystemEnums;
use apps\admin\enums\SlideEnums;
use apps\admin\models\Articles;
use apps\admin\models\PriUsers;


class BackendHomeData implements InjectionAwareInterface{
	
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
	 * @date( date = '2016-3-28' )
	 * @comment( comment = '获取文章总数' )	
	 * @method( method = 'getArticleNums' )
	 * @op( op = 'r' )		
	*/
	public function getArticleNums()
	{
	    $where = [
	    	'columns' => 'id',
	        'conditions' => 'delsign=?0',
	        'bind' => [ SystemEnums::DELSIGN_NO ]
	    ];
		$articles = Articles::find( $where );
		return count( $articles );
	}
	
	/**
	 * @author( author='New' )
	 * @date( date = '2016-3-28' )
	 * @comment( comment = '获取用户总数' )
	 * @method( method = 'getUserNums' )
	 * @op( op = 'r' )
	 */
	public function getUserNums()
	{
	    $where = [
            'columns' => 'id',
            'conditions' => 'delsign=?0',
            'bind' => [ SystemEnums::DELSIGN_NO ]
        ];
	    $users = PriUsers::find( $where );
	    return count( $users );
	}
}


?>