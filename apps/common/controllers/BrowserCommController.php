<?php

namespace apps\common\controllers;

use apps\home\enums\PublicEnums;

/**
 * Description of BrowserCommController
 *
 * @author yyl
 */
class BrowserCommController extends \Phalcon\Mvc\Controller
{

    /**
     * @author( author='yyl' )
     * @date( date = '2015.9.18' )
     * @comment( comment = '浏览器推荐' )
     * @method( method = 'BrowserAction' )		
     * @op( op = 'r' )		
     */
    public function BrowserAction()
    {
        $agent = $_SERVER[ 'HTTP_USER_AGENT' ];

        //浏览器类型
        if( strpos( $agent, 'MSIE' ) !== false || strpos( $agent, 'rv:11.0' ) ) //ie11判断
        {
            $agentType = "ie";
        }
        else if( strpos( $agent, 'Firefox' ) !== false )
        {
            $agentType = "firefox";
        }
        else if( strpos( $agent, 'Chrome' ) !== false )
        {
            $agentType = "chrome";
        }
        else if( (strpos( $agent, 'Chrome' ) == false) && strpos( $agent,
                        'Safari' ) !== false )
        {
            $agentType = 'safari';
        }
        else
        {
            $agentType = 'unknown';
        }
        
        //浏览器版本数
        if( preg_match( '/MSIE\s(\d+)\..*/i', $agent, $regs ) )
        {
            $agentNum = $regs[ 1 ];
        }
        elseif( preg_match( '/FireFox\/(\d+)\..*/i', $agent, $regs ) )
        {
            $agentNum = $regs[ 1 ];
        }
        elseif( preg_match( '/Chrome\/(\d+)\..*/i', $agent, $regs ) )
        {
            $agentNum = $regs[ 1 ];
        }
        elseif( (strpos( $agent, 'Chrome' ) == false) && preg_match( '/Safari\/(\d+)\..*$/i',
                        $agent, $regs ) )
        {
            $agentNum = $regs[ 1 ];
        }
        else
        {
            $agentNum = 'unknow';
        }

        $publicEnums = new PublicEnums();
        if( $agentType . $agentNum == 'ie8' )
        {
            $arrRet = $publicEnums->statusEnums( 1, '您浏览器版本过低请升级' );
        }
        else
        {
            $arrRet = $publicEnums->statusEnums( 0, '' );
        }
        echo json_encode( $arrRet );
    }

}
