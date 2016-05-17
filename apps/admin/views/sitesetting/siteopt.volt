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
            <li role="presentation"><a href="/admin/sitesetting/index" >基本设置</a></li>
            <li role="presentation"><a href="/admin/sitesetting/siteList">站点管理</a></li>
            <li role="presentation"class="active"><a href="#optWebsite">{% if site.id is defined  %}修改站点{% else %}添加站点{% endif %}</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="optWebsite" style="padding-top:20px;">
                <form class="form-horizontal" method="post" action="/admin/sitesetting/saveBiz">
                    
                    <div class="form-group has-feedback" >
                        <label class="col-xs-1 control-label">网站名称</label>
                        <div class="col-xs-3">
                            <textarea class="form-control" rows="3" cols="60" id="name" name="form[name]" required="required" value="{% if site.name is defined  %}{{site.name}}{% endif %}" ></textarea>
                        </div>
                        <div class="col-xs-3 position"><i class="glyphicon glyphicon-info-sign"> 一般不超过80个字符</i></div>
                    </div>
                    
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">网站域名</label>
                        <div class="col-xs-3">
                            <textarea class="form-control" rows="3" cols="60" id="domain" name="form[domain]" {% if site.domain is defined  %}readonly{% endif %} value="{% if site.domain is defined  %}{{site.domain}}{% endif %}" ></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">网站logo</label>
                        <div class="col-xs-3">
                        	<div class="input-group">
						      <input type="text" id="icon" onclick="uploadImg();" class="form-control" name="form[logo]" value="{% if site.logo is defined and false != site.logo %}{{site.logo}}{% endif %}">
						      <span class="input-group-btn">
						        <button class="btn btn-default" type="button" onclick="uploadImg();">上传</button>
						      </span>
						    </div>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback" >
                        <label class="col-xs-1 control-label">SEO关键字</label>
                        <div class="col-xs-3">
                            <textarea class="form-control" rows="3" cols="60" id="seokey" name="form[seokey]" value="{% if site.seokey is defined  %}{{site.seokey}}{% endif %}"></textarea>
                        </div>
                        <div class="col-xs-3 position"><i class="glyphicon glyphicon-info-sign"> 一般不超过100个字符，关键词用英文逗号隔开</i></div>
                    </div>
                    
                    <div class="form-group has-feedback" >
                        <label class="col-xs-1 control-label">SEO描述</label>
                        <div class="col-xs-3">
                            <textarea class="form-control" rows="3" cols="60" id="seodescr" name="form[seodescr]" value="{% if site.seodescr is defined  %}{{site.seodescr}}{% endif %}"></textarea>
                        </div>
                        <div class="col-xs-3 position"><i class="glyphicon glyphicon-info-sign"> 一般不超过200个字符</i></div>
                    </div>
                    
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">版权信息</label>
                        <div class="col-xs-3">
                            <textarea class="form-control" rows="3" cols="60" name="form[copyright]">{% if site.copyright is defined  %}{{site.copyright}}{% endif %}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">访问统计代码</label>
                        <div class="col-xs-3">
                            <textarea class="form-control" rows="3" cols="60" name="form[static_code]">{% if site.static_code is defined  %}{{site.static_code}}{% endif %}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback" >
                        <label class="col-xs-1 control-label">是否默认</label>
                        <div class="col-xs-3">
                        	<label class="radio-inline">
							  <input type="radio" name="form[is_main]" value="0" {% if site.is_main is defined and 0 == site.is_main %} checked="checked" {% endif %}> 是
							</label>
							<label class="radio-inline">
							  <input type="radio" name="form[is_main]" value="1" {% if site.is_main is defined and 1 == site.is_main %} checked="checked" {% elseif site.is_main is not defined %} checked="checked"{% endif %}> 否
							</label>
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-top:30px;">
                        <div class="col-sm-offset-1 col-sm-12">
                        	<input type="hidden" id="id" name="form[id]" value="{% if site.id is defined  %}{{site.id}}{% endif %}" />
                           	<input type="submit" value="提交" name="submit" class="btn btn-info col-sm-3 col-xs-3" id="submit_site">
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
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="/ueditor/ueditor.config.js"></script>
        <script src="/ueditor/ueditor.all.js"></script>
        <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
        <script type="text/javascript">
        /*------------防止重复点击----------*/
        $( function(){
     		$( 'input, textarea' ).keydown( function(){
     			$( '#submit_site' ).removeAttr( 'disabled' );
     		} ).change( function(){
     			$( '#submit_site' ).removeAttr( 'disabled' );
     		} );
     	} );
     	$( '#submit_site' ).click( function(){
     		$( this ).attr( 'disabled', 'disabled' );
     	} );
         
        /*------------图片添加----------*/
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
        </script>
       
    </body>
</html>
