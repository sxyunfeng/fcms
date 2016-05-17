<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/toastr/toastr.min.css">
        <style>

            .goods-pic {
                position:relative;margin:0 20px 20px 0;
                border:1px dashed gray;display:inline-block; vertical-align: middle;text-align: center;color:gray;cursor:pointer;
            }
            .goods-img:nth-child(2) .glyphicon-arrow-left {
                display:none;
            }
            .goods-img:last-child .glyphicon-arrow-right {
                display:none;
            }
            .goods-pic img {
                margin:5px; max-width:500px;max-height:300px;
            }
            .goods-pic-operate {
                position:absolute;bottom: 0; width:100%; text-align: center;background:gainsboro; display:none;
            }
            .goods-address div.col-xs-2  {
                padding-right: 0;
            }

            .ad-pic-operate {
                position:absolute;bottom: 0; width:100%; text-align: center;background:gainsboro; display:none;
            }
            .col-xs-2 {
                padding-right: 0;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation"><a href="/admin/cache/index">缓存</a></li>
            <li role="presentation"class="active"><a href="#cacheAdd" >添加缓存</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="adAdd" style="padding-top:20px;">
                <form class="form-horizontal">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">缓存名称</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="name" id="name" name="name" placeholder="请输入缓存名称" required="required" value=""/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">缓存英文名称</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="ename" name="ename" placeholder="请输入缓存英文名称" required="required" 
                                   value=""/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">缓存英文名称规则</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="ename_rule" name="ename_rule" placeholder="请输入缓存英文名规则" required="required" 
                                   value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label"> 缓存类型</label>
                        <div class="col-xs-8">
                            <label class="radio-inline"><input type="radio" name="type" value="0" />Memcache</label>
                            <label class="radio-inline"><input type="radio" name="type" value="1" />Redis</label>
                            <label class="radio-inline"><input type="radio" name="type" value="2" />Mongodb</label>
                            <label class="radio-inline"><input type="radio" name="type" value="3" />File</label>
                            <label class="radio-inline"><input type="radio" name="type" value="4" />Memcached</label>
                            <label class="radio-inline"><input type="radio" name="type" value="5" />Apc</label>
                            <label class="radio-inline"><input type="radio" name="type" value="6" />XCache</label>
                            <label class="radio-inline"><input type="radio" name="type" value="7" />Mongo</label>
                        </div>
                    </div>
                     <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">缓存时间</label>
                        <div class="col-xs-3">
                            <input class="form-control form_datetime" type="text" id="cache_time" name="cache_time" placeholder="请输缓存时间" 
                                   required="required" value=""/>单位（分钟）
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-xs-2 control-label"> 是否预热</label>
                        <div class="col-xs-8">
                            <label class="radio-inline"><input type="radio" name="is_warm_up" 
                                                               value="0" />no</label>
                            <label class="radio-inline"><input type="radio" name="is_warm_up" 
                                                               value="1"  />yes</label>
                        </div>
                    </div>
                 <div class="form-group">
                        <label class="col-xs-2 control-label"> 模块归属</label>
                        <div class="col-xs-8">
                            <label class="radio-inline"><input type="radio" name="module" value="0" />前台</label>
                            <label class="radio-inline"><input type="radio" name="module" value="1"  />后台</label>
                            <label class="radio-inline"><input type="radio" name="module" value="4"  />CMS</label>
                            <label class="radio-inline"><input type="radio" name="module" value="2"  />OA</label>
                            <label class="radio-inline"><input type="radio" name="module" value="3"  />Common</label>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="cacheInsert" style="margin-right: 50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" style="width:70px;">取消</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="alert alert-danger text-center col-xs-2" style="position:fixed; bottom:0; margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>

        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/u/ueditor.config.js"></script>
        <script src="/u/ueditor.all.js"></script>
        <script type="text/javascript" charset="utf-8" src="/u/lang/zh-cn/zh-cn.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
		<script src="/bootstrap/toastr/toastr.min.js"></script>
        <script>
        
var submitId = false;
var csrfName = "<?php echo $this->security->getTokenKey();?>";
var csrfValue = "<?php echo $this->security->getToken();?>";

$( function(){
	
	/*-------------防止重复提交------------*/
	$( 'input' ).change( function(){
		if( submitId )
		{
			submitId = false;
		}
	} ).keydown( function(){
		if( submitId )
		{
			submitId = false;
		}
	} );
    
    /*--------------分页切换----------------------*/
    $( '#tabs a' ).click( function( e ){
        if( $( this ).parent().index() === 0 ) //第一个分页是商品列表
            return;
        e.preventDefault();
        $( this ).tab( 'show' );
    } );

    /*-------------数据检验------------*/
    $( ':text' ).blur( function(){
        var objParent = $( this ).parents( '.form-group' );
        objParent.find( 'span' ).remove();
        var value = $( this ).val();
        if( !$( this ).attr( 'required' ) )
            return false;

        if( value )
        {
            success( objParent );
        }
        else
        {
            error( objParent );
        }
    } );
    /*-----------添加数据-----------*/
    $( '#cacheInsert' ).click( function(){
    	if( !submitId )
    	{
    		$( ':text' ).blur(); //重新检验一下数据

   	       if( !$( 'form span' ).hasClass( 'glyphicon-remove' ) ) //数据正确可以提交表单了
   	        {
   	            var data = $( 'form' ).serialize();
   	        	var key = '&'+csrfName+'='+csrfValue;
   	            data += key;
   	            submitId = true;
   	            $.post( '/admin/cache/insert', data, function( ret )
   	            {
   	                if( !ret.status )
   	                {
   	                    $( '#adId' ).val( ret.id ); //新添加的缓存id保存下
   	                    successMsg( ret.msg );
   	                }
   	                else
   	               {
   	                	errorMsg( ret.msg );
                        csrfName = ret.csrfname;
                        csrfValue = ret.csrfval;
                        submitId = false;
   	                }

   	            }, 'json' ).error( function(){
   	                errorMsg( '网络不通' );
   	            } );
   	        }

   	        return false;
    	}
    	else
    	{
    		toastr.error( '请勿重复提交数据！' );
    	}
    } );
    /* ----------取消---------------*/
    $( '#cancel' ).click( function(){
        location = '/admin/cache/index';
        return false;
    } );
} );
function success( obj )
{
    obj.addClass( 'has-success' ).removeClass( 'has-error' );
    obj.find( '.form-control' ).after( '<span class="glyphicon glyphicon-ok form-control-feedback"></span>' );
}
function error( obj )
{
    obj.addClass( 'has-error' ).removeClass( 'has-success' );
    obj.find( '.form-control' ).after( '<span class="glyphicon glyphicon-remove form-control-feedback"></span>' );
}
function errorMsg( msg )
{
    $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
    $( '.alert span' ).text( msg );
    $( '.alert' ).show().fadeOut( 3000 );
}
function successMsg( msg )
{
    $( '.alert' ).addClass( 'alert-success' ).removeClass( 'alert-danger' );
    $( '.alert span' ).text( msg );
    $( '.alert' ).show().fadeOut( 3000 );
}
        </script>
    </body>
</html>
