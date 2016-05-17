<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/toastr/toastr.min.css">
        <style>
			.col-xs-2{
                padding-right: 0;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation"><a href="/admin/backup/index">备份列表</a></li>
            <li role="presentation" class="active"><a href="#backupAdd" >{% if backup.id is defined %}修改备份{% else %}添加备份{% endif %}</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" style="padding-top:20px;">
                <form class="form-horizontal">
                
                    <div class="form-group has-feedback">
                        <label class="col-xs-2 control-label">备份名称</label>
                        <div class="col-xs-3 input-group" style="padding:0 15px;float:left;">
                            <input class="form-control" id="name" name="name" value="{% if backup.name is defined %}{{ backup.name | e }}{% endif %}" />
                        	<span class="input-group-addon">.zip</span>
                        </div>
						<span class="col-xs-5 text-left alertMsg" style="height:34px;line-height:34px;">名称只能为1-32位数字、字母或下划线</span>
                    </div>
                    
                    <div class="form-group has-feedback">
                        <label class="col-xs-2 control-label">备份内容</label>
                        <div class="col-xs-3 input-group" style="padding:0 15px;float:left;">
                        	<div class="radio backupOpt">
	                            <label>
									<input type="radio" name='backupOpt' id="backupAll" value="1" checked='true'> 全部备份
							    </label>
							    <label>
									<input type="radio" name='backupOpt' id="backupSelect" value="0"> 自定义备份
						    	</label>
						    </div>
						    <div class="backupSelectOpt" style="display:none;" >
								<label class="checkbox-inline">
									<input type="checkbox" name="sql" id="sql" checked="true"> 数据库文件
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" name="image" id="image" checked="true"> 图片文件
								</label>
							</div>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">备份方式</label>
                        <div class="col-xs-2">
                            <select class="form-control" id="method" name="method" >
                            	<option value="0">保存到服务器</option>
                            	<option value="1">直接下载</option>
                            </select>
                        </div>
                        <span class="col-xs-offset-1 col-xs-5 text-left methodAlert alertMsg" style="height:34px;line-height:34px;">备份在服务器上可能会有安全隐患</span>
                    </div>
                    
                    <div class="form-group" style="margin-top:30px;">
                        <div class="col-xs-offset-2 col-sm-3">
                        	<input type="hidden" id="id" name="id" value="{% if backup.id is defined %}{{ backup.id | e }}{% endif %}" />
                            <button type="button" class="btn btn-success btn-sm" id="backupSave" style="margin-right:50px;width:70px;">保存</input>
                            <button type="button" class="btn btn-default btn-sm" id="backupCancel" style="width:70px;">取消</button>
                        </div>
                        {% if backup.id is defined %}
                        <span class="col-xs-5 text-left" style="height:34px;line-height:34px;">保存后更新的数据才生效</span>
                        {% endif %}
                    </div>
                    
                </form>
                
            </div>
            
        </div>
        
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="/bootstrap/toastr/toastr.min.js"></script>
        <script src="/js/fcmsIndex/iframeStyle.js"></script>
        <script>
        
		var key = "<?php echo $this->security->getTokenkey(); ?>";
		var token = "<?php echo $this->security->getToken(); ?>";
        
		$( 'input:radio[name="backupOpt"]' ).change( function(){
			if( true == $( 'input#backupSelect' ).prop( 'checked' ) ){//若是选中的是自定义备份，则显示自定义选项
				$( '.backupSelectOpt' ).css( 'display', 'block' );
			}else{//若是选中的是全部备份，则隐藏自定义选项
				$( '.backupSelectOpt' ).css( 'display', 'none' );
			}
		} );
		
		$( 'select#method' ).change( function(){
			if( !parseInt( $( 'select#method option:selected' ).val() ) ){//选中的是保存到服务器
				$( '.methodAlert' ).css( 'display', 'inline' );
				$( '#backupSave' ).html( '保存' );
			}else{
				$( '.methodAlert' ).css( 'display', 'none' );
				$( '#backupSave' ).html( '下载' );
			}
		} );
		
		//提交前数据检查
		function checkInput(){
			var name = $( 'input#name' ).val();
			var obj = {
				0 : $( 'input#name' ).parents( 'div.form-group' ),
				1 : $( '.backupSelectOpt' ).parents( 'div.form-group' )
			}
			for( var i = 0; i < obj.length; ++i ){
				clear( obj[i] );
			}
			if( name ){
				var pattern = /^[\d\w]{1,32}$/;
				if( !pattern.test( name ) ){
					toastr.error( '名称不合法' );
					error( obj[0] );
				}else{
					success( obj[0] );
					if( true == $( 'input#backupSelect' ).prop( 'checked' ) ){
						if( !$( '.backupSelectOpt input:checkbox:checked' ).size() ){
							toastr.error( '至少选择一项需要备份的内容' );
							error( obj[1] );
						}else{
							success( obj[1] );
						}
					}
				}
			}else{
				toastr.error( '名称不能为空' );
				error( obj[0] );
			}
			
		}
		
		//清除所有状态信息
		function clearAll(){
			$( 'div.form-group' ).each( function(){
				clear( $( this ) );
			} );
		}
		$( '#backupSave' ).click( function(){
			clearAll();
			checkInput();
			if( !$( 'div.form-group' ).hasClass( 'has-error' ) ){//全部正确后提交信息
				var data = {
					'name'      : $( '#name' ).val(),
					'backupOpt' : $( "input[name='backupOpt']:checked" ).val(),
					'sql'       : $( "input[name='sql']" ).is( ':checked' ),
					'image'     : $( "input[name='image']" ).is( ':checked' ),
					'method'    : $( "#method" ).val(),
					'key'       : key,
					'token'     : token
				};
				$.post( '/admin/backup/insert', data, function( ret ){
					switch( parseInt( ret.state ) ){
						case 0:
							if( parseInt( ret.method ) ){//直接下载
								window.open( '/admin/backup/download/name/' + ret.zipName + '/method/' + parseInt( ret.method ) );
							}else{//保存到服务器（直接跳转到列表页）
								toastr.success( '添加成功' );
								location.href = "/admin/backup/index";
							}
							break;
						case 1:
							error( $( '#name' ).parents( 'div.from-group' ) );
							toastr.error( '备份名称不合法' );
							break;
						case 2:
							toastr.error( '压缩失败，请重试' );
							break;
						case 3:
							toastr.error( '请至少选择一个备份的内容' );
							error( $( '#backupSelect' ).parents( 'div.from-group' ) );
							break;
						case 4:
							toastr.error( '无法导出数据库，请重试' );
							break;
						case 5:
							toastr.error( '数据库中没有内容，无需备份' );
							break;
					}
					key = ret.key;
					token = ret.token;
				}, 'json' );
			}
		} );
		
		/* ----------取消---------------*/
		$( '#backupCancel' ).click( function(){
            location = '/admin/backup/index';
			return false;
		} );
		
	    function success( obj ){
			obj.addClass( 'has-success' ).removeClass( 'has-error' );
	    }
	    
	    function error( obj ){
	        obj.addClass( 'has-error' ).removeClass( 'has-success' );
	        return;
	    }
	    
	    function clear( obj ){
	    	obj.removeClass( 'has-error' ).removeClass( 'has-success' );
	    }
	    
	    function successAlert( obj ){
	    	obj.find( '.alertMsg' ).html( '' ).css( 'color', 'black' );
	    }
	    
	    function errorAlert( obj, msg ){
	    	obj.find( '.alertMsg' ).html( msg ).css( 'color', '#BA4442' );
	    }
    	</script>
    </body>
</html>
