<?php
namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );
class ExportDbUtils
{
    /**
     * 导出数据库文件
     * @param $host         数据库连接主机
     * @param $user         数据库连接用户名
     * @param $pwd          数据库连接密码
     * @param $db           数据库名
     * @param $table        主需要导出某张表的表名
     * @param $filename     导出数据库文件的文件名
     * @param $igTabs       忽略的表数据，可以是array，也可以是string
     */
    public static function dbDump( $host, $user, $pwd, $db, $igTabs = NULL, $filename = null, $table = null ) 
    {
        $mysqlconlink = @mysql_connect( $host, $user, $pwd, true );
        if( !$mysqlconlink )
        {
            echo sprintf( 'No MySQL connection: %s', mysql_error() )."<br/>";
        }
        mysql_set_charset( 'utf8', $mysqlconlink );
        $mysqldblink = mysql_select_db( $db,$mysqlconlink );
        if( !$mysqldblink )
        {
            echo sprintf('No MySQL connection to database: %s',mysql_error())."<br/>";
        }
        $tabelstobackup = array();
        $result = mysql_query( "SHOW TABLES FROM `$db`" );
        if( !$result )
        {
            echo sprintf( 'Database error %1$s for query %2$s', mysql_error(), "SHOW TABLE STATUS FROM `$db`;" )."<br/>";
        }
        while( $data = mysql_fetch_row( $result ) )
        {
            if( empty( $table ) )
            {
                $tabelstobackup[] = $data[0];
            }
            else if( strtolower($data[0] ) == strtolower( $table ) )
            {  //only dump one table
                $tabelstobackup[] = $data[0];
                break;
            }
        }
        if( count( $tabelstobackup ) > 0 )
        {
            $result = mysql_query( "SHOW TABLE STATUS FROM `$db`" );
            if ( !$result )
            {
                echo sprintf('Database error %1$s for query %2$s', mysql_error(), "SHOW TABLE STATUS FROM `$db`;" )."<br/>";
            }
            
            while( $data = mysql_fetch_assoc( $result ) )
            {
                if( $igTabs )
                {
                    if( is_string( $igTabs ) )
                    {
                        if( trim( $igTabs ) == $data[ 'Name' ] )
                        {
                            continue;
                        }
                    }
                    else if( is_array( $igTabs ) )
                    {
                        if( in_array( $data[ 'Name' ] , $igTabs ) )
                        {
                            continue;
                        }
                    }
                }
                
                $status[ $data[ 'Name' ] ] = $data;
            }
            
            if( !isset( $filename ) )
            {
                $date = date( 'YmdHis' );
                $filename = "{$db}.{$date}.sql";
            }
            if( $file = fopen( $filename, 'wb' ) )
            {
                foreach( $tabelstobackup as $table )
                {
                    if( $igTabs )
                    {
                        if( is_string( $igTabs ) )
                        {
                            if( trim( $igTabs ) == $table )
                            {
                                continue;
                            }
                        }
                        else if( is_array( $igTabs ) )
                        {
                            if( in_array( $table , $igTabs ) )
                            {
                                continue;
                            }
                        }
                    }
                    
//                     echo sprintf( 'Dump database table "%s"',$table ).PHP_EOL;
                    self::need_free_memory( ( $status[ $table ][ 'Data_length' ] + $status[ $table ][ 'Index_length' ] ) * 3 );
                    self::_db_dump_table( $table, $status[ $table ], $file );//根据表名导出并生成数据库sql文件
                }
                
                fclose( $file );
//                 echo 'Database dump done!'.PHP_EOL;
                
                return 0;//成功
            }
            else
           {
                //echo 'Can not create database dump!'."<br/>";
                return 1;//无法导出数据库
            }
        }
        else
       {
            //echo 'No tables to dump'."<br/>";
            return 2;//数据库中没有表
        }
    }

