<?php

namespace apps\install\utils;

class ReturnInfo
{
    /**
     * @author( author='New' )
     * @date( date = '2015年11月5日' )
     * @comment( comment = '返回标记量和输出信息' )    
     * @method( method = 'resInfo' )
     * @op( op = '' )        
    */
    public static function resInfo( $status, $msg )
    {
        $res[ 'status' ] = $status;
        $res[ 'msg' ] = $msg;
        return $res;
    }

}
?>