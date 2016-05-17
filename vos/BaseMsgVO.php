<?php
namespace vos;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class BaseMsgVO 
{
	private $_tid;
	private $_level;
	private $_body;
	private $_log;
	
	/**
	 * @return the $_tid
	 */
	public function getTid() 
	{
		return $this->_tid;
	}

	/**
	 * @return the $_level
	 */
	public function getLevel() 
	{
		return $this->_level;
	}

	/**
	 * @return the $_body
	 */
	public function getBody() {
		return $this->_body;
	}

	/**
	 * @param field_type $_tid
	 */
	public function setTid($_tid) 
	{
		$this->_tid = $_tid;
	}

	/**
	 * @param field_type $_level
	 */
	public function setLevel($_level) 
	{
		$this->_level = $_level;
	}

	/**
	 * @param field_type $_body
	 */
	public function setBody($_body) 
	{
		$this->_body = $_body;
	}

	
	
}

?>