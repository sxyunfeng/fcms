<?php
namespace libraries;

/**
 * 生成的key,token一直有效
 *
 * @author hfc
 */
class CsrfCheck extends \Phalcon\Security
{
    private $_di;
    private $_session;
    private $_router;
    private $_key = false;
    private $_token = false;
    
    /**
     * 获取di，每一个请求都会有一个di
     * @return type
     */
    public function getDI()
    {
        return $this->_di;
    }

    /**
     * 设置di
     * @param \Phalcon\DiInterface $dependencyInjector
     */
    public function setDI( \Phalcon\DiInterface $dependencyInjector )
    {
        $this->_di = $dependencyInjector;
        $this->_session = $this->_di[ 'session' ];
        $this->_router = $this->_di[ 'router' ];
    }
    
    /**
     * 获取tokenKey
     * @return string
     */
    public function getTokenKey( $numberBytes = null )
    {
        $this->_key = $this->randString( $numberBytes );
        $this->setSession();
        return $this->_key;
    }
    
    /**
     * 保存token,key到session中
     */
    private function setSession()
    {
        if( $this->_token && $this->_key )
        {
            $module = $this->_router->getModuleName();
            $controller = $this->_router->getControllerName();
            
            $this->_session->set( $module . $controller, $this->_key );
            $this->_session->set( $this->_key, $this->_token );
        }
    }
   
    /**
     * 获取token
     * @return string
     */
     public function getToken( $numberBytes = null )
     {
        $this->_token = $this->randString( $numberBytes );
        $this->setSession();
        return $this->_token;
     }
    
    /**
     * 生成随机字符串
     * @param int $length
     * @return string
     */
    private function randString( $length = 16 )
    {
        if( ! $length )
        {
            $length = 16;
        }
        
        if (function_exists('openssl_random_pseudo_bytes')) 
        {
            $bytes = openssl_random_pseudo_bytes($length * 2);

            if ($bytes === false)
                throw new RuntimeException('Unable to generate a random string');

            return substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $length);
        }

        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
    
    /**
     * 校验key, token
     * @param string $key
     * @param string $token
     * @return boolean
     */
    public function checkToken( $tokenKey = null, $tokenValue = null, $destroyIfValid = true )
    {
        $strtoken = '';
        if( $tokenKey && $tokenValue )
        {
            $strtoken = $this->_session->get( $tokenKey );
        }
        else 
        {
            $module = $this->_router->getModuleName();
            $controller = $this->_router->getControllerName();
            $key = $this->_session->get( $module . $controller  );
            
            if( isset( $_REQUEST[ $key ]))
            {
                $strtoken = $this->_session->get( $key );
                $tokenValue = $_REQUEST[ $key ];
            }
        }
        
        if( $strtoken  &&  $strtoken === $tokenValue )
        {
            if( $destroyIfValid )
            {
                $this->_session->remove( $tokenKey );
            }
            return true;
        }
        return false;
    }
}
