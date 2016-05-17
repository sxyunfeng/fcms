<?php
/**
 * @deprecated
 * @author bruce
 *
 */
namespace libraries;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class FCache implements \Phalcon\DI\InjectionAwareInterface
{
	protected $_strPath;
	protected $_config;
	
	public function __construct( $config )
	{
		//$config = $this->_di->get( 'config' );
		$this->_config = $config;
			
		$this->_strPath = $this->_config->application->cacheDir . 'fCache/';
	}
	
	protected $_di;
	

	
	public function get( $strKey )
	{
		if( !file_exists( $this->_strPath . $strKey ))
		{
			return false;
		}
		
		return file_get_contents( $this->_strPath . $strKey );
	}
	
	/**
	 * 
	 * @param $strKey
	 * @param $strValue
	 * @return int The function returns the number of bytes that were written to the file,
	 *  or false on failure.
	 */
	public function save( $strKey, $strValue )
	{
		return file_put_contents( $this->_strPath . $strKey, $strValue );
	}
	
	/**
	 * 
	 * @param $strKey
	 * @return number|boolean
	 */
	public function delete( $strKey )
	{
		if( file_exists( $this->_strPath . $strKey ))
		{
			if( !unlink( $this->_strPath . $strKey ) )
			{//删除失败则使用null覆盖
				return $this->save( $strKey, null );
			}
		}
		
		return true;
	}
	
	public function queryKeys()
	{
		return scandir( $this->_strPath );
	}
	
	public function exists( $strKey )
	{
		return file_exists( $this->_strPath . $strKey );
	}
	
	/**
	 * @return 移植所有元素
	 */
	public function rmall()
	{
		return rmdir( $this->_strPath ) && mkdir( $this->_strPath );
	}
	/* (non-PHPdoc)
     * @see \Phalcon\Di\InjectionAwareInterface::setDI()
     */
    public function setDI( \Phalcon\DiInterface $dependencyInjector )
    {
        // TODO Auto-generated method stub
        $this->_di = $dependencyInjector;
    }

	/* (non-PHPdoc)
     * @see \Phalcon\Di\InjectionAwareInterface::getDI()
     */
    public function getDI()
    {
        // TODO Auto-generated method stub
        return $this->_di;
    }

}
