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
            .disabled{
				font-size:15px;
            	color: #95a5a6;
            	font-family: "Microsoft YaHei","Lato","Helvetica Neue",Helvetica,Arial,sans-serif;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation"><a href="/admin/menu/frontend">菜单管理</a></li>
            <li role="presentation"class="active"><a href="#menuAdd" >{% if res.id is defined  %}修改菜单{% else %}添加菜单{% endif %}</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="menuAdd" style="padding-top:20px;">
                <form class="form-horizontal" method="post" action="/admin/menu/save">
                	<div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">菜单分类</label>
                        <div class="col-xs-3">
                            <select class="form-control" aria-label="menu-linkurl" name="catid">
                            	{% if cates is defined and cates is not empty %}
                            		{% for item in cates %}
                            			{% if res.cid is defined and res.cid == item.id %}
                            				<option value="{{ item.id }}" selected>{{ item.name | e }}</option>
                            			{% else %}
                            				<option value="{{ item.id }}">{{ item.name | e }}</option>
                            			{% endif %}
								    {% endfor %}
								{% endif %}
							 </select>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">上   级</label>
                        <div class="col-xs-3">
                            <select class="form-control" aria-label="menu-linkurl" name="parentid">
								  <option value="0">/</option>
								  {% if menus is defined and menus is not empty %}
                            		{% for item in menus %}
                            			{% if parentid is defined and parentid == item.id %}
									  		<option value="{{ item.id }}" selected="selected">{{ item.name | e }}</option>
                            			{% elseif res.id is defined and res.pid == item.id %}
                            				<option value="{{ item.id }}" selected="selected">{{ item.name | e }}</option>
                            			{% else %}
                            				<option value="{{ item.id }}">{{ item.name | e }}</option>
								  		{% endif %}
								    {% endfor %}
								  {% endif %}
							 </select>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">菜单名称</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="name" name="name" required="required" value="{% if res.name is defined  %}{{res.name}}{% endif %}" />
                        </div>
                    </div>
                     <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">地址</label>
                        <div class="col-xs-3">
                            <div class="input-group">
						      <span class="input-group-addon">
						        <input type="radio" name="url" id="radio_auto" aria-label="menu-linkurl" {% if res.url is defined and false != res.url %} checked="checked" {% endif %} >
						      </span>
						      <input type="text" id="outlink_input" class="form-control" aria-label="menu-linkurl" placeholder="http://" name="wirte_url" value="{% if res.url is defined and false != res.url %}{{res.url}}{% endif %}">
						    </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="input-group">
						      <span class="input-group-addon">
						        <input type="radio" name="url" aria-label="menu-linkurl" id="radio_select" {% if res.relid is defined %} checked="checked" {% endif %} >
						      </span>
						      <select class="form-control" id="outlink_select" aria-label="menu-linkurl" name="select_url"/>
								  <option disabled class="disabled">默认</option>
								  <option value="0">首页</option>
								  <option disabled class="disabled">文章分类</option>
								  {% if art_cat is defined and art_cat is not empty %}
                            		{% for item in art_cat %}
                            			{% if false != res and res.relid == item.id %}
									  		<option value="{{ item.id }}" selected>{{ item.name | e }}</option>
                            			{% else %}
                            				<option value="{{ item.id }}">{{ item.name | e }}</option>
                            			{% endif %}
								    {% endfor %}
								  {% endif %}
								  <option disabled class="disabled">页面</option>
							 </select>
						    </div>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">打开方式</label>
                        <div class="col-xs-2">
                            <select class="form-control" name="url_target">
								  <option value="0" {% if res.target is defined and 0 == res.target%} selected{% endif %}>默认方式</option>
								  <option value="1" {% if res.target is defined and 1 == res.target%} selected{% endif %}>新窗口打开</option>
							</select>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">图   标</label>
                        <div class="col-xs-3">
                        	<div class="input-group">
						      <input type="text" id="icon" class="form-control" name="icon" readonly="readonly" value="{% if res.icon is defined and false != res.icon %}{{res.icon}}{% endif %}" onclick="uploadImg();">
						      <span class="input-group-btn">
						        <button class="btn btn-default" type="button" onclick="uploadImg();">上传</button>
						      </span>
						    </div>
                        </div>                    
                   </div>
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">显   示</label>
                        <div class="col-xs-2">
                            <select class="form-control" name="is_show">
								  <option value="0" {% if res.is_show is defined and 0 == res.is_show%} selected{% endif %}>显示</option>
								  <option value="1" {% if res.is_show is defined and 1 == res.is_show%} selected{% endif %}>隐藏</option>
							</select>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">排  序</label>
                        <div class="col-xs-2">
                        	<input class="form-control" type="text" id="sort" name="sort" value="{% if res.sort is defined  %}{{res.sort}}{% else %} 50 {% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-1 col-sm-10">
                        	<input type="hidden" name="id" value="{% if res.id is defined  %}{{res.id}}{% endif %}" />
                            <button type="submit" class="btn btn-success btn-sm" style="margin-right:50px;width:70px;" id="save_menu">保存</button>
                            <button type="button" class="btn btn-default btn-sm" style="width:70px;" onclick="javascript:location.href='/admin/menu/frontend'">取消</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="alert alert-danger text-center col-xs-2" style="position:fixed; bottom:0; margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
     
     	<script type="text/plain" id="upload_ue"></script>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/ueditor/ueditor.config.js"></script>
        <script src="/ueditor/ueditor.all.js"></script>
        <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
        /*---------------图片添加-------*/    
        var _editor = UE.getEditor('upload_ue',{ 
 					sid: '<?php echo $this->session->getId();?>',
     				bizt:'menu'
         });
        
         _editor.ready(function () {
             _editor.hide();
             _editor.addListener('beforeInsertImage', function (t, arg) {     //侦听图片上传
                 
            	 $( '#icon' ).val( arg[0].src );
             });
             _editor.setDisabled( [ 'insertimage' ]);
         });
        
        function uploadImg()
        {
        	var myImage = _editor.getDialog("insertimage");
            myImage.open();
        }
        
        $(function(){
        	$( '#outlink_input' ).click(function(){
        		$( '#radio_auto' ).trigger( 'click' );
        		$( '#outlink_select' ).val( 0 );
        	});
        	$( '#outlink_select' ).click(function(){
        		$( '#radio_select' ).trigger( 'click' );
        		$( '#outlink_input' ).val( '' );
        	});
        });
        
        $( function(){
    		$( 'input, select' ).keydown( function(){
    			$( '#save_menu' ).removeAttr( 'disabled' );
    		} ).change( function(){
    			$( '#save_menu' ).removeAttr( 'disabled' );
    		} );
    	} );
    	$( '#save_menu' ).click( function(){
    		$( this ).attr( 'disabled', 'disabled' );
    	} );
        </script>
    </body>
</html>
