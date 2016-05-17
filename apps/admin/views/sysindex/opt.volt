<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <style>
            .articles-pic-operate {
                position:absolute;bottom: 0; width:100%; text-align: center;background:gainsboro; display:none;
            }
             .col-xs-2 {
                padding-right: 0;
            }
			div .position i{
				color: #b2b2b2;
			    line-height: 34px;
			    margin: 0;
            	font-size:12px;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation"><a href="/admin/sysindex/index">系统主页配置</a></li>
            <li role="presentation"class="active"><a href="#sysindexopt" >{% if res.id is defined %}修改配置{% else %}添加配置{% endif %}</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="sensitiveAdd" style="padding-top:20px;">
                <form class="form-horizontal" method="post" action="/admin/sysindex/save">
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">标题名称</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="name" name="name" placeholder="请输入标题名" value="{% if res.name is defined %}{{res.name}}{% endif %}"/>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback">
                        <label class="col-xs-2 control-label">标题icon</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="icon" name="icon" value="{% if res.icon is defined %}{{res.icon}}{% endif %}" />
                        </div>
                        <div class="col-xs-4 position"><i class="glyphicon glyphicon-info-sign"> 可在http://fontawesome.io/icons中挑选自己喜欢的icon图标</i></div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">填充颜色</label>
                        <div class="col-xs-3">
                            <select name="color" class="form-control">
                            	<option value="0">default</option>
                            	<option value="1">primary</option>
                            	<option value="2">success</option>
                            	<option value="3">info</option>
                            	<option value="4">warning</option>
                            	<option value="5">danger</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">总共行数</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="line" name="line" value="{% if res.line is defined %}{{res.line}}{% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback ">
                        <label class="col-xs-2 control-label">模块大小</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="size" name="size" value="{% if res.size is defined %}{{res.size}}{% endif %}" />
                        </div>
                        <div class="col-xs-5 position"><i class="glyphicon glyphicon-info-sign"> 可任意填写数字1~12控制模块大小1,最小模块12为最大</i></div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">是否挂载</label>
                        <div class="col-md-3 text-left">
                        	<label class="radio-inline"><input type="radio" name="display" value="0" {% if res.display is defined and 0 == res.display  %} checked="true" {% elseif res.display is not defined %} checked="true" {% endif %} />挂载</label>
                            <label class="radio-inline"><input type="radio" name="display" value="1" {% if res.display is defined and 1 == res.display %} checked="true" {% endif %} />不挂载</label>
                        </div>
                    </div>
                     
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-5">
                        	<input type="hidden" value="{% if res.id is defined %}{{res.id}}{% endif %}" name="id"/>
                           	<input type="submit" value="提交" name="submit" class="btn btn-info col-sm-6 col-xs-3" onclick="return submitCheck()">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="alert alert-danger text-center col-xs-2" id="submit_alert" style="position:fixed; bottom:0; margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
     
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
        var color = '<?php if( isset( $res->color ) ) echo $res->color; else echo 0; ?>';
        $(function(){
        	if( false != color )
       		{
       			$( 'select[name="color"] option' ).each(function(){
       				if( color == $( this ).val() )
       					$(this).attr( 'selected' , true );
       			});
       		}
        });
        
        function submitCheck(){
        	if( $( '#name' ).val() != '' && $( '#icon' ).val() != '' && $( '#line' ).val() != '' && $( '#size' ).val() != '' )
        	{
        		return true;
        	}
        	else
        	{
        		errorMsg( '输入信息不完整' );
        		return false;
        	}
        }
        
        function errorMsg( msg )
        {
            $( '.alert span' ).text( msg );
            $( '.alert' ).show().fadeOut( 3000 );
        }
        </script>
    </body>
</html>
