<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/public/bootstrap/3.3.0/css/bootstrap.min.css">
        <style>
            button {
                margin-right:50px;
                width:70px;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation" class=""><a href="{{ url( 'admin/payconfig/index' ) }}">使用的支付</a></li>
            <li role="presentation" class="active"><a href="#edit">{% if isRead is defined %} 查看支付方式 {% else %}编辑支付{% endif %}</a></li>
        </ul>
         <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="edit" style="padding-top:20px;">
                <form class="form-horizontal">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">支付方式名称</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" placeholder="请输入支付名称" name="pay_name" value="{{ pay[ 'pay_name'] | escape_attr }}">
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">合作者身份id</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" placeholder="请输入合作者身份id" name="partner_id" value="{{ pay[ 'partner_id'] | escape_attr }}">
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">安全校验码key</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" placeholder="请输入安全校验码key" name="partner_key" value="{{ pay[ 'partner_key'] | escape_attr }}">
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">排序</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" placeholder="请输入排序" name="sort" value="{{ pay[ 'sort'] | escape_attr }}">
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">是否开启</label>
                        <div class="col-xs-3 text-left">
                            <label class="radio-inline">
                                <input type="radio" name="status" value="0" {% if pay[ 'status' ] == 0 %} checked {% endif %}>
                                是
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="status" value="1" {% if pay[ 'status' ] %} checked {% endif %}>
                                否
                            </label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-xs-offset-2 col-xs-3 text-left">
                            {% if isRead is not defined %}
                            <button type="button" class="btn btn-success btn-sm" id="save"  >保存</button>
                            {% endif %}
                            <button type="button" class="btn btn-default btn-sm" id="cancel" onclick="location='/admin/payconfig/index';" >返回</button>
                        </div>
                        <div class="col-xs-12 text-center loading"  style="margin-top:-20px; display:none;"> 
                            <i class="fa fa-pulse fa-spinner  fa-2x"  > </i>
                        </div>
                        <input type="hidden" name="id"  value="{{ pay['id'] | escape_attr }}" />
                    </div>
                </form>
            </div>
         </div>
        <div class="alert alert-danger text-center col-xs-2" style="margin-left:40%;display:none;">
             <i class="glyphicon glyphicon-warning-sign pull-left"></i>
            <span>网络错误</span>
        </div>
        <script src="/public/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
     $(function () {
        /*--------------检验数据----------------*/
        $( 'input:text' ).blur( function(){
           var parent = $( this ).parents( '.form-group' );
           var value = $( this ).val(); 

           if( value ) 
           {
               success( parent );
           }
           else
           {
               error( parent );
           }
        });
        /*---------------保存数据------------------*/
        $( '#save' ).click( function(){
            $( 'input:text' ).blur();
            if( $( 'form span' ).hasClass( 'glyphicon-remove' ) )
            {
                errorMsg( '请检查输入错误' );
                return false;
            }
            var data =  $( 'form' ).serialize();
            var key = '&<?php echo $this->security->getTokenKey();?>=<?php echo $this->security->getToken();?>';
                data += key;
            $( '.loading' ).show();
           $.post( '/admin/payconfig/update', data, function( ret ){
               if( ! ret.status )
               {
                   location = '/admin/payconfig/index';
               }
               else
               {
                   errorMsg( ret.msg );
               }
               $( '.loading' ).hide();
           }, 'json') .error( function(){
               errorMsg( '网络不通' );
           });

        });

    });   
            
    function success( obj )
    {
        obj.find( 'span' ).remove();
        obj.addClass( 'has-success' ).removeClass( 'has-error' );
        obj.find( '.form-control' ).after( '<span class="glyphicon glyphicon-ok form-control-feedback"></span>' );
    }
    function error( obj )
    {
        obj.find( 'span' ).remove();
        obj.addClass( 'has-error' ).removeClass( 'has-success' );
        obj.find( '.form-control' ).after( '<span class="glyphicon glyphicon-remove form-control-feedback"></span>' );
    }
    function errorMsg( msg )
    {
        $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
        $( '.alert span' ).text( msg );
        $( '.alert' ).show().fadeOut( 3000 );
    }
        </script>
    </body>
</html>