    protected static function _db_dump_create_database( $dbname, $file )
    {
        $sql = "SHOW CREATE DATABASE `".$dbname."`";
        $result = mysql_query( $sql );
        if( !$result )
        {
            echo sprintf( 'Database error %1$s for query %2$s', mysql_error(), $sql )."<br/>";
            return false;
        }
        $dbstruc = mysql_fetch_assoc( $result );
        fwrite( $file, str_ireplace( 'CREATE DATABASE', 'CREATE DATABASE IF NOT EXISTS', $dbstruc[ 'Create Database' ] ).";\n" );
        fwrite( $file, "USE `{$dbname}`;\n" );
    }

    protected static function _db_dump_table( $table, $status, $file )
    {
        fwrite( $file, "\n" );
        fwrite( $file, "--\n" );
        fwrite( $file, "-- Table structure for table $table\n" );
        fwrite( $file, "--\n\n" );
        fwrite( $file, "DROP TABLE IF EXISTS `" . $table .  "`;\n" );
        
        $result = mysql_query( "SHOW CREATE TABLE `" . $table."`" );
        if( !$result )
        {
            echo sprintf( 'Database error %1$s for query %2$s', mysql_error(), "SHOW CREATE TABLE `".$table."`" )."<br/>";
            return false;
        }
        $tablestruc = mysql_fetch_assoc( $result );
        fwrite( $file, $tablestruc[ 'Create Table' ].";\n" );
        $result = mysql_query( "SELECT * FROM `" . $table."`" );
        if( !$result )
        {
            echo sprintf( 'Database error %1$s for query %2$s', mysql_error(), "SELECT * FROM `".$table."`" )."<br/>";
            return false;
        }
        fwrite( $file, "--\n" );
        fwrite( $file, "-- Dumping data for table $table\n" );
        fwrite( $file, "--\n\n" );
        if( $status[ 'Engine' ] == 'MyISAM' )
        {
            fwrite( $file, "/*!40000 ALTER TABLE `".$table."` DISABLE KEYS */;\n" );
        }
        while( $data = mysql_fetch_assoc( $result ) )
        {
            $keys = array();
            $values = array();
            foreach( $data as $key => $value )
            {
                if( $value === NULL )
                {
                    $value = "NULL";
                }
                elseif( $value === "" or $value === false )
                {
                    $value = "''";
                }
                elseif( !is_numeric( $value ) )
                {
                    $value = "'" . mysql_real_escape_string( $value )."'";
                }
                $values[] = $value;
            }
            fwrite( $file, "INSERT INTO `" . $table . "` VALUES ( ".implode( ", ",$values ) . " );\n" );
        }
        if( $status[ 'Engine' ] == 'MyISAM' )
        {
            fwrite( $file, "/*!40000 ALTER TABLE ".$table." ENABLE KEYS */;\n" );
        }
    }
    protected static function need_free_memory( $memneed )
    {
        if( !function_exists('memory_get_usage' ) )
        {
            return;
        }
        $needmemory = @memory_get_usage( true ) + self::inbytes( $memneed );
        if ( $needmemory > self::inbytes( ini_get('memory_limit' ) ) )
        {
            $newmemory = round( $needmemory / 1024 / 1024 ) + 1 . 'M';
            if( $needmemory >= 1073741824 )
            {
                $newmemory=round($needmemory/1024/1024/1024) .'G';
            }
            if( $oldmem = @ini_set('memory_limit', $newmemory ) )
            {
                echo sprintf( 'Memory increased from %1$s to %2$s', 'backwpup', $oldmem,@ini_get( 'memory_limit' ) ) . "<br/>";
            }
            else
           {
                echo sprintf( 'Can not increase memory limit is %1$s', 'backwpup', @ini_get( 'memory_limit' ) ) . "<br/>";
            }
        }
    }

    protected static function inbytes( $value )
    {
        $multi = strtoupper( substr( trim( $value ), -1 ) );
        $bytes = abs( ( int )trim( $value ) );
        if( $multi == 'G' )
        {
            $bytes = $bytes * 1024 * 1024 * 1024;
        }
        if( $multi == 'M' )
        {
            $bytes = $bytes * 1024 * 1024;
        }
        if( $multi == 'K' )
        {
            $bytes = $bytes * 1024;
        }
        return $bytes;
    }
}
?>