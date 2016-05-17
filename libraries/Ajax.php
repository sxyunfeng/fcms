<?php
namespace libraries;
trait Ajax
{
    /**
     * csrf 检验
     * return bool
     */
    protected function csrfCheck()
    {
        $key = $this->request->getPost( 'key' );
        $token = $this->request->getPost( 'token' );
        
        if( ( $key && $token && $this->security->checkToken( $key, $token ) ) || $this->security->checkToken() )
        {
            return true;
        }
        else
        {
            $this->error( 'csrf校验不正确' );
        }
    }

    /**
     * 消息的输出
     * param int $status 状态 0：代表成功，1：代表失败，2:代表其
     * param string $msg 消息内容
     * param array $data 其他自定义数据
     */
    protected function message( $status = 0, $msg = '', $data = array() )
    {
        $ret[ 'status' ] = $status;
        $ret[ 'msg' ] = $msg;
        if( $this->request->isPost() ) //post请求才进行csrf
        {
            $ret[ 'key' ] = $this->security->getTokenKey();
            $ret[ 'token' ] = $this->security->getToken();
        }
        $ret = array_merge( $ret, $data );
        echo json_encode( $ret );
        exit;
    }

    /**
     * 成功消息返回 
     * param string $msg
     * param array $data 其他自定义数据
     */
    protected function success( $msg = '', $data = array() )
    {
        $this->message( 0, $msg, $data );
    }

    /**
     * 错误消息返回 
     * param string $msg
     * param array $data 其他自定义数据
     */
    public function error( $msg = '', $data = array() )
    {
        $this->message( 1, $msg, $data );
    }

}
