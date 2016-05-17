<?php
/**
 * 系统主框架以及公共显示区域
 * @author Bruce
 * time 2014-10-30
 */
namespace apps\common\controllers;
use apps\common\models\Articles;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class TestController extends \Phalcon\Mvc\Controller
{
    /**
     * @comment( value = '' )
     */
	public function initialize()
	{
	    
	}
	
	/**
	 * @comment( value = '' )
	 */
	public function indexAction( )
	{	   
	    $this->tools(); 
	    $this->libraries();
	}
	
	/**
	 * @comment
	 */
	private function tools()
	{
	    // 	    echo $this->utest->run( $this->email->sendMail( 'sss', 'xxxx', '2046961128@qq.com' ), false, 'send email test' );
	    	  
	}
	
	private function getArr1()
	{
		return array( 1, 2 );
	}
	
	private function getArr2()
	{
	    return array( 1 => '1', 2 => 'b' );
	}
	
	private function getObj1()
	{
		
	}
	
	private function getObj2()
	{
		
	}
	
	private function libraries()
	{
		echo $this->utest->run( 1+1, 2, 'Integer Test' );
		echo $this->utest->run( 'hi', 'hi', 'String Test' );
		echo $this->utest->run( $this->getArr1(), array( 1 => '1', 2 => 'b' ), 'array test 1 ');
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 2 => 'b' ), 'simple match equal to match keys and values', '', 0 );
		
		
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 3 => 'b' ), 'array match keys', '', 1 );
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 2 => 'b' ), 'array match keys', '', 1 );
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 2 => 'c' ), 'array match keys', '', 1 );
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 3 => 'c' ), 'array match keys', '', 1 );
		
		
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 2 => 'b' ), 'array match values', '', 2 );
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 3 => 'b' ), 'array match values', '', 2 );
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 2 => 'c' ), 'array match values', '', 2 );
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 3 => 'c' ), 'array match values', '', 2 );
		
		
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 2 => 'b' ), 'array match keys and values', '', 3 );
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 2 => 'c' ), 'array match keys and values', '', 3 );
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 3 => 'b' ), 'array match keys and values', '', 3 );
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 2 => 'd' ), 'array match keys and values', '', 3 );
		
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 2 => 'd' ), 'array match partial keys', '', 4, array( '1' ) );
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 2 => 'd' ), 'array match partial keys', '', 4, array( 1 ) );
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 2 => 'd' ), 'array match partial keys', '', 4, array( 1, 2 ) );
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 2 => 'b' ), 'array match partial keys', '', 4, array( 1, 2 ) );
		echo $this->utest->run( $this->getArr2(), array( 1 => '1', 2 => 'd' ), 'array match partial keys', '', 4, array( 2 ) );
		
	}
	
	
	public function tAction()
	{
// 		$a = new Articles();
// 	    $a->addtime = time();
// 	    $a->uptime = time();
// 	    $a->author = 'abc';
// 	    $a->begin_time = time();
// 	    $a->cat_id = 3;
// 	    $a->content = 'a';
// 	    $a->delsign = 0;
// 	    $a->descr = 'asdf';
// 	    $a->description = 'asdf';
// 	    $a->end_time = time();
// 	    $a->id = time();
// 	    $a->keywords = 'keywords';
// 	    $a->status = 1;
// 	    $a->title = 'title';
// 	    $a->top = 0;
	           
// 	    $a->create();
// $a->update();
        $a->save();
		
		echo $a->id;
	}
	
}