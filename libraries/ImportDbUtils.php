<?php
namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );
/**
 * 分块读取sql文件并执行（即将sql文件导入到数据库当中）
 */
class ImportDbUtils
{
    /**
     * 分块每次读取多少字节数据库文件
     * $partsize
     */
    private $partsize = 10240;
    
    /**
     * @author( author='New' )
     * @date( date = '2015年10月26日' )
     * @comment( comment = '将数据库文件导入到数据库中' )
     * @method( method = 'importDb' )
     * @op( op = 'r' )
     */
    public function importDb( $link, $file, $dbName )
    {
        mysql_select_db( $dbName, $link );
        mysql_query( 'set names utf8' );
    
        $lFileSize = filesize( $file );
    
        return $this->partlyRead( $file, $lFileSize, $link, $this->partsize );//得到每个拆分的sql语句块
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
         
        $strTemp = '';//设置临时变量用以保存每次得到的块中不完整的最后一句
        
        for( $iIndex = 0; $iIndex < $lFileSize; $iIndex += $partSize )
        {//从头到尾读取sql文件
            $seekSize = ( $lFileSize - $iIndex > $partSize ) ? $partSize : ( $lFileSize - $iIndex );
            $data = fread( $fp, $seekSize );
            $arr = preg_split( "/;[\n\r]/", $data );
            $iArrLen = count( $arr );
            
            if( $iIndex != 0 )
            {//当不是第一次取sql语句时，就将上次取的最后的一个半句与这次取的第一句的半句拼接起来，组成本地的第一句（就是完整的了）
                $arr[ 0 ] = $strTemp . $arr[ 0 ];
            }
            for( $i = 0; $i < $iArrLen; ++$i )
            {
                $strSql = $arr[ $i ];
                
                if( $iArrLen - 1 == $i )
                {//将最后一条不完整的数据存储在$strTemp中，然后释放掉
                    $strTemp = $strSql;
                    unset( $arr[ $i ] );
                }
            }
            $this->getSql( $arr, $link );//从数组中遍历得到sql语句并调用执行
        }
        
        fclose( $fp );//全部循环执行成功则关闭文件，设置标记量0并返回
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
        $iHitOffset = 10;//stripos的偏移量
    
        $strCreateTable = 'CREATE TABLE `';
        $strDropTable = 'DROP TABLE IF EXISTS `';
        $strInsertInto = 'INSERT INTO `';
        
        for( $i = 0; $i < count( $arr ); ++$i )
        {//依次执行每次循环fread出的这部分中所有完整的sql语句
            if( false !== stripos( $arr[ $i ], ';', $iHitOffset ) && (
                false !== stripos( $arr[ $i ], $strCreateTable, $iHitOffset ) ||
                false != stripos( $arr[ $i ], $strDropTable, $iHitOffset ) ||
                false != stripos( $arr[ $i ], $strInsertInto, $iHitOffset ) ) )
            {//如果$sql中存在';'并且还存在create table 或drop table 或insert into table 关键词（这句话是为了避免执行那些因为存在在语句中间的分号而分割的语句）
                if( strstr( $arr[ $i ], '-- ------------' ) !== false )
                {//如果sql语句中不包含'-- ------------'，即没有被注释掉，那么就可以直接执行
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
            else
           {//$sql中不存在';'，则直接执行
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
        if( false === mysql_query( $sql, $link ) )
        {
        	die( $sql . '执行失败，请检查' );
        }
    }
    
}
?>