<?php

namespace apps\install\models;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Model;
use apps\install\utils\ReturnInfo;


class FcmsInstall extends Model
{
    const STR_RIGHT = "<span class='glyphicon glyphicon-ok' style='color:green;'></span>";

    const STR_WRONG = "<span class='glyphicon glyphicon-remove' style='color:red;'></span>";
    
    const LOG_PATH = 'logs/fcms_install_logs.txt';
    
    /**
     * 分块每次读取多少字节数据库文件
     * $partsize
     */
    private $partsize = 10280;
    
    
    /**
     * @author( author='New' )
     * @date( date = '2015年10月24日' )
     * @comment( comment = '检查数据库连接' )
     * @method( method = 'connectDb' )
     * @op( op = 'r' )
     */
    public function connectDb( $dbHost, $dbPort, $dbUsername, $dbPassword )
    {
        return @mysql_connect( $dbHost.":".$dbPort, $dbUsername, $dbPassword );
    }
    
    
    /**
     * @author( author='New' )
     * @date( date = '2015年10月26日' )
     * @comment( comment = '将数据库文件导入到数据库中' )
     * @method( method = 'importDb' )
     * @op( op = 'r' )
     */
    public function importDb( $link, $file, $dbName )
    {
        $sqlCreate = 'CREATE DATABASE ' . $dbName . ' DEFAULT CHARSET utf8 COLLATE utf8_general_ci;';
        //数据库创建成功
        if( mysql_query( $sqlCreate ) )
        {
            mysql_select_db( $dbName, $link );
            mysql_query( 'set names utf8' );
            
            $lFileSize = filesize( $file );
            
            //得到每个拆分的sql语句块
            return $this->partlyRead( $file, $lFileSize, $link, $this->partsize );
        }
        //数据库创建失败
        else
       {
            file_put_contents( APP_ROOT . self::LOG_PATH, date( 'Y-m-d H:i:s' ) . '数据库名已存在' . PHP_EOL, FILE_APPEND );
            return $res = ReturnInfo::resInfo( 4, "<p>数据库名已存在，请删除现有同名数据库，
                           或返回上一页重新更换数据库名！&nbsp;&nbsp;" . self::STR_WRONG . "</p>" );
        }
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2015年11月2日' )
     * @comment( comment = '依次取出每块内容保存在$arr数组中' )
     * @method( method = 'partlyRead' )
     * @op( op = '' )
     */
    private function partlyRead( $file, $lFileSize, $link, $partSize )
    {
        set_time_limit( 0 );
    
        $fp = fopen( $file, 'r' );
         
        //设置临时变量用以保存每次得到的块中不完整的最后一句
        $strTemp = '';
        
        //从头到尾读取sql文件
        for( $iIndex = 0; $iIndex < $lFileSize; $iIndex += $partSize )
        {
            $seekSize = ( $lFileSize - $iIndex > $partSize ) ? $partSize : ( $lFileSize - $iIndex );
            $data = fread( $fp, $seekSize );
            $arr = preg_split( "/;(\r)(?!\w)/", $data, -1 );
            $iArrLen = count( $arr );
            //当不是第一次取sql语句时，就将上次取的最后的一个半句与这次取的第一句的半句拼接起来，组成本地的第一句（就是完整的了）
            if( $iIndex != 0 )
            {
                $arr[ 0 ] = $strTemp . $arr[ 0 ];
            }
            for( $i = 0; $i < $iArrLen; ++$i )
            {
                $strSql = $arr[ $i ];
                //将最后一条不完整的数据存储在$strTemp中，然后释放掉
                if( $iArrLen - 1 == $i )
                {
                    $strTemp = $strSql;
                    unset( $arr[ $i ] );
                }
            }
            
            @session_start();
            //读取完成百分比（即现在的读取指针所指向的字节数除以总字节数）
            if( $seekSize == $partSize )
            {
                $_SESSION[ 'percentage' ] = round( $iIndex * 1.0 / $lFileSize * 100, 2 ) . '%';
                $this->getSql( $arr, $link );
            }
            //最后一次执行完后百分比强制改为100%（为避免最后一步先设置了百分百然后再等待，所以先执行，再设置百分百）
            else
           {    
           		$this->getSql( $arr, $link );
                $_SESSION[ 'percentage' ] = 100 . '%';
            }
            session_write_close();
            
            $sqlStatus = $_SESSION[ 'status' ];
            //如果某一句执行失败则停止循环
            if( $_SESSION[ 'status' ] == 0 )
            {
                file_put_contents( APP_ROOT . self::LOG_PATH, date( 'Y-m-d H:i:s' ) . $_SESSION[ 'sqlWrong' ] . '执行失败' . PHP_EOL, FILE_APPEND );
                return ReturnInfo::resInfo( 9, "<p>" . $_SESSION[ 'sqlWrong' ] . "执行失败！&nbsp;&nbsp;" . self::STR_WRONG . "</p>" );
            }
        }
        //全部循环执行成功则关闭文件，设置标记量0并返回
        fclose( $fp );
        $res[ 'status' ] = 0;
        return $res;
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2015年11月6日' )
     * @comment( comment = '从数组中遍历得到sql语句并调用执行' )    
     * @method( method = 'getSql' )
     * @op( op = 'r' )        
    */
    private function getSql( $arr, $link )
    {
        //stripos的偏移量
        $iHitOffset = 10;
        
        $strCreateTable = 'CREATE TABLE `';
        $strDropTable = 'DROP TABLE IF EXISTS `';
        $strInsertInto = 'INSERT INTO `';
        //依次执行每次循环fread出的这部分中所有完整的sql语句
        for( $i = 0; $i < count( $arr ); ++$i )
        {
            //如果$sql中存在';'并且还存在create table 或drop table 或insert into table 关键词（这句话是为了避免执行那些因为存在在语句中间的分号而分割的语句）
            if( false !== stripos( $arr[ $i ], ';', $iHitOffset ) && (
                false !== stripos( $arr[ $i ], $strCreateTable, $iHitOffset ) ||
                false != stripos( $arr[ $i ], $strDropTable, $iHitOffset ) ||
                false != stripos( $arr[ $i ], $strInsertInto, $iHitOffset ) ) )
            {
                //如果sql语句中不包含'-- ------------'，即没有被注释掉，那么就可以直接执行
                if( strstr( $arr[ $i ], '-- ------------' ) !== false )
                {
                    $this->execSQL( $arr[ $i ], $link );
                    continue;
                }
                else
               {
                    $arrSub = explode( ';', $arr[ $i ] );
                    foreach( $arrSub as $sql )
                    {
                        $this->execSQL( $sql, $link );
                    }
                }
                continue;
            }
            //$sql中不存在';'，则直接执行
            else
           {
                $this->execSQL( $arr[ $i ], $link );
            }
        }
        
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2015年11月6日' )
     * @comment( comment = '执行sql语句并将状态量和结果保存在session中' )    
     * @method( method = 'execSQL' )
     * @op( op = 'r' )        
    */
    private function execSQL( $sql, $link )
    {
        @session_start();
        if( false === mysql_query( $sql, $link ) )
        {
            $_SESSION[ 'status' ] = 0;
            $_SESSION[ 'sqlWrong' ] = $sql;
        }
        else
       {
            $_SESSION[ 'status' ] = 1;
            $_SESSION[ 'sqlWrong' ] = '';
        }
        session_write_close();
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2015年10月26日' )
     * @comment( comment = '将用户信息插入数据表' )    
     * @method( method = 'insertInfo' )
     * @op( op = 'r' )        
    */
    public function insertInfo( $n, $link, $dbName, $masterUsername, $masterPassword, $masterEmail )
    {
        mysql_select_db( $dbName );
        $sql = "INSERT INTO `".$dbName."`.`pri_users` ( `id`, `name`,`loginname`,`pwd`,`email`,`groupid`,`status`) 
                VALUES ( 1, '".$masterUsername."','".$masterUsername."','".$masterPassword."','".$masterEmail."',1,0);";
        
        if( mysql_query( $sql, $link ) )
        {
            $res = ReturnInfo::resInfo( 10,
                     "<p>第二步，管理员信息写入成功！&nbsp;&nbsp;" . self::STR_RIGHT . "</p>" );
            $res[ 'n' ] = ++$n;
            file_put_contents( APP_ROOT . self::LOG_PATH, date( 'Y-m-d H:i:s' ) . '管理员信息写入成功' . PHP_EOL, FILE_APPEND );
        }
        else
        {
            $res = ReturnInfo::resInfo( 5,
                     "<p>第二步，管理员信息写入失败，请返回上一步重新安装！&nbsp;&nbsp;" . self::STR_WRONG . "</p>" );
            file_put_contents( APP_ROOT . self::LOG_PATH, date( 'Y-m-d H:i:s' ) . '管理员信息写入失败' . PHP_EOL, FILE_APPEND );
        }
        return $res;
    }
    
}