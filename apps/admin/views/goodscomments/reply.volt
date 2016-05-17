<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
    </head>
    <style>
        button {
            margin-right:50px;
            width:70px;
        }
        .glyphicon{
            color:goldenrod;
            margin-top:8px;
        }
       
    </style>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation" class=""><a href="{{ url( 'admin/goodscomments/index' ) }}">商品评论</a></li>
            <li role="presentation" class="active"><a href="#commentReply">回复评论</a></li>
        
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="commentReply" style="padding-top:20px;">
                {% if comment is defined and comment is not empty %}
                <form class="form-horizontal" id="commentInfo">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">商品名称</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="loginname" name="login_name"  value='{{ comment[ 'goods_name' ]}}'  disabled/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">会员姓名</label>
                        <div class="col-xs-2">
                            <input class="form-control" type="text" id="name" name="username" value='{{ comment[ 'username' ]}}' disabled/>
                        </div>
                    </div>
                    <div class="form-group  has-feedback text-right">
                        <label class="col-xs-2 control-label">评论时间</label>
                        <div class="col-xs-2">
                            <input class="form-control " type="email" id="email" name="addtime"  value="{{ comment[ 'addtime' ]}}" disabled/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">商品评分</label>
                        <div class="col-xs-1 text-left">
                           
                            <?php if( $comment[ 'goods_marks' ] ) { for($i = 0;$i <  $comment[ 'goods_marks' ]; $i++ ){ ?>  
                            <i class="glyphicon glyphicon-star" style="display:inline-block;"></i> <?php } } ?>     
                           
                        </div>
                        <label class="col-xs-1 control-label">服务评分</label>
                        <div class="col-xs-2 text-left">
                            <?php if( $comment[ 'serv_marks'] ) { for($i = 0;$i < $comment[ 'serv_marks']; $i++ ){ ?>  
                            <i class="glyphicon glyphicon-star"></i> <?php } } ?>      
                        </div>
                    </div>
                     <div class="form-group  has-feedback text-right">
                        
                    </div>
                     <div class="form-group  has-feedback text-right">
                        <label class="col-xs-2 control-label">评论内容</label>
                        <div class="col-xs-4">
                            <textarea class="form-control" rows="2" >{{ comment[ 'comment' ]}} </textarea> 
                        </div>
                    </div>
                     <div class="form-group  has-feedback text-right">
                        <label class="col-xs-2 control-label">回复</label>
                        <div class="col-xs-4">
                            <textarea class="form-control" rows="2"  id="replyContent" >{% if comment[ 'reply_content' ] %}{{ comment[ 'reply_content'] }}{% else %}请输入回复{% endif %}</textarea> 
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-xs-3 text-center">
                            <button type="button" class="btn btn-success btn-sm" id="save"  >回复</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" onclick="location='/admin/goodscomments/index';" >返回</button>
                        </div>
                    </div>
                    <input type="hidden" id="commentId"  value="{{ comment['id'] }}" />
                </form>
                {% else %}
                <div class="col-xs-12 text-center text-danger">没有数据</div>
                {% endif %}
            </div>
        </div>
        <div class="alert alert-danger text-center col-xs-2" style="display:none;margin-left: 40%;">
            <span>删除失败</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
        $( function() {
            $( '#replyContent' ).focus( function(){
                if( $( this ).val() === '请输入回复' )
                {
                    $( this ).val( '' );
                }
            });
            $( '#replyContent' ).blur( function() {
                if( $( this ).val() === '' )
                {
                    $( this ).val( '请输入回复' );
                }
            });
            /*---------------保存回复--------------*/
            $( '#save' ).click( function(){
                var replyContent = $( '#replyContent' ).val();
                var commentId = $( '#commentId').val();
             
                if( replyContent && commentId )
                {
                    var data = { 'id': commentId, 'replyContent' : replyContent};
                   $.post( '/admin/goodscomments/save', data, function( ret ){
                       if( ! ret.status )
                       {
                           location = '/admin/goodscomments/index';
                       }
                       else
                       {
                           errorMsg( ret.msg );
                       }
                   },'json').error( function(){
                       errorMsg( '网络不通' );
                   });
                }
                else
                {
                    errorMsg( '回复内容不能为空' );
                }
            });
        });
    function  errorMsg( msg )
    {
       $( '.alert span' ).text( msg );
       $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
       $( '.alert' ).show().fadeOut( 3000 );
    }
        </script>
    </body>
</html>