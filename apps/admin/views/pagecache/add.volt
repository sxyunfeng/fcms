<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.css">
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
            <li role="presentation"><a href="/admin/pagecache/index">缓存管理</a></li>
            <li role="presentation"class="active"><a href="#cacheAdd" >{% if res.id is defined %}修改缓存{% else %}添加缓存{% endif %}</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="adAdd" style="padding-top:20px;">
                <form class="form-horizontal" action="/admin/pagecache/save" method="post">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">缓存名称</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="ename" name="ename" placeholder="缓存名称" required="required"  value="{% if res.cname is defined  %}{{res.cname}}{% endif %}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label"> 缓存类型</label>
                        <div class="col-xs-8">
                        	<label class="radio-inline"><input type="radio" name="type" value="0" {% if res.type is defined and 0 == res.type  %} checked="true" {% endif %} />Apc</label>
                            <label class="radio-inline"><input type="radio" name="type" value="1" {% if res.type is defined and 1 == res.type  %} checked="true" {% endif %}/>File</label>
                            <label class="radio-inline"><input type="radio" name="type" value="2" {% if res.type is defined and 2 == res.type  %} checked="true" {% endif %}/>Memcache</label>
                            <label class="radio-inline"><input type="radio" name="type" value="3" {% if res.type is defined and 3 == res.type  %} checked="true" {% endif %}/>Memory</label>
                            <label class="radio-inline"><input type="radio" name="type" value="4" {% if res.type is defined and 4 == res.type  %} checked="true" {% endif %}/>Mongo</label>
                            <label class="radio-inline"><input type="radio" name="type" value="5" {% if res.type is defined and 5 == res.type  %} checked="true" {% endif %}/>XCache</label>
                        </div>
                    </div>
                     <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">缓存时间</label>
                        <div class="col-xs-3">
                            <input class="form-control form_datetime" type="text" id="cache_time" name="cache_time" placeholder="请输缓存时间" 
                                   required="required" value="{% if res.cache_time is defined  %}{{res.cache_time}}{% endif %}"/>单位（分钟）
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-xs-2 control-label"> 是否预热</label>
                        <div class="col-xs-8">
                            <label class="radio-inline"><input type="radio" name="is_warm_up"  value="0" {% if res.is_warm_up is defined and 0 == res.is_warm_up  %} checked="true" {% endif %}/>no</label>
                            <label class="radio-inline"><input type="radio" name="is_warm_up"  value="1" {% if res.is_warm_up is defined and 1 == res.is_warm_up  %} checked="true" {% endif %} />yes</label>
                        </div>
                    </div>
                 <div class="form-group">
                        <label class="col-xs-2 control-label"> 模块归属</label>
                        <div class="col-xs-8">
                            <label class="radio-inline"><input type="radio" name="module" value="0" {% if res.module is defined and 0 == res.module  %} checked="true" {% endif %} />前台首页</label>
                            <label class="radio-inline"><input type="radio" name="module" value="1" {% if res.module is defined and 1 == res.module  %} checked="true" {% endif %} />前台列表页</label>
                            <label class="radio-inline"><input type="radio" name="module" value="2" {% if res.module is defined and 2 == res.module  %} checked="true" {% endif %} />前台详细页</label>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                        	<input type="hidden" name="id" value="{% if res.id is defined  %}{{res.id}}{% endif %}" />
                            <button type="submit" class="btn btn-success btn-sm" id="cacheInsert" style="margin-right: 50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" onclick="javascript:location.href='/admin/pagecache/index'" style="width:70px;">取消</button>
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
       				$( '#cacheInsert' ).removeAttr( 'disabled' );
        		} ).change( function(){
       				$( '#cacheInsert' ).removeAttr( 'disabled' );
        		} );
        	} );
        	$( '#cacheInsert' ).click( function(){
        		$( this ).attr( 'disabled', 'disabled' );
        	} );
        </script>
    </body>
</html>
