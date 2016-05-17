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
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation"><a href="/admin/menu/category">菜单分类</a></li>
            <li role="presentation" class="active"><a href="#menuCateAdd" >{% if res.id is defined  %}修改分类{% else %}添加分类{% endif %}</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="menuCateAdd" style="padding-top:20px;">
                <form class="form-horizontal" method="post" action="/admin/menu/saveBiz">
                	<div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">分类名</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="name" name="name" required="required" value="{% if res.name is defined  %}{{res.name}}{% endif %}" />
                        </div>
                    </div>
                     <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">备注</label>
                        <div class="col-xs-3">
                            <textarea class="form-control" cols="57" rows="5" id="descr" name="descr"></textarea>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">主菜单</label>
                        <div class="col-xs-1">
                            <input class="form-control" type="checkbox" id="is_main" name="is_main" {% if res.is_main is defined and 1 == res.is_main  %} {% else %}checked="true"{% endif %} />
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-1 col-sm-6">
                           	<input type="hidden" name="id" value="{% if res.id is defined  %}{{res.id}}{% endif %}" />
                           	<input type="submit" value="提交" name="submit" class="btn btn-info col-sm-6 col-xs-3" id="has_submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="alert alert-danger text-center col-xs-2" style="position:fixed; bottom:0; margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
     
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script>
	        $( function(){
	    		$( 'input' ).keydown( function(){
	    			$( '#has_submit' ).removeAttr( 'disabled' );
	    		} ).change( function(){
	    			$( '#has_submit' ).removeAttr( 'disabled' );
	    		} );
	    	} );
	    	$( '#has_submit' ).click( function(){
	    		$( this ).attr( 'disabled', 'disabled' );
	    	} );
        </script>
    </body>
</html>
