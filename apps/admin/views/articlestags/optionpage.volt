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
            <li role="presentation"><a href="/admin/ArticlesTags/index">Tags 列表</a></li>
            <li role="presentation"class="active"><a href="#tagsAdd" >{% if res.id is defined %}修改Tags{% else %}添加Tags{% endif %}</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="tagsAdd" style="padding-top:20px;">
                <form class="form-horizontal" method="post" action="/admin/ArticlesTags/save" onsubmit="return validations();">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">Tag 名</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="tagname" name="tagname" required="required" value="{% if res.name is defined  %}{{res.name}}{% endif %}" />
                        </div>
                    </div>
                  
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">SEO标题</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="seotitle" name="seotitle" value="{% if res.seo is defined  %}{{res.seo}}{% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">SEO关键词</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="seokey" name="seokey" value="{% if res.seokey is defined  %}{{res.seokey}}{% endif %}" />
                        </div>
                    </div>
                   
                     <div class="form-group has-feedback text-right" >
                        <label class="col-xs-2 control-label">SEO描述</label>
                        <div class="col-xs-3">
                            <textarea class="form-control" rows="5" cols="80" id="seodescr" name="seodescr">{% if res.seodescr is defined  %}{{res.seodescr}}{% endif %}</textarea>
                        </div>
                    </div>
                 
                    <div class="form-group">
                        <label class="col-xs-2 control-label"> 是否显示</label>
                        <div class="col-xs-8">
                            <label class="radio-inline"><input type="radio" name="show" value="0" {% if res.display is defined and 0 == res.display  %}checked="checked"{%else%}checked=""{% endif %}/>是</label>
                            <label class="radio-inline"><input type="radio" name="show" value="1" {% if res.display is defined and 1 == res.display  %}checked="checked"{% endif %}/>否</label>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">拼音</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="pinyin" name="pinyin" placeholder="留空则自动生成" value="{% if res.pinyin is defined  %}{{res.pinyin}}{% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">首字母</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="fname" name="fname" placeholder="留空则自动生成" value="{% if res.fname is defined  %}{{res.fname}}{% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">网址</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="linkurl" name="linkurl" placeholder="留空则自动生成" value="{% if res.linkurl is defined  %}{{res.linkurl}}{% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">排序</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="sort" name="sort" value="{% if res.sort is defined  %}{{res.sort}}{% else %} 20 {% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                        	<input type="hidden" name="id" value="{% if res.id is defined  %}{{res.id}}{% endif %}" />
                            <button type="submit" class="btn btn-success btn-sm" style="margin-right: 50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" style="width:70px;" onclick="javascript:location.href='/admin/ArticlesTags/index'">取消</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div style="left: 40%;margin-left: -15px;margin-top: -15px;position: absolute;top: 40%; display:none">
          	<div class="alert alert-danger alert-dismissable">
              <h4><i class="glyphicon glyphicon-info-sign"></i> 提示信息!</h4>
              <p id="dis_message"></p>
            </div>
        </div>
     
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
        function validations()
        {
        	var sort = $.trim( $( '#sort' ).val() );
        	var regDigital = /^[0-9]*$/;
        	if( false != sort )
        	{
        		if( !regDigital.test( sort ) )
        		{
        			$( '#dis_message' ).html( '排序字段只支持数字,请重新输入.' );
					$( '#dis_message' ).parent().parent().fadeIn( 500 );
					setTimeout( function(){
						$( '#dis_message' ).parent().parent().fadeOut( 1000 );
					}, '3000' );
					$( '#sort' ).focus();
        			return false;
        		}
        	}
        }
        </script>
    </body>
</html>
