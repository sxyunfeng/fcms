<?php
namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );
/**
 * @param string $strFilePath
 * @param int iRetType = 0
 * @return array for success 
 *          1 for tracker not active
 *          2 for 
 */
class FastdfsUpload {

    public static function uploadFile( $strFilePath, $strExt = null, $iRetType = 0 )
    {
        // 根据client.conf的配置取到一个tracker(可能是若干tracker中的一个)
        $tracker = fastdfs_tracker_get_connection();

        if( !fastdfs_active_test( $tracker ) ) // 测试该tracker是否正常工作状态
        {
            error_log( 
                    "fastdfs_active_test errno: " . fastdfs_get_last_error_no() .
                             ", error info: " . fastdfs_get_last_error_info() );

            var_dump( $tracker );

            return 1;

        }

        $storage = fastdfs_tracker_query_storage_store();
        if( !$storage )
        {
            error_log( 
                    "fastdfs_tracker_query_storage_store errno: " .
                             fastdfs_get_last_error_no() . ", error info: " .
                             fastdfs_get_last_error_info() );
            return 2;
        }

        $server = fastdfs_connect_server( $storage[ 'ip_addr' ], $storage[ 'port' ] );
        if( !$server )
        {
            error_log( 
                    "fastdfs_connect_server errno: " . fastdfs_get_last_error_no() .
                             ", error info: " . fastdfs_get_last_error_info() );
            return 3;
        }

        if( !fastdfs_active_test( $server ) )
        {
            error_log( 
                    "fastdfs_active_test errno: " . fastdfs_get_last_error_no() .
                             ", error info: " . fastdfs_get_last_error_info() );
            return 4;
        }

        $storage['sock'] = $server['sock'];
        $file_info = fastdfs_storage_upload_by_filename( $strFilePath, $strExt, 
                array(), 'group1', $tracker, $storage );
        if( !$file_info )
        {
            echo ( "fastdfs_tracker_query_storage_store errno: " .
                     fastdfs_get_last_error_no() . ", error info: " .
                     fastdfs_get_last_error_info() );
            return 5;
        }

    //     function fastdfs_storage_upload_by_filebuff( $file_buff,
    //             $file_ext_name = null,
    //             $meta_list = null,
    //             $group_name = null,
    //             $tracker_server = null,
    //             $storage_server = null ){}
        // fastdfs_disconnect_server( $server );
        // fastdfs_disconnect_server( $storage );
        // var_dump( $file_info );
        // $arrFileInfo = fastdfs_get_file_info( $file_info['group_name'],
        // $file_info[ 'filename' ] );
        // var_dump( $arrFileInfo );
        // var_dump( 'http://' . $arrFileInfo[ 'source_ip_addr' ] . '/' .
        // $file_info['group_name'] . '/' . $file_info[ 'filename' ]);
        // return array( 'group_name' => $file_info['group_name'], 'filename' =>
        // $file_info[ 'filename' ], 'source_ip_addr' => '' );

        if( !$iRetType )
        {
            return array_merge( $file_info, $storage/*, $arrFileInfo*/ );
        }
        else 
        {
            return getFileUrl( $file_info );
        }
    }


    /**
     * @param string $strFilePath
     * @param int iRetType = 0
     * @return array for success
     *          1 for tracker not active
     *          2 for
     */
    public static function uploadFileByStuff( $strFileStuff, $strExt = null, $iRetType = 0 )
    {
        // 根据client.conf的配置取到一个tracker(可能是若干tracker中的一个)
        $tracker = fastdfs_tracker_get_connection();
        if( !fastdfs_active_test( $tracker ) ) // 测试该tracker是否正常工作状态
        {
            error_log(
            "fastdfs_active_test errno: " . fastdfs_get_last_error_no() .
            ", error info: " . fastdfs_get_last_error_info() );

            return 1;

        }

        $storage = fastdfs_tracker_query_storage_store();
        if( !$storage )
        {
            error_log(
            "fastdfs_tracker_query_storage_store errno: " .
            fastdfs_get_last_error_no() . ", error info: " .
            fastdfs_get_last_error_info() );
            return 2;
        }

        $server = fastdfs_connect_server( $storage[ 'ip_addr' ], $storage[ 'port' ] );
        if( !$server )
        {
            error_log(
            "fastdfs_connect_server errno: " . fastdfs_get_last_error_no() .
            ", error info: " . fastdfs_get_last_error_info() );
            return 3;
        }

        if( !fastdfs_active_test( $server ) )
        {
            error_log(
            "fastdfs_active_test errno: " . fastdfs_get_last_error_no() .
            ", error info: " . fastdfs_get_last_error_info() );
            return 4;
        }

        $storage['sock'] = $server['sock'];
        $file_info = fastdfs_storage_upload_by_filebuff( $strFileStuff, $strExt,
                array(), 'group1', $tracker, $storage );

        if( !$file_info )
        {
            echo ( "fastdfs_tracker_query_storage_store errno: " .
                    fastdfs_get_last_error_no() . ", error info: " .
                    fastdfs_get_last_error_info() );
            return 5;
        }

        //     function fastdfs_storage_upload_by_filebuff( $file_buff,
        //             $file_ext_name = null,
        //             $meta_list = null,
        //             $group_name = null,
        //             $tracker_server = null,
        //             $storage_server = null ){}
        // fastdfs_disconnect_server( $server );
        // fastdfs_disconnect_server( $storage );
        // var_dump( $file_info );
        // $arrFileInfo = fastdfs_get_file_info( $file_info['group_name'],
        // $file_info[ 'filename' ] );
        // var_dump( $arrFileInfo );
        // var_dump( 'http://' . $arrFileInfo[ 'source_ip_addr' ] . '/' .
        // $file_info['group_name'] . '/' . $file_info[ 'filename' ]);
        // return array( 'group_name' => $file_info['group_name'], 'filename' =>
        // $file_info[ 'filename' ], 'source_ip_addr' => '' );

        if( !$iRetType )
        {
            return array_merge( $file_info, $storage/*, $arrFileInfo*/ );
        }
        else
        {
            return getFileUrl( $file_info );
        }
    } 
    /**
     * @param array $arrFileInfo
     * 
     * return string url
     */
    public static function getFileUrl( $arrFileInfo )
    {
        $arrRet = fastdfs_tracker_query_storage_fetch( $arrFileInfo[ 'group_name' ], $arrFileInfo[ 'filename' ] );

        if( !$arrRet )
        {
            return $arrRet;
        }

        return 'http://' . $arrRet[ 'ip_addr' ] . '/' . $arrFileInfo[ 'group_name' ] . '/' . $arrFileInfo[ 'filename' ];
    }
}