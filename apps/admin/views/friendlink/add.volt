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
            .input_name{
				width:120px;
            }
            .input_content{
				width:350px;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation" ><a href="/admin/friendlink/index">友情链接</a></li>
            <li role="presentation" class="active"><a href="#friendLink">{% if res.id is defined  %}修改友情链接{% else %}添加友情链接{% endif %}</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="friendLink" style="padding-top:20px;">
                <form class="form-horizontal" method="post" action="/admin/friendlink/save">
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label input_name">链接名称</label>
                        <div class="col-xs-3">
                            <input class="form-control input_content" type="text" id="name" name="form[name]" required="required" value="{% if res.name is defined  %}{{res.name}}{% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label input_name">窗口标题</label>
                        <div class="col-xs-3">
                            <input class="form-control input_content" type="text" id="title" name="form[title]" value="{% if res.title is defined  %}{{res.title}}{% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label input_name">链接地址</label>
                        <div class="col-xs-3">
                            <input class="form-control input_content" type="text" id="url" name="form[url]" value="{% if res.url is defined  %}{{res.url}}{% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label input_name">打开方式</label>
                        <div class="col-xs-2">
                            <select name="form[target]" class="form-control">
                            	<option value="1" {% if res.target is defined and 1==res.target %}selected{% endif %}>新标签页打开</option>
                            	<option value="0" {% if res.target is defined and 0==res.target %}selected{% endif %}>本窗口打开</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label input_name">logo</label>
                        <div class="col-xs-3">
                        	<div class="input-group">
						    	<input type="text" id="icon" onclick="uploadImg();" class="form-control input_content" name="form[icon]" value="{% if res.icon is defined and false != res.icon %}{{res.icon}}{% endif %}">
						        <span class="input-group-btn">
						        	<button class="btn btn-default" type="button" onclick="uploadImg();">上传</button>
						        </span>
						    </div>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback" >
                        <label class="col-xs-1 control-label input_name text-right">是否允许抓取</label>
                        <div class="col-xs-3">
                        	<label class="radio-inline">
							    <input type="radio" name="form[nofollow]" value="0" {% if res.nofollow is defined and 0 == res.nofollow %} checked="checked" {% endif %}> 不允许
							</label>
							<label class="radio-inline">
							    <input type="radio" name="form[nofollow]" value="1" {% if res.nofollow is defined and 1 == res.nofollow %} checked="checked" {% elseif res.nofollow is not defined %} checked="checked"{% endif %}> 允许
							</label>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label input_name">排序</label>
                        <div class="col-xs-2">
                            <input class="form-control input_content" type="text" id="sort" name="form[sort]" value="{% if res.sort is defined  %}{{res.sort}}{% else %}50{% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-1 col-sm-10">
                        	<input class="input_content" type="hidden" name="form[id]" value="{% if res.id is defined  %}{{res.id}}{% endif %}" />
                            <button type="submit" class="btn btn-success btn-sm" style="margin-right: 50px;width:70px;" id="has_submit">保存</button>
                            <button type="button" class="btn btn-default btn-sm" style="width:70px;" onclick="javascript:location.href='/admin/friendlink/index'">取消</button>
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
  			bizt:'logo'
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
        
        $( function(){
    		$( 'input, select' ).keydown( function(){
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
