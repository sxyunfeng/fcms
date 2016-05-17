<?php

namespace apps\cms\libraries;

use apps\cms\models\Articles;
use Phalcon\Di\Injectable;
use Phalcon\DiInterface;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

class SearchData extends Injectable{
	/**
	 * 获取关键字查询的列表
	 * @param unknown $key
	 * @param unknown $page
	 * @return \Phalcon\Paginator\Adapter\stdClass
	 */
	public function getSearchRes( $key , $page )
	{
        $strKey = str_replace( ' ', '* ', $key );
        $strKey .= '*';
        $article = Articles::findByRawSql( $strKey );
        $res = $article->toArray();
		$pagination = new PaginatorArray( array(
			'data'  => $res,
			'limit' => 10,
			'page'  => $page
		) );
		
		return $pagination->getPaginate();
	}
}

?>