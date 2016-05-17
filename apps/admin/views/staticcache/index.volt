<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet"  href="/css/admin/font-awesome.min.css" >
        <style>
            .operate {
                margin-right: 10px;
            }
            .operate:hover {
                cursor:pointer;
                color:green;
            }
			table tr td,th{
				text-align:center
			}
			.cst-form-control {
			    background-color: #fff;
			    background-image: none;
			    border: 1px solid #ccc;
			    border-radius: 4px;
			    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
			    color: #555;
			    display: block;
			    font-size: 14px;
			    height: 34px;
			    line-height: 1.42857;
			    padding: 6px 12px;
			    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
			}
			span.info{
				font-size: 13px;
				color:#95a5a6;
			}
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#defaultConfig">配置项</a></li>
            <li role="presentation"><a href="/admin/staticcache/column">栏目配置</a></li>
            <li role="presentation"><a href="/admin/staticcache/list">列表配置</a></li>
            <li role="presentation"><a href="/admin/staticcache/detail">详细页配置</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="defaultConfig">
                <table class="table table-bordered">
                    <tbody>
                       <tr class="basic_conf">
                       		<th rowspan="4" width="20%" style="padding-top:8%;">基本配置</th>
                       		<td>栏目缓存时间配置</td>
                       		<td>
                       			<input type="text" class="col-xs-6 col-md-6 cst-form-control" name="columnTime" id="columnTime" value="{% if base.index is defined and false != base.index  %}{{ base.index }}{% endif %}" />
                       			<span class="col-xs-6 col-md-3 info text-left" style="padding-top:5%">/分钟</span>
                       		</td>
                       		<td rowspan="3">
                       			<div class="col-md-12 col-xs-12 text-left">
                       				<font size="3"><i class="fa fa-info-circle"></i></font> <span class="info"></span>
                       			</div>
                       		</td>
                       </tr>
                       <tr class="basic_conf">
                       	<td>列表缓存时间配置</td>
                       	<td>
                       		<input type="text" class="col-xs-6 col-md-6 cst-form-control" name="listTime" id="listTime" value="{% if base.list is defined and false != base.list  %}{{ base.list }}{% endif %}" />
                       		<span class="col-xs-6 col-md-3 info text-left" style="padding-top:5%">/分钟</span>
                       	</td>
                       </tr>
                       <tr class="basic_conf">
                       	<td>详细页缓存时间配置</td>
                       	<td>
                       		<input type="text" class="col-xs-6 col-md-6 cst-form-control" name="detailTime" id="detailTime" value="{% if base.detail is defined and false != base.detail  %}{{ base.detail }}{% endif %}" />
                       		<span class="col-xs-6 col-md-3 info text-left" style="padding-top:5%">/分钟</span>
                       	</td>
                       </tr>
                       <tr>
                       	<td colspan="2"></td>
                       	<td>
                       		<button type="button" id="btnBase" class="btn btn-primary">确认修改</button>
                       		<input type="hidden" name="time_id" value="{% if base.id is defined and false != base.id  %}{{ base.id }}{% endif %}" />
                       	</td>
                       </tr>
                       <tr class="driver_conf">
                       		<th rowspan="4" style="padding-top:8%;">驱动配置</th>
                       		<td>栏目配置</td>
                       		<td>
                       			 <input type="radio" name="column" id="driver_index_File" value="0"> File
                       			 <input type="radio" name="column" id="driver_index_Memcache" value="1" style="margin-left:20%;" disabled data-toggle="tooltip" data-placement="top" title="该功能正开发中..." > Memcache
                       		</td>
                       		<td rowspan="3">
                       			<div class="col-md-12 col-xs-12 text-left">
                       				<font size="3"><i class="fa fa-info-circle"></i></font> 
                       				<span class="info">默认静态化驱动为文件缓存<br /> 如果选择Memcache驱动请在<br />下一栏对应位置填写<br />memcache存储位置信息</span>
                       			</div>
                       		</td>
                       </tr>
                       <tr class="driver_conf">
                       	<td>列表配置</td>
                       	<td>
                  			 <input type="radio" name="list" id="driver_list_File" value="0" > File
                  			 <input type="radio" name="list" id="driver_list_Memcache" value="1" style="margin-left:20%;" disabled data-toggle="tooltip" data-placement="top" title="该功能正开发中..."> Memcache
                  		</td>
                       </tr>
                       <tr class="driver_conf">
                       	<td>详情页配置</td>
                       	<td>
                       		<input type="radio" name="detail" id="driver_detail_File" value="0" > File
                  			<input type="radio" name="detail" id="driver_detail_Memcache" value="1" style="margin-left:20%;" disabled data-toggle="tooltip" data-placement="top" title="该功能正开发中..."> Memcache
                       	</td>
                       </tr>
                       <tr>
                       	<td colspan="2"></td>
                       	<td>
                       		<button type="button" id="btnDriver" class="btn btn-primary">确认修改</button>
                       		<input type="hidden" name="driver_id" value="{% if driver.id is defined and false != driver.id  %}{{ driver.id }}{% endif %}" />
                       	</td>
                       </tr>
                       <tr class="storage_conf">
                       		<th rowspan="4" style="padding-top:8%;">存储配置</th>
                       		<td>栏目配置</td>
                       		<td>
                       			<input type="text" class="col-xs-6 col-md-6 form-control" name="cStorage" id="cStorage" value="{% if storage.index is defined and false != storage.index %}{{ storage.index }}{% else %}/static/cms/index/index{% endif %}" />
                       		</td>
                       		<td rowspan="3">
                       			<div class="col-md-12 col-xs-12 text-left">
                       				<font size="3"><i class="fa fa-info-circle"></i></font> 
                       				<span class="info">/ 代表网站根目录<br/> 如果是Memcache驱动请输入<br />全路径。 <br />eg: http://127.0.0.1/caches</span> 
                       			</div>
                       		</td>
                       </tr>
                       <tr class="storage_conf">
                        <td>列表配置</td>
                       	<td>
                       		<input type="text" class="col-xs-6 col-md-6 form-control" name="lStorage" id="lStorage" value="{% if storage.list is defined and false != storage.list  %}{{ storage.list }}{% else %}/static/cms/index/list{% endif %}" />
                       	</td>
                       </tr>
                       <tr class="storage_conf">
                        <td>详情页配置</td>
                       	<td>
                       		<input type="text" class="col-xs-6 col-md-6 form-control" name="dStorage" id="dStorage" value="{% if storage.detail  is defined and false != storage.detail %}{{ storage.detail }}{% else %}/static/cms/index/detail{% endif %}" />
                       	</td>
                       </tr>
                       <tr>
                       	<td colspan="2"></td>
                       	<td>
                       		<input type="hidden" name="storage_id" value="{% if storage.id  is defined and false != storage.id %}{{ storage.id }}{% endif %}" />
                       		<button type="button" id="btnStorage" class="btn btn-primary">确认修改</button>
                       	</td>
                       </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div style="left: 30%;margin-left: -15px;margin-top: -15px;position: absolute;top: 50%; display:none;" class="text-center col-xs-4">
          	<div class="alert alert-dismissable ">
              <h4><i class="glyphicon glyphicon-info-sign"></i> 提示信息!</h4>
              <p id="dis_message"></p>
            </div>
    	</div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/js/admin/static/index.js"></script>
        <script type="text/javascript">
		var iColumnIndex = '<?php if( false != $driver && false != $driver->index ) echo $driver->index; else echo 0; ?>';
        var iColumnList = '<?php if( false != $driver && false != $driver->list ) echo $driver->list; else echo 0; ?>';
        var iColumnDetail = '<?php if( false != $driver && false != $driver->detail ) echo $driver->detail; else echo 0; ?>';
        
        /*-----------防止重复点击----------*/
        $( function(){
        	$( 'tr.basic_conf input' ).keydown( function(){
    			$( '#btnBase' ).removeAttr( 'disabled' );
    		} ).change( function(){
    			$( '#btnBase' ).removeAttr( 'disabled' );
    		} );
        	
        	$( 'tr.driver_conf input' ).keydown( function(){
    			$( '#btnDriver' ).removeAttr( 'disabled' );
    		} ).change( function(){
    			$( '#btnDriver' ).removeAttr( 'disabled' );
    		} );
        	
        	$( 'tr.storage_conf input' ).keydown( function(){
    			$( '#btnStorage' ).removeAttr( 'disabled' );
    		} ).change( function(){
    			$( '#btnStorage' ).removeAttr( 'disabled' );
    		} );
        	
    		$( '#btnBase' ).click( function(){
    			$( this ).attr( 'disabled', 'disabled' );
    		} );
    		
    		$( '#btnDriver' ).click( function(){
    			$( this ).attr( 'disabled', 'disabled' );
    		} );
    		
    		$( '#btnStorage' ).click( function(){
    			$( this ).attr( 'disabled', 'disabled' );
    		} );
    	} );
        </script>
    </body>
</html>