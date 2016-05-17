<?php
class Memcached 
{
	/**
	 * @param string $persistent_id
	 */
	public function __construct( $persistent_id  );
	
	/**
	 * @param string $key
	 * @param mixed $value
	 * @param int $expiration
	 * @param
	 * @return bool
	 */
	public function add( $key, $value, $expiration  );
	
	/**
	 * @param string $server_key
	 * @param string $key
	 * @param mixed $value
	 * @param int $expiration
	 * @return bool
	 */
	public function addByKey( $server_key, $key, $value, $expiration  );
	
	/**
	 * @param string $host
	 * @param int $port 
	 * @param int $weight
	 * @param
	 * @return bool
	 */
	public function addServer( $host, $port, $weight = 0  );
	
	/**
	 * @param array $servers
	 * @return bool
	 */
	public function addServers( $servers );
	
	/**
	 * @param string $key
	 * @param string $value
	 * @param
	 * @param
	 * @return bool
	 */
	public function append( $key, $value );
	
	/**
	 * @param string $server_key
	 * @param string $key
	 * @param string $value
	 * @return bool
	 */
	public function appendByKey( $server_key, $key, $value );
	
	/**
	 * @param float $cas_token
	 * @param string $key
	 * @param mixed $value
	 * @param int $expiration
	 * @return bool
	 */
	public function cas( $cas_token, $key, $value, $expiration  );
	
	/**
	 * @param float $cas_token
	 * @param string $server_key
	 * @param string $key
	 * @param mixed $value
	 * @param int $expiration
	 * @return bool
	 */
	public function casByKey( $cas_token, $server_key, $key, $value, $expiration  );
	
	/**
	 * @param string $key
	 * @param int $offset
	 * @param int $initial_value
	 * @param int $expiry
	 * @return int
	 */
	function decrement( $key, $offset = 1, $initial_value = 0, $expiry = 0  );
	
