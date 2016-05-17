/*
Copyright (C) 2008 Happy Fish / YuQing

FastDFS client php extension may be copied only under the terms of 
the Less GNU General Public License (LGPL).

Please visit the FastDFS Home Page for more detail.
Google code (English language): http://code.google.com/p/fastdfs/
Chinese language: http://www.csource.com/

In file fastdfs_client.ini, item fastdfs_client.tracker_group# point to
the FastDFS client config filename. Please read ../INSTALL file to know 
about how to config FastDFS client.

FastDFS client php extension compiled under PHP 5.2.x, Steps:
phpize
./configure
make
make install

#copy lib file to php extension directory, eg. /usr/lib/php/20060613/
cp modules/fastdfs_client.so  /usr/lib/php/20060613/

#copy fastdfs_client.ini to PHP etc directory, eg. /etc/php/
cp fastdfs_client.ini /etc/php/

#modify config file fastdfs_client.ini, such as:
vi /etc/php/fastdfs_client.ini

#run fastdfs_test.php
php fastdfs_test.php


FastDFS PHP functions:
*/
<?php

/**
 * return string:client library version
 */
function fastdfs_client_version()
{
}

/**
 * return long:last error no
 */
function fastdfs_get_last_error_no()
{
}

/**
 * return string:last error info
 */
function fastdfs_get_last_error_info()
{
}

/**
 * generate anti-steal token for HTTP download
 * 
 * @param
 *            string remote_filename: the remote filename (do NOT including
 *            group name)
 * @param
 *            string timestamp: the timestamp (unix timestamp)
 *            return token string for success, false for error
 */
function fastdfs_http_gen_token( $remote_filename, $timestamp )
{
}

/**
 * get file info from the filename
 *
 * @param
 *            string group_name: the group name of the file
 * @param
 *            remote_filename: the filename on the storage server
 *            
 *            return assoc array for success, false for error.
 *            the assoc array including following elements:
 *            create_timestamp: the file create timestamp (unix timestamp)
 *            file_size: the file size (bytes)
 *            source_ip_addr: the source storage server ip address
 */
function fastdfs_get_file_info( $group_name, $filename )
{
}

/**
 * get file info from the file id
 *
 * @param
 *            string file_id: the file id (including group name and filename) or
 *            remote filename
 *            
 *            return assoc array for success, false for error.
 *            the assoc array including following elements:
 *            create_timestamp: the file create timestamp (unix timestamp)
 *            file_size: the file size (bytes)
 *            source_ip_addr: the source storage server ip address
 */
function fastdfs_get_file_info1( $file_id )
{
}

/**
 * parameters:
 * sock: the unix socket description
 * buff: the buff to send
 * return true for success, false for error
 */
function fastdfs_send_data( $sock, $buff )
{
}

/**
 * generate slave filename by master filename, prefix name and file extension
 * name
 * parameters:
 * master_filename: the master filename / file id to generate
 * the slave filename
 * prefix_name: the prefix name to generate the slave filename
 * file_ext_name: slave file extension name, can be null or emtpy
 * (do not including dot)
 * return slave filename string for success, false for error
 */
function fastdfs_gen_slave_filename( $master_filename, $prefix_name, 
        $file_ext_name = null )
{
}

/**
 * check file exist
 * parameters:
 * group_name: the group name of the file
 * remote_filename: the filename on the storage server
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for exist, false for not exist
 */
function fastdfs_storage_file_exist( $group_name, $remote_filename, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * parameters:
 * file_id: the file id of the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for exist, false for not exist
 */
function fastdfs_storage_file_exist1( $file_id, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * upload local file to storage server
 * parameters:
 * local_filename: the local filename
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * group_name: specify the group name to store the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error.
 * the returned array includes elements: group_name and filename
 */
function fastdfs_storage_upload_by_filename( $local_filename, 
        $file_ext_name = null, $meta_list = null, $group_name = null, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * upload local file to storage server
 * parameters:
 * local_filename: the local filename
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * group_name: specify the group name to store the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return file_id for success, false for error.
 */
function fastdfs_storage_upload_by_filename1( $local_filename, 
        $file_ext_name = null, $meta_list = null, $group_name = null, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * upload file buff to storage server
 * parameters:
 * file_buff: the file content
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * group_name: specify the group name to store the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error.
 * the returned array includes elements: group_name and filename
 */
function fastdfs_storage_upload_by_filebuff( $file_buff, $file_ext_name = null, 
        $meta_list = null, $group_name = null, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * upload file buff to storage server
 * parameters:
 * file_buff: the file content
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * group_name: specify the group name to store the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return file_id for success, false for error
 */
function fastdfs_storage_upload_by_filebuff1( $file_buff, $file_ext_name = null, 
        $meta_list = null, $group_name = null, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * upload file to storage server by callback
 * parameters:
 * callback_array: the callback assoc array, must have keys:
 * callback - the php callback function name
 * callback function prototype as:
 * function upload_file_callback($sock, $args)
 * file_size - the file size
 * args - use argument for callback function
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * group_name: specify the group name to store the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error.
 * the returned array includes elements: group_name and filename
 */
function fastdfs_storage_upload_by_callback( $callback_array, 
        $file_ext_name = null, $meta_list = null, $group_name = null, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * upload file to storage server by callback
 * parameters:
 * callback_array: the callback assoc array, must have keys:
 * callback - the php callback function name
 * callback function prototype as:
 * function upload_file_callback($sock, $args)
 * file_size - the file size
 * args - use argument for callback function
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * group_name: specify the group name to store the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return file_id for success, false for error
 */
function fastdfs_storage_upload_by_callback1( $callback_array, 
        $file_ext_name = null, $meta_list = null, $group_name = null, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * upload local file to storage server as appender file
 * parameters:
 * local_filename: the local filename
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * group_name: specify the group name to store the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error.
 * the returned array includes elements: group_name and filename
 */
function fastdfs_storage_upload_appender_by_filename( $local_filename, 
        $file_ext_name = null, $meta_list = null, $group_name = null, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * upload local file to storage server as appender file
 * parameters:
 * local_filename: the local filename
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * group_name: specify the group name to store the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return file_id for success, false for error.
 */
function fastdfs_storage_upload_appender_by_filename1( $local_filename, 
        $file_ext_name = null, $meta_list = null, $group_name = null, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * upload file buff to storage server as appender file
 * parameters:
 * file_buff: the file content
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * group_name: specify the group name to store the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error.
 * the returned array includes elements: group_name and filename
 */
function fastdfs_storage_upload_appender_by_filebuff( $file_buff, 
        $file_ext_name = null, $meta_list = null, $group_name = null, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * upload file buff to storage server as appender file
 * parameters:
 * file_buff: the file content
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * group_name: specify the group name to store the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return file_id for success, false for error
 */
function fastdfs_storage_upload_appender_by_filebuff1( $file_buff, 
        $file_ext_name = null, $meta_list = null, $group_name = null, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * upload file to storage server by callback as appender file
 * parameters:
 * callback_array: the callback assoc array, must have keys:
 * callback - the php callback function name
 * callback function prototype as:
 * function upload_file_callback($sock, $args)
 * file_size - the file size
 * args - use argument for callback function
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * group_name: specify the group name to store the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error.
 * the returned array includes elements: group_name and filename
 */
function fastdfs_storage_upload_appender_by_callback( $callback_array, 
        $file_ext_name = null, $meta_list = null, $group_name = null, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * upload file to storage server by callback as appender file
 * parameters:
 * callback_array: the callback assoc array, must have keys:
 * callback - the php callback function name
 * callback function prototype as:
 * function upload_file_callback($sock, $args)
 * file_size - the file size
 * args - use argument for callback function
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * group_name: specify the group name to store the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return file_id for success, false for error
 */
function fastdfs_storage_upload_appender_by_callback1( $callback_array, 
        $file_ext_name = null, $meta_list = null, $group_name = null, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * append local file to the appender file of storage server
 * parameters:
 * local_filename: the local filename
 * group_name: the the group name of appender file
 * appender_filename: the appender filename
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_append_by_filename( $local_filename, $group_name, 
        $appender_filename, $tracker_server = null, $storage_server = null )
{
}

/**
 * append local file to the appender file of storage server
 * parameters:
 * local_filename: the local filename
 * appender_file_id: the appender file id
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_append_by_filename1( $local_filename, $appender_file_id, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * append file buff to the appender file of storage server
 * parameters:
 * file_buff: the file content
 * group_name: the the group name of appender file
 * appender_filename: the appender filename
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_append_by_filebuff( $file_buff, $group_name, 
        $appender_filename, $tracker_server = null, $storage_server = null )
{
}

/**
 * append file buff to the appender file of storage server
 * parameters:
 * file_buff: the file content
 * appender_file_id: the appender file id
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_append_by_filebuff1( $file_buff, $appender_file_id, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * append file to the appender file of storage server by callback
 * parameters:
 * callback_array: the callback assoc array, must have keys:
 * callback - the php callback function name
 * callback function prototype as:
 * function upload_file_callback($sock, $args)
 * file_size - the file size
 * args - use argument for callback function
 * group_name: the the group name of appender file
 * appender_filename: the appender filename
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_append_by_callback( $callback_array, $group_name, 
        $appender_filename, $tracker_server = null, $storage_server = null )
{
}

/**
 * append file buff to the appender file of storage server
 * parameters:
 * callback_array: the callback assoc array, must have keys:
 * callback - the php callback function name
 * callback function prototype as:
 * function upload_file_callback($sock, $args)
 * file_size - the file size
 * args - use argument for callback function
 * appender_file_id: the appender file id
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_append_by_callback1( $callback_array, $appender_file_id, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * modify appender file by local file
 * parameters:
 * local_filename: the local filename
 * file_offset: offset of appender file
 * group_name: the the group name of appender file
 * appender_filename: the appender filename
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_modify_by_filename( $local_filename, $file_offset, 
        $group_name, $appender_filename, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * modify appender file by local file
 * parameters:
 * local_filename: the local filename
 * file_offset: offset of appender file
 * appender_file_id: the appender file id
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_modify_by_filename1( $local_filename, $file_offset, 
        $appender_file_id, $tracker_server = null, $storage_server = null )
{
}

/**
 * modify appender file by file buff
 * parameters:
 * file_buff: the file content
 * file_offset: offset of appender file
 * group_name: the the group name of appender file
 * appender_filename: the appender filename
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_modify_by_filebuff( $file_buff, $file_offset, 
        $group_name, $appender_filename, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * modify appender file by file buff
 * parameters:
 * file_buff: the file content
 * file_offset: offset of appender file
 * appender_file_id: the appender file id
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_modify_by_filebuff1( $file_buff, $file_offset, 
        $appender_file_id, $tracker_server = null, $storage_server = null )
{
}

/**
 * modify appender file by callback
 * parameters:
 * callback_array: the callback assoc array, must have keys:
 * callback - the php callback function name
 * callback function prototype as:
 * function upload_file_callback($sock, $args)
 * file_size - the file size
 * args - use argument for callback function
 * file_offset: offset of appender file
 * group_name: the the group name of appender file
 * appender_filename: the appender filename
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_modify_by_callback( $callback_array, $file_offset, 
        $group_name, $appender_filename, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * modify appender file by callback
 * parameters:
 * callback_array: the callback assoc array, must have keys:
 * callback - the php callback function name
 * callback function prototype as:
 * function upload_file_callback($sock, $args)
 * file_size - the file size
 * args - use argument for callback function
 * file_offset: offset of appender file
 * appender_file_id: the appender file id
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_modify_by_callback1( $callback_array, $file_offset, 
        $group_name, $appender_filename, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * truncate appender file to specify size
 * parameters:
 * group_name: the the group name of appender file
 * appender_filename: the appender filename
 * truncated_file_size: truncate the file size to
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_truncate_file( $group_name, $appender_filename, 
        $truncated_file_size = 0, $tracker_server = null, $storage_server )
{
}

/**
 * truncate appender file to specify size
 * parameters:
 * appender_file_id: the appender file id
 * truncated_file_size: truncate the file size to
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 * 
 * @param unknown $appender_file_id            
 * @param number $truncated_file_size            
 * @param string $tracker_server            
 * @param string $storage_server            
 */
function fastdfs_storage_truncate_file1( $appender_file_id, 
        $truncated_file_size = 0, $tracker_server = null, $storage_server = null )
{
}

/**
 * upload local file to storage server (slave file mode)
 * parameters:
 * file_buff: the file content
 * group_name: the group name of the master file
 * master_filename: the master filename to generate the slave file id
 * prefix_name: the prefix name to generage the slave file id
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error.
 * the returned array includes elements: group_name and filename
 */
function fastdfs_storage_upload_slave_by_filename( $local_filename, $group_name, 
        $master_filename, $prefix_name, $file_ext_name, $meta_list = null, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * upload local file to storage server (slave file mode)
 * parameters:
 * local_filename: the local filename
 * master_file_id: the master file id to generate the slave file id
 * prefix_name: the prefix name to generage the slave file id
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return file_id for success, false for error.
 */
function fastdfs_storage_upload_slave_by_filename1( $local_filename, 
        $master_file_id, $prefix_name, $file_ext_name = null, $meta_list = null, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * upload file buff to storage server (slave file mode)
 * parameters:
 * file_buff: the file content
 * group_name: the group name of the master file
 * master_filename: the master filename to generate the slave file id
 * prefix_name: the prefix name to generage the slave file id
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error.
 * the returned array includes elements: group_name and filename
 */
function fastdfs_storage_upload_slave_by_filebuff( $file_buff, $group_name, 
        $master_filename, $prefix_name, $file_ext_name = null, $meta_list = null, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * upload file buff to storage server (slave file mode)
 * parameters:
 * file_buff: the file content
 * master_file_id: the master file id to generate the slave file id
 * prefix_name: the prefix name to generage the slave file id
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return file_id for success, false for error
 */
function fastdfs_storage_upload_slave_by_filebuff1( $file_buff, $master_file_id, 
        $prefix_name, $file_ext_name = null, $meta_list = null, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * upload file to storage server by callback (slave file mode)
 * parameters:
 * callback_array: the callback assoc array, must have keys:
 * callback - the php callback function name
 * callback function prototype as:
 * function upload_file_callback($sock, $args)
 * file_size - the file size
 * args - use argument for callback function
 * group_name: the group name of the master file
 * master_filename: the master filename to generate the slave file id
 * prefix_name: the prefix name to generage the slave file id
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error.
 * the returned array includes elements: group_name and filename
 */
function fastdfs_storage_upload_slave_by_callback( $callback_array, $group_name, 
        $master_filename, $prefix_name, $file_ext_name = null, $meta_list = null, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * upload file to storage server by callback (slave file mode)
 * parameters:
 * callback_array: the callback assoc array, must have keys:
 * callback - the php callback function name
 * callback function prototype as:
 * function upload_file_callback($sock, $args)
 * file_size - the file size
 * args - use argument for callback function
 * master_file_id: the master file id to generate the slave file id
 * prefix_name: the prefix name to generage the slave file id
 * file_ext_name: the file extension name, do not include dot(.)
 * meta_list: meta data assoc array, such as
 * array('width'=>1024, 'height'=>768)
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return file_id for success, false for error
 */
function fastdfs_storage_upload_slave_by_callback1( $callback_array, 
        $master_file_id, $prefix_name, $file_ext_name = null, $meta_list = null, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * delete file from storage server
 * parameters:
 * group_name: the group name of the file
 * remote_filename: the filename on the storage server
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_delete_file( $group_name, $remote_filename, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * delete file from storage server
 * parameters:
 * file_id: the file id to be deleted
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_delete_file1( $file_id, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * get file content from storage server
 * parameters:
 * group_name: the group name of the file
 * remote_filename: the filename on the storage server
 * file_offset: file start offset, default value is 0
 * download_bytes: 0 (default value) means from the file offset to
 * the file end
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return the file content for success, false for error
 */
function fastdfs_storage_download_file_to_buff( $group_name, $remote_filename, 
        $file_offset = 0, $download_bytes = 0, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * get file content from storage server
 * parameters:
 * file_id: the file id of the file
 * file_offset: file start offset, default value is 0
 * download_bytes: 0 (default value) means from the file offset to
 * the file end
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return the file content for success, false for error
 */
function fastdfs_storage_download_file_to_buff1( $file_id, $file_offset = 0, 
        $download_bytes = 0, $tracker_serve = null, $storage_server = null )
{
}

/**
 * download file from storage server to local file
 * parameters:
 * group_name: the group name of the file
 * remote_filename: the filename on the storage server
 * local_filename: the local filename to save the file content
 * file_offset: file start offset, default value is 0
 * download_bytes: 0 (default value) means from the file offset to
 * the file end
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_download_file_to_file( $group_name, $remote_filename, 
        $local_filename, $file_offset = 0, $download_bytes = 0, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * download file from storage server to local file
 * parameters:
 * file_id: the file id of the file
 * local_filename: the local filename to save the file content
 * file_offset: file start offset, default value is 0
 * download_bytes: 0 (default value) means from the file offset to
 * the file end
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_download_file_to_file1( $file_id, $local_filename, 
        $file_offset = 0, $download_bytes = 0, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * parameters:
 * group_name: the group name of the file
 * remote_filename: the filename on the storage server
 * download_callback: the download callback array, elements as:
 * callback - the php callback function name
 * callback function prototype as:
 * function my_download_file_callback($args, $file_size, $data)
 * args - use argument for callback function
 * file_offset: file start offset, default value is 0
 * download_bytes: 0 (default value) means from the file offset to
 * the file end
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_download_file_to_callback( $group_name, 
        $remote_filename, $download_callback, $file_offset = 0, 
        $download_bytes = 0, $tracker_server = null, $storage_server = null )
{
}

/**
 * parameters:
 * file_id: the file id of the file
 * download_callback: the download callback array, elements as:
 * callback - the php callback function name
 * callback function prototype as:
 * function my_download_file_callback($args, $file_size, $data)
 * args - use argument for callback function
 * file_offset: file start offset, default value is 0
 * download_bytes: 0 (default value) means from the file offset to
 * the file end
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_storage_download_file_to_callback1( $file_id, 
        $download_callback, $file_offset = 0, $download_bytes = 0, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * set meta data of the file
 * parameters:
 * group_name: the group name of the file
 * remote_filename: the filename on the storage server
 * meta_list: meta data assoc array to be set, such as
 * array('width'=>1024, 'height'=>768)
 * op_type: operate flag, can be one of following flags:
 * FDFS_STORAGE_SET_METADATA_FLAG_MERGE: combined with the old meta data
 * FDFS_STORAGE_SET_METADATA_FLAG_OVERWRITE: overwrite the old meta data
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 * 
 * @param unknown $group_name            
 * @param unknown $remote_filename            
 * @param unknown $op_type            
 * @param unknown $tracker_server            
 */
function fastdfs_storage_set_metadata( $group_name, $remote_filename, $meta_list, 
        $op_type = null, $tracker_server = null, $storage_server = null )
{
}

/**
 * set meta data of the file
 * parameters:
 * file_id: the file id of the file
 * meta_list: meta data assoc array to be set, such as
 * array('width'=>1024, 'height'=>768)
 * op_type: operate flag, can be one of following flags:
 * FDFS_STORAGE_SET_METADATA_FLAG_MERGE: combined with the old meta data
 * FDFS_STORAGE_SET_METADATA_FLAG_OVERWRITE: overwrite the old meta data
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 * 
 * @param unknown $op_type            
 * @param unknown $tracker_server            
 * @param unknown $storage_server            
 */
function fastdfs_storage_set_metadata1( $file_id, $meta_list, $op_type = null, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * get meta data of the file
 * parameters:
 * group_name: the group name of the file
 * remote_filename: the filename on the storage server
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error
 * returned array like: array('width' => 1024, 'height' => 768)
 * 
 * @param unknown $tracker_server            
 * @param unknown $storage_server            
 */
function fastdfs_storage_get_metadata( $group_name, $remote_filename, 
        $tracker_server = null, $storage_server = null )
{
}

/**
 * get meta data of the file
 * parameters:
 * file_id: the file id of the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * storage_server: the storage server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error
 * returned array like: array('width' => 1024, 'height' => 768)
 * 
 * @param unknown $tracker_server            
 * @param unknown $storage_server            
 */
function fastdfs_storage_get_metadata1( $file_id, $tracker_server = null, 
        $storage_server = null )
{
}

/**
 * connect to the server
 * parameters:
 * ip_addr: the ip address of the server
 * port: the port of the server
 * return assoc array for success, false for error
 */
function fastdfs_connect_server( $ip_addr, $port )
{
}

/**
 * disconnect from the server
 * parameters:
 * server_info: the assoc array including elements:
 * ip_addr, port and sock
 * return true for success, false for error
 */
function fastdfs_disconnect_server( $server_info )
{
}

/**
 * send ACTIVE_TEST cmd to the server
 * parameters:
 * server_info: the assoc array including elements:
 * ip_addr, port and sock, sock must be connected
 * return true for success, false for error
 */
function fastdfs_active_test( $server_info )
{
}

/**
 * get a connected tracker server
 * return assoc array for success, false for error
 * the assoc array including elements: ip_addr, port and sock
 */
function fastdfs_tracker_get_connection()
{
}

/**
 * connect to all tracker servers
 * return true for success, false for error
 */
function fastdfs_tracker_make_all_connections()
{
}

/**
 * close all connections to the tracker servers
 * return true for success, false for error
 */
function fastdfs_tracker_close_all_connections()
{
}

/**
 * get group stat info
 * parameters:
 * group_name: specify the group name, null or empty string means all groups
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * return index array for success, false for error, each group as a array
 * element
 */
function fastdfs_tracker_list_groups( $group_name = null, $tracker_server = null )
{
}

/**
 * get the storage server info to upload file
 * parameters:
 * group_name: specify the group name
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error. the assoc array including
 * elements: ip_addr, port, sock and store_path_index
 */
function fastdfs_tracker_query_storage_store( $group_name = null, 
        $tracker_server = array() )
{
}

/**
 * get the storage server list to upload file
 * parameters:
 * group_name: specify the group name
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * return indexed storage server array for success, false for error.
 * each element is an ssoc array including elements:
 * ip_addr, port, sock and store_path_index
 */
function fastdfs_tracker_query_storage_store_list( $group_name = null, 
        $tracker_server = array() )
{
}

/**
 * get the storage server info to set metadata
 * parameters:
 * group_name: the group name of the file
 * remote_filename: the filename on the storage server
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error
 * the assoc array including elements: ip_addr, port and sock
 */
function fastdfs_tracker_query_storage_update( $group_name, $remote_filename, 
        $tracker_server = null )
{
}

/**
 * get the storage server info to set metadata
 * parameters:
 * file_id: the file id of the file
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error
 * the assoc array including elements: ip_addr, port and sock
 */
function fastdfs_tracker_query_storage_update1( $file_id, $tracker_server = null )
{
}

/**
 * get the storage server info to download file (or get metadata)
 * parameters:
 * group_name: the group name of the file
 * remote_filename: the filename on the storage server
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error
 * the assoc array including elements: ip_addr, port and sock
 */
function fastdfs_tracker_query_storage_fetch( $group_name, $remote_filename, 
        $tracker_server = null )
{
}

/**
 * get the storage server info to download file (or get metadata)
 * parameters:
 * file_id: the file id of the file
 * remote_filename: the filename on the storage server
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * return assoc array for success, false for error
 * the assoc array including elements: ip_addr, port and sock
 */
function fastdfs_tracker_query_storage_fetch1( $file_id, $tracker_server = null )
{
}

/**
 * get the storage server list which can retrieve the file content or metadata
 * parameters:
 * group_name: the group name of the file
 * remote_filename: the filename on the storage server
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * return index array for success, false for error.
 * each server as an array element
 */
function fastdfs_tracker_query_storage_list( $group_name, $remote_filename, 
        $tracker_server = null )
{
}

/**
 * get the storage server list which can retrieve the file content or metadata
 * parameters:
 * file_id: the file id of the file
 * remote_filename: the filename on the storage server
 * tracker_server: the tracker server assoc array including elements:
 * ip_addr, port and sock
 * return index array for success, false for error.
 * each server as an array element
 */
function fastdfs_tracker_query_storage_list1( $file_id, $tracker_server = null )
{
}

/**
 * delete the storage server from the cluster
 * parameters:
 * group_name: the group name of the storage server
 * storage_ip: the ip address of the storage server to be deleted
 * return true for success, false for error
 */
function fastdfs_tracker_delete_storage( $group_name, $storage_ip )
{
}


class FastDFS
{

    public function __construct( $config_index = 0, $bMultiThread = false )
    {
    }

    /**
     * return last error no
     */
    public function get_last_error_no()
    {
    }

    /**
     * return last error info
     */
    public function get_last_error_info()
    {
    }

    /**
     * parameters:
     * sock: the unix socket description
     * buff: the buff to send
     * return true for success, false for error
     */
    public function send_data( $sock, $buff )
    {
    }

    /**
     * generate anti-steal token for HTTP download
     * parameters:
     * remote_filename: the remote filename (do NOT including group name)
     * timestamp: the timestamp (unix timestamp)
     * return token string for success, false for error
     * 
     * @param unknown $remote_filename            
     * @param unknown $timestamp            
     */
    public function http_gen_token( $remote_filename, $timestamp )
    {
    }

    /**
     * get file info from the filename
     * parameters:
     * group_name: the group name of the file
     * remote_filename: the filename on the storage server
     * return assoc array for success, false for error.
     * the assoc array including following elements:
     * create_timestamp: the file create timestamp (unix timestamp)
     * file_size: the file size (bytes)
     * source_ip_addr ){} the source storage server ip address
     * crc32: the crc32 signature of the file
     * 
     * @param unknown $group_name            
     * @param unknown $filename            
     */
    public function get_file_info( $group_name, $filename )
    {
    }

    /**
     * get file info from the file id
     * parameters:
     * file_id: the file id (including group name and filename) or remote
     * filename
     * return assoc array for success, false for error.
     *
     * the assoc array including following elements:
     * create_timestamp: the file create timestamp (unix timestamp)
     * file_size: the file size (bytes)
     * source_ip_addr: the source storage server ip address
     * 
     * @param unknown $file_id            
     */
    public function get_file_info1( $file_id )
    {
    }

    /**
     * generate slave filename by master filename, prefix name and file
     * extension name
     * parameters:
     * master_filename: the master filename / file id to generate
     * the slave filename
     * prefix_name: the prefix name to generate the slave filename
     * file_ext_name: slave file extension name, can be null or emtpy
     * (do not including dot)
     * return slave filename string for success, false for error
     * 
     * @param unknown $file_ext_name            
     */
    public function gen_slave_filename( $master_filename, $prefix_name, 
            $file_ext_name = null )
    {
    }

    /**
     * check file exist
     * parameters:
     * group_name: the group name of the file
     * remote_filename: the filename on the storage server
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for exist, false for not exist
     * 
     * @param unknown $tracker_server            
     * @param unknown $storage_server            
     */
    public function storage_file_exist( $group_name, $remote_filename, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * parameters:
     * file_id: the file id of the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for exist, false for not exist
     * 
     * @param unknown $tracker_server            
     * @param unknown $storage_server            
     */
    public function storage_file_exist1( $file_id, $tracker_server = null, 
            $storage_server = null )
    {
    }

    /**
     * upload local file to storage server
     * parameters:
     * local_filename: the local filename
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * group_name: specify the group name to store the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error.
     * the returned array includes elements: group_name and filename
     */
    public function storage_upload_by_filename( $local_filename, 
            $file_ext_name = null, $meta_list = null, $group_name = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload local file to storage server
     * parameters:
     * local_filename: the local filename
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * group_name: specify the group name to store the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return file_id for success, false for error.
     */
    public function storage_upload_by_filename1( $local_filename, $file_ext_name, 
            $meta_list, $group_name, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload file buff to storage server
     * parameters:
     * file_buff: the file content
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * group_name: specify the group name to store the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error.
     * the returned array includes elements: group_name and filename
     */
    public function storage_upload_by_filebuff( $file_buff, 
            $file_ext_name = null, $meta_list = null, $group_name = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload file buff to storage server
     * parameters:
     * file_buff: the file content
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * group_name: specify the group name to store the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return file_id for success, false for error
     */
    public function storage_upload_by_filebuff1( $file_buff, 
            $file_ext_name = null, $meta_list = null, $group_name = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload file to storage server by callback
     * parameters:
     * callback_array: the callback assoc array, must have keys:
     * callback - the php callback function name
     * callback function prototype as:
     * function upload_file_callback($sock, $args)
     * file_size - the file size
     * args - use argument for callback function
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * group_name: specify the group name to store the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error.
     * the returned array includes elements: group_name and filename
     */
    public function storage_upload_by_callback( $callback_array, 
            $file_ext_name = null, $meta_list = null, $group_name = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload file to storage server by callback
     * parameters:
     * callback_array: the callback assoc array, must have keys:
     * callback - the php callback function name
     * callback function prototype as:
     * function upload_file_callback($sock, $args)
     * file_size - the file size
     * args - use argument for callback function
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * group_name: specify the group name to store the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return file_id for success, false for error
     */
    public function storage_upload_by_callback1( $callback_array, 
            $file_ext_name = null, $meta_list = null, $group_name = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload local file to storage server as appender file
     * parameters:
     * local_filename: the local filename
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * group_name: specify the group name to store the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error.
     * the returned array includes elements: group_name and filename
     */
    public function storage_upload_appender_by_filename( $local_filename, 
            $file_ext_name = null, $meta_list = null, $group_name = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload local file to storage server as appender file
     * parameters:
     * local_filename: the local filename
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * group_name: specify the group name to store the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return file_id for success, false for error.
     * 
     * @param unknown $local_filename            
     * @param unknown $file_ext_name            
     * @param unknown $meta_list            
     * @param unknown $group_name            
     * @param unknown $tracker_server            
     * @param unknown $storage_server            
     */
    public function storage_upload_appender_by_filename1( $local_filename, 
            $file_ext_name = null, $meta_list = null, $group_name = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload file buff to storage server as appender file
     * parameters:
     * file_buff: the file content
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * group_name: specify the group name to store the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error.
     * the returned array includes elements: group_name and filename
     */
    public function storage_upload_appender_by_filebuff( $file_buff, 
            $file_ext_name = null, $meta_list = null, $group_name = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload file buff to storage server as appender file
     * parameters:
     * file_buff: the file content
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * group_name: specify the group name to store the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return file_id for success, false for error
     */
    public function storage_upload_appender_by_filebuff1( $file_buff, 
            $file_ext_name = null, $meta_list = null, $group_name = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload file to storage server by callback as appender file
     * parameters:
     * callback_array: the callback assoc array, must have keys:
     * callback - the php callback function name
     * callback function prototype as:
     * function upload_file_callback($sock, $args)
     * file_size - the file size
     * args - use argument for callback function
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * group_name: specify the group name to store the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error.
     * the returned array includes elements: group_name and filename
     */
    public function storage_upload_appender_by_callback( $callback_array, 
            $file_ext_name = null, $meta_list = null, $group_name = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload file to storage server by callback as appender file
     * parameters:
     * callback_array: the callback assoc array, must have keys:
     * callback - the php callback function name
     * callback function prototype as:
     * function upload_file_callback($sock, $args)
     * file_size - the file size
     * args - use argument for callback function
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * group_name: specify the group name to store the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return file_id for success, false for error
     */
    public function storage_upload_appender_by_callback1( $callback_array, 
            $file_ext_name = null, $meta_list = null, $group_name = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * append local file to the appender file of storage server
     * parameters:
     * local_filename: the local filename
     * group_name: the the group name of appender file
     * appender_filename: the appender filename
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_append_by_filename( $local_filename, $group_name, 
            $appender_filename, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * append local file to the appender file of storage server
     * parameters:
     * local_filename: the local filename
     * appender_file_id: the appender file id
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    // public function storage_upload_by_filename1($local_filename,
    // $appender_file_id = null, $tracker_server = null, $storage_server =
    // null){}
    /**
     * append file buff to the appender file of storage server
     * parameters:
     * file_buff: the file content
     * group_name: the the group name of appender file
     * appender_filename: the appender filename
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_append_by_filebuff( $file_buff, $group_name, 
            $appender_filename, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * append file buff to the appender file of storage server
     * parameters:
     * file_buff: the file content
     * appender_file_id: the appender file id
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_append_by_filebuff1( $file_buff, $appender_file_id, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * append file to the appender file of storage server by callback
     * parameters:
     * callback_array: the callback assoc array, must have keys:
     * callback - the php callback function name
     * callback function prototype as:
     * function upload_file_callback($sock, $args)
     * file_size - the file size
     * args - use argument for callback function
     * group_name: the the group name of appender file
     * appender_filename: the appender filename
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_append_by_callback( $callback_array, $group_name, 
            $appender_filename, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * append file buff to the appender file of storage server
     * parameters:
     * callback_array: the callback assoc array, must have keys:
     * callback - the php callback function name
     * callback function prototype as:
     * function upload_file_callback($sock, $args)
     * file_size - the file size
     * args - use argument for callback function
     * appender_file_id: the appender file id
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_append_by_callback1( $callback_array, 
            $appender_file_id, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * modify appender file by local file
     * parameters:
     * local_filename: the local filename
     * file_offset: offset of appender file
     * group_name: the the group name of appender file
     * appender_filename: the appender filename
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_modify_by_filename( $local_filename, $file_offset, 
            $group_name, $appender_filename, $tracker_server = null, 
            $storage_server = null )
    {
    }

    /**
     * modify appender file by local file
     * parameters:
     * local_filename: the local filename
     * file_offset: offset of appender file
     * appender_file_id: the appender file id
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_modify_by_filename1( $local_filename, $file_offset, 
            $appender_file_id, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * modify appender file by file buff
     * parameters:
     * file_buff: the file content
     * file_offset: offset of appender file
     * group_name: the the group name of appender file
     * appender_filename: the appender filename
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_modify_by_filebuff( $file_buff, $file_offset, 
            $group_name, $appender_filename, $tracker_server = null, 
            $storage_server = null )
    {
    }

    /**
     * modify appender file by file buff
     * parameters:
     * file_buff: the file content
     * file_offset: offset of appender file
     * appender_file_id: the appender file id
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_modify_by_filebuff1( $file_buff, $file_offset, 
            $appender_file_id, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * modify appender file by callback
     * parameters:
     * callback_array: the callback assoc array, must have keys:
     * callback - the php callback function name
     * callback function prototype as:
     * function upload_file_callback($sock, $args)
     * file_size - the file size
     * args - use argument for callback function
     * file_offset: offset of appender file
     * group_name: the the group name of appender file
     * appender_filename: the appender filename
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_modify_by_callback( $callback_array, $file_offset, 
            $group_name, $appender_filename, $tracker_server = null, 
            $storage_server = null )
    {
    }

    /**
     * modify appender file by callback
     * parameters:
     * callback_array: the callback assoc array, must have keys:
     * callback - the php callback function name
     * callback function prototype as:
     * function upload_file_callback($sock, $args)
     * file_size - the file size
     * args - use argument for callback function
     * file_offset: offset of appender file
     * appender_file_id: the appender file id
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_modify_by_callback1( $callback_array, $file_offset, 
            $group_name, $appender_filename, $tracker_server = null, 
            $storage_server = null )
    {
    }

    /**
     * truncate appender file to specify size
     * parameters:
     * group_name: the the group name of appender file
     * appender_filename: the appender filename
     * truncated_file_size: truncate the file size to
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_truncate_file( $group_name, $appender_filename, 
            $truncated_file_size = 0, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * truncate appender file to specify size
     * parameters:
     * appender_file_id: the appender file id
     * truncated_file_size: truncate the file size to
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     * 
     * @param unknown $tracker_server            
     * @param unknown $storage_server            
     */
    public function storage_truncate_file1( $appender_file_id, 
            $truncated_file_size = 0, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload local file to storage server (slave file mode)
     * parameters:
     * file_buff: the file content
     * group_name: the group name of the master file
     * master_filename: the master filename to generate the slave file id
     * prefix_name: the prefix name to generage the slave file id
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error.
     * the returned array includes elements: group_name and filename
     */
    public function storage_upload_slave_by_filename( $local_filename, 
            $group_name, $master_filename, $prefix_name, $file_ext_name = null, 
            $meta_list = null, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload local file to storage server (slave file mode)
     * parameters:
     * local_filename: the local filename
     * master_file_id: the master file id to generate the slave file id
     * prefix_name: the prefix name to generage the slave file id
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return file_id for success, false for error.
     */
    public function storage_upload_slave_by_filename1( $local_filename, 
            $master_file_id, $prefix_name, $file_ext_name = null, $meta_list = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload file buff to storage server (slave file mode)
     * parameters:
     * file_buff: the file content
     * group_name: the group name of the master file
     * master_filename: the master filename to generate the slave file id
     * prefix_name: the prefix name to generage the slave file id
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error.
     * the returned array includes elements: group_name and filename
     */
    public function storage_upload_slave_by_filebuff( $file_buff, $group_name, 
            $master_filename, $prefix_name, $file_ext_name = null, $meta_list = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload file buff to storage server (slave file mode)
     * parameters:
     * file_buff: the file content
     * master_file_id: the master file id to generate the slave file id
     * prefix_name: the prefix name to generage the slave file id
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return file_id for success, false for error
     */
    public function storage_upload_slave_by_filebuff1( $file_buff, 
            $master_file_id, $prefix_name, $file_ext_name = null, $meta_list = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload file to storage server by callback (slave file mode)
     * parameters:
     * callback_array: the callback assoc array, must have keys:
     * callback - the php callback function name
     * callback function prototype as:
     * function upload_file_callback($sock, $args)
     * file_size - the file size
     * args - use argument for callback function
     * group_name: the group name of the master file
     * master_filename: the master filename to generate the slave file id
     * prefix_name: the prefix name to generage the slave file id
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error.
     * the returned array includes elements: group_name and filename
     */
    public function storage_upload_slave_by_callback( $callback_array, 
            $group_name, $master_filename, $prefix_name, $file_ext_name = null, 
            $meta_list = null, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * upload file to storage server by callback (slave file mode)
     * parameters:
     * callback_array: the callback assoc array, must have keys:
     * callback - the php callback function name
     * callback function prototype as:
     * function upload_file_callback($sock, $args)
     * file_size - the file size
     * args - use argument for callback function
     * master_file_id: the master file id to generate the slave file id
     * prefix_name: the prefix name to generage the slave file id
     * file_ext_name: the file extension name, do not include dot(.)
     * meta_list: meta data assoc array, such as
     * array('width'=>1024, 'height'=>768)
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return file_id for success, false for error
     */
    public function storage_upload_slave_by_callback1( $callback_array, 
            $master_file_id, $prefix_name, $file_ext_name = null, $meta_list = null, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * delete file from storage server
     * parameters:
     * group_name: the group name of the file
     * remote_filename: the filename on the storage server
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_delete_file( $group_name, $remote_filename, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * delete file from storage server
     * parameters:
     * file_id: the file id to be deleted
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_delete_file1( $file_id, $tracker_server = null, 
            $storage_server = null )
    {
    }

    /**
     * get file content from storage server
     * parameters:
     * group_name: the group name of the file
     * remote_filename: the filename on the storage server
     * file_offset: file start offset, default value is 0
     * download_bytes: 0 (default value) means from the file offset to
     * the file end
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return the file content for success, false for error
     */
    public function storage_download_file_to_buff( $group_name, $remote_filename, 
            $file_offset = 0, $download_bytes = 0, $tracker_server = null, 
            $storage_server = null )
    {
    }

    /**
     * get file content from storage server
     * parameters:
     * file_id: the file id of the file
     * file_offset: file start offset, default value is 0
     * download_bytes: 0 (default value) means from the file offset to
     * the file end
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return the file content for success, false for error
     */
    public function storage_download_file_to_buff1( $file_id, $file_offset = 0, 
            $download_bytes = 0, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * download file from storage server to local file
     * parameters:
     * group_name: the group name of the file
     * remote_filename: the filename on the storage server
     * local_filename: the local filename to save the file content
     * file_offset: file start offset, default value is 0
     * download_bytes: 0 (default value) means from the file offset to
     * the file end
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_download_file_to_file( $group_name, $remote_filename, 
            $local_filename, $file_offset = 0, $download_bytes = 0, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * download file from storage server to local file
     * parameters:
     * file_id: the file id of the file
     * local_filename: the local filename to save the file content
     * file_offset: file start offset, default value is 0
     * download_bytes: 0 (default value) means from the file offset to
     * the file end
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_download_file_to_file1( $file_id, $local_filename, 
            $file_offset = 0, $download_bytes = 0, $tracker_server = null, 
            $storage_server = null )
    {
    }

    /**
     * parameters:
     * group_name: the group name of the file
     * remote_filename: the filename on the storage server
     * download_callback: the download callback array, elements as:
     * callback - the php callback function name
     * callback function prototype as:
     * function my_download_file_callback($args, $file_size, $data)
     * args - use argument for callback function
     * file_offset: file start offset, default value is 0
     * download_bytes: 0 (default value) means from the file offset to
     * the file end
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_download_file_to_callback( $group_name, 
            $remote_filename, $download_callback, $file_offset = 0, 
            $download_bytes = 0, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * parameters:
     * file_id: the file id of the file
     * download_callback: the download callback array, elements as:
     * callback - the php callback function name
     * callback function prototype as:
     * function my_download_file_callback($args, $file_size, $data)
     * args - use argument for callback function
     * file_offset: file start offset, default value is 0
     * download_bytes: 0 (default value) means from the file offset to
     * the file end
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_download_file_to_callback1( $file_id, 
            $download_callback, $file_offset = 0, $download_bytes = 0, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * set meta data of the file
     * parameters:
     * group_name: the group name of the file
     * remote_filename: the filename on the storage server
     * meta_list: meta data assoc array to be set, such as
     * array('width'=>1024, 'height'=>768)
     * op_type: operate flag, can be one of following flags:
     * FDFS_STORAGE_SET_METADATA_FLAG_MERGE: combined with the old meta data
     * FDFS_STORAGE_SET_METADATA_FLAG_OVERWRITE: overwrite the old meta data
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_set_metadata( $group_name, $remote_filename, 
            $meta_list, $op_type = FDFS_STORAGE_SET_METADATA_FLAG_MERGE, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * set meta data of the file
     * parameters:
     * file_id: the file id of the file
     * meta_list: meta data assoc array to be set, such as
     * array('width'=>1024, 'height'=>768)
     * op_type: operate flag, can be one of following flags:
     * FDFS_STORAGE_SET_METADATA_FLAG_MERGE: combined with the old meta data
     * FDFS_STORAGE_SET_METADATA_FLAG_OVERWRITE: overwrite the old meta data
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     */
    public function storage_set_metadata1( $file_id, $meta_list, 
            $op_type = FDFS_STORAGE_SET_METADATA_FLAG_MERGE, $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * get meta data of the file
     * parameters:
     * group_name: the group name of the file
     * remote_filename: the filename on the storage server
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error
     * returned array like: array('width' => 1024, 'height' => 768)
     */
    public function storage_get_metadata( $group_name, $remote_filename, 
            $tracker_server = null, $storage_server = null )
    {
    }

    /**
     * get meta data of the file
     * parameters:
     * file_id: the file id of the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * storage_server: the storage server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error
     * returned array like: array('width' => 1024, 'height' => 768)
     */
    public function storage_get_metadata1( $file_id, $tracker_server = null, 
            $storage_server = null )
    {
    }

    /**
     * connect to the server
     * parameters:
     * ip_addr: the ip address of the server
     * port: the port of the server
     * return assoc array for success, false for error
     */
    public function connect_server( $ip_addr, $port )
    {
    }

    /**
     * disconnect from the server
     * parameters:
     * server_info: the assoc array including elements:
     * ip_addr, port and sock
     * return true for success, false for error
     * 
     * @param unknown $server_info            
     */
    public function disconnect_server( $server_info )
    {
    }

    /**
     * get a connected tracker server
     * return assoc array for success, false for error
     * the assoc array including elements: ip_addr, port and sock
     */
    public function tracker_get_connection()
    {
    }

    /**
     * send ACTIVE_TEST cmd to the server
     * parameters:
     * server_info: the assoc array including elements:
     * ip_addr, port and sock, sock must be connected
     * return true for success, false for error
     * 
     * @param unknown $server_info            
     */
    public function active_test( $server_info )
    {
    }

    /**
     * connect to all tracker servers
     * return true for success, false for error
     */
    public function tracker_make_all_connections()
    {
    }

    /**
     * close all connections to the tracker servers
     * return true for success, false for error
     */
    public function tracker_close_all_connections()
    {
    }

    /**
     * get group stat info
     * parameters:
     * group_name: specify the group name, null or empty string means all groups
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * return index array for success, false for error, each group as a array
     * element
     * 
     * @param unknown $group_name            
     * @param unknown $tracker_server            
     */
    public function tracker_list_groups( $group_name = null, $tracker_server )
    {
    }

    /**
     * get the storage server info to upload file
     * parameters:
     * group_name: specify the group name
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error. the assoc array
     * including
     * elements: ip_addr, port, sock and store_path_index
     */
    public function tracker_query_storage_store( $group_name = null, 
            $tracker_server = null )
    {
    }

    /**
     * get the storage server list to upload file
     * parameters:
     * group_name: specify the group name
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * return indexed storage server array for success, false for error.
     * each element is an ssoc array including elements:
     * ip_addr, port, sock and store_path_index
     */
    public function tracker_query_storage_store_list( $group_name = null, 
            $tracker_server = null )
    {
    }

    /**
     * get the storage server info to set metadata
     * parameters:
     * group_name: the group name of the file
     * remote_filename: the filename on the storage server
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error
     * the assoc array including elements: ip_addr, port and sock
     */
    public function tracker_query_storage_update( $group_name, $remote_filename, 
            $tracker_server = null )
    {
    }

    /**
     * get the storage server info to set metadata
     * parameters:
     * file_id: the file id of the file
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error
     * the assoc array including elements: ip_addr, port and sock
     */
    public function tracker_query_storage_update1( $file_id, 
            $tracker_server = null )
    {
    }

    /**
     * get the storage server info to download file (or get metadata)
     * parameters:
     * group_name: the group name of the file
     * remote_filename: the filename on the storage server
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error
     * the assoc array including elements: ip_addr, port and sock
     * 
     * @param unknown $group_name            
     * @param unknown $remote_filename            
     * @param unknown $tracker_server            
     */
    public function tracker_query_storage_fetch( $group_name, $remote_filename, 
            $tracker_server = null )
    {
    }

    /**
     * get the storage server info to download file (or get metadata)
     * parameters:
     * file_id: the file id of the file
     * remote_filename: the filename on the storage server
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * return assoc array for success, false for error
     * the assoc array including elements: ip_addr, port and sock
     */
    public function tracker_query_storage_fetch1( $file_id, 
            $tracker_server = null )
    {
    }

    /**
     * get the storage server list which can retrieve the file content or
     * metadata
     * parameters:
     * group_name: the group name of the file
     * remote_filename: the filename on the storage server
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * return index array for success, false for error.
     * each server as an array element
     * 
     * @param unknown $group_name            
     * @param unknown $remote_filename            
     * @param unknown $tracker_server            
     */
    public function tracker_query_storage_list( $group_name, $remote_filename, 
            $tracker_server = null )
    {
    }

    /**
     * get the storage server list which can retrieve the file content or
     * metadata
     * parameters:
     * file_id: the file id of the file
     * remote_filename: the filename on the storage server
     * tracker_server: the tracker server assoc array including elements:
     * ip_addr, port and sock
     * return index array for success, false for error.
     * each server as an array element
     */
    public function tracker_query_storage_list1( $file_id, 
            $tracker_server = null )
    {
    }

    /**
     * delete the storage server from the cluster
     * parameters:
     * group_name: the group name of the storage server
     * storage_ip: the ip address of the storage server to be deleted
     * return true for success, false for error
     * 
     * @param unknown $group_name            
     * @param unknown $storage_ip            
     */
    public function tracker_delete_storage( $group_name, $storage_ip )
    {
    }

    /**
     * close tracker connections
     */
    public function close()
    {
    }
}
?>