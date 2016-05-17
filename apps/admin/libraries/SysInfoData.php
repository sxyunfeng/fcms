<?php

namespace apps\admin\libraries;

use Phalcon\DI\InjectionAwareInterface;

class SysInfoData implements  InjectionAwareInterface {
	
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
	 * 获取操作系统
	 * @return string
	 */
	public function getos()
	{
		return PHP_OS;
	}
	
	/**
	 * 获取运行环境
	 * @return string
	 */
	public function getevn()
	{
		return php_uname();
	}
	
	/**
	 * 获取php版本
	 * @return string
	 */
	public function getphpversion()
	{
		return PHP_VERSION;
	}
	
	/**
	 * 获取php运行方式
	 * @return string
	 */
	public function getphprunway()
	{
		return php_sapi_name();
	}
	
	/**
	 * 获取mysql版本
	 * @return string
	 */
	public function getsqlversion()
	{
		$conn = @mysql_connect( $this->_di['config']['database']['host'] , $this->_di['config']['database']['username'], $this->_di['config']['database']['password'] );
		return mysql_get_server_info( $conn )?mysql_get_server_info( $conn ):'未知';
	}
	
	/**
	 * 获取f_cms版本
	 * @return string
	 */
	public function getcmsversion()
	{
		return $this->_di['cmscfg'][ 'f_cms_version' ];
	}
	
	/**
	 * 获取上传大小限制
	 * @return string
	 */
	public function getuploadlimit()
	{
		return get_cfg_var( 'upload_max_filesize' );
	}
	
	/**
	 * 获取程序运行时间
	 * @return string
	 */
	public function getexecutelimit()
	{
		return get_cfg_var( 'memory_limit' );
	}
	
	/**
	 * 获取剩余空间大小
	 * @return string
	 */
	public function getsurplusspace()
	{
		return round( ( @disk_free_space(".") / (1024 * 1024) ), 2 ) . 'M';
	}
	
}

?>