	/**
	 * @param string $server_key
	 * @param string $key
	 * @param int $offset
	 * @param int $initial_value
	 * @param int $expiry
	 * @return int
	 */
	function decrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0  );
	
	/**
	 * @param string $key
	 * @param int $time
	 * @return bool
	 */
	public function delete( $key, $time = 0  );
	
	/**
	 * @param string $server_key
	 * @param string $key
	 * @param int $time
	 * @return bool
	 */
	public function deleteByKey( $server_key, $key, $time = 0  );
	
	/**
	 * @param array $keys
	 * @param int $time
	 * @return bool
	 */
	public function deleteMulti( $keys, $time = 0  );
	
	/**
	 * @param string $server_key
	 * @param array $keys
	 * @param int $time
	 * @return bool
	 */
	public function deleteMultiByKey( $server_key, $keys, $time = 0  );
	
	/**
	 * @return array
	 */
	public function fetch();
	
	/**
	 * @return array
	 */
	function fetchAll();
	
	/**
	 * @param int $delay
	 * @return bool
	 */
	public function flush( $delay = 0  );
	
	/**
	 * @param string $key
	 * @param callable $cache_cb
	 * @param float &$cas_token
	 * @return mixed
	 */
	public function get( $key, $cache_cb, &$cas_token  );
	
	/**
	 * @return array
	 */
	function getAllKeys();
	
	/**
	 * @param string $server_key
	 * @param string $key
	 * @param callable $cache_cb
	 * @param float &$cas_token
	 * @return mixed
	 */
	public function getByKey( $server_key, $key, $cache_cb, &$cas_token  );
	
	/**
	 * @param array $keys
	 * @param bool $with_cas
	 * @param callable $value_cb
	 * @return bool
	 */
	public function getDelayed( $keys, $with_cas, $value_cb  );
	
	/**
	 * @param string $server_key
	 * @param array $keys
	 * @param bool $with_cas
	 * @param callable $value_cb
	 * @return bool
	 */
	public function getDelayedByKey( $server_key, $keys, $with_cas, $value_cb  );
	
	/**
	 * @param array $keys
	 * @param array &$cas_tokens
	 * @param int $flags
	 * @param
	 * @return mixed
	 */
	public function getMulti( $keys, &$cas_tokens, $flags  );
	
	/**
	 * @param string $server_key
	 * @param array $keys
	 * @param string &$cas_tokens
	 * @param int $flags
	 * @return array
	 */
	function getMultiByKey( $server_key, $keys, &$cas_tokens, $flags  );
	
	/**
	 * @param int $option
	 * @return mixed
	 */
	public function getOption( $option );
	
	/**
	 * @return int
	 */
	public function getResultCode();
	
	/**
	 * @return string
	 */
	public function getResultMessage();
	
	/**
	 * @param string $server_key
	 * @return array
	 */
	public function getServerByKey( $server_key );
	
	/**
	 * @return array
	 */
	public function getServerList();
	
	/**
	 * @return array
	 */
	public function getStats();
	
	/**
	 * @return array
	 */
	public function getVersion();
	
	/**
	 * @param string $key
	 * @param int $offset = 1
	 * @param int $initial_value = 0
	 * @param int $expiry = 0
	 * @return int
	 */
	function increment( $key, $offset = 1, $initial_value = 0, $expiry = 0  );
	
	
	/**
	 * @param string $server_key
	 * @param string $key
	 * @param int $offset = 1
	 * @param int $initial_value = 0
	 * @param int $expiry = 0
	 * @return int
	 */
	function incrementByKey( $server_key, $key, $offset = 1, $initial_value = 0, $expiry = 0  );
	
	/**
	 * @return bool
	 */
	public function isPersistent();
	
	/**
	 * @return bool
	 */
	public function isPristine();
	
	/**
	 * @param string $key
	 * @param string $value
	 * @return bool
	 */
	public function prepend( $key, $value );
	
	/**
	 * @param string $server_key
	 * @param string $key
	 * @param string $value
	 * @return bool
	 */
	public function prependByKey( $server_key, $key, $value );
	
	/**
	 * @return bool
	 */
	public function quit();
	
	/**
	 * @param string $key
	 * @param mixed $value
	 * @param int $expiration
	 * @param
	 * @return bool
	 */
	public function replace( $key, $value, $expiration  );
	
	/**
	 * @param string $server_key
	 * @param string $key
	 * @param mixed $value
	 * @param int $expiration
	 * @return bool
	 */ 
	public function replaceByKey( $server_key, $key, $value, $expiration  );
	
	/**
	 * @param
	 * @param
	 * @param
	 * @param 
	 * @return bool
	 */
	public function resetServerList();
	
	/**
	 * @param string $key
	 * @param mixed $value
	 * @param int $expiration
	 * @param
	 * @return bool
	 */
	public function set( $key, $value, $expiration  );
	
	/**
	 * @param string $server_key
	 * @param string $key
	 * @param mixed $value
	 * @param int $expiration
	 * @return bool
	 */
	public function setByKey( $server_key, $key, $value, $expiration  );
	
	/**
	 * @param array $items
	 * @param int $expiration
	 * @param
	 * @param
	 * @return bool
	 */
	public function setMulti( $items, $expiration  );
	
	/**
	 * @param string $server_key
	 * @param array $items
	 * @param int $expiration
	 * @param
	 * @return bool
	 */
	public function setMultiByKey( $server_key, $items, $expiration  );
	
	/**
	 * @param int $option
	 * @param mixed $value
	 * @param
	 * @param
	 * @return bool
	 */
	public function setOption( $option, $value );
	
	/**
	 * @param array $options
	 * @param
	 * @param
	 * @param
	 * @return bool
	 */
	public function setOptions( $options );
	
	/**
	 * @param string $username
	 * @param string $password 
	 * @param
	 * @param
	 * @return void
	 */
	public function setSaslAuthData( $username, $password );
	
	/**
	 * @param string $key
	 * @param int $expiration
	 * @param
	 * @param
	 * @return bool
	 */
	public function touch( $key, $expiration );
	
	/**
	 * @param string $server_key
	 * @param string $key
	 * @param int $expiration
	 * @return bool
	 */
	public function touchByKey( $server_key, $key, $expiration );
}

?>