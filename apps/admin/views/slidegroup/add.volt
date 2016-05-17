<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/toastr/toastr.min.css">
        <style>
			.col-xs-2 {
                padding-right: 0;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation"><a href="/admin/slidegroup/index">幻灯片组管理</a></li>
            {% if group.id is defined %}
            <li role="presentation" class="active"><a href="#slideGroupEdit" >修改幻灯片组</a></li>
            {% else %}
            <li role="presentation" class="active"><a href="/admin/slideGroup/add">添加幻灯片组</a></li>
            {% endif %}
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" style="padding-top:20px;">
                <form class="form-horizontal">
                
                	<div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">幻灯片组名</label>
                        <div class="col-xs-3">
                            <input class="form-control" id="name" name="name" required="required" value="{% if group.name is defined %}{{ group.name | e }}{% endif %}"/>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">幻灯片类型</label>
                        <div class="col-xs-2">
                            <select class="form-control" id="type" name="type" required="required">
                                <option value="1" {% if group.type is defined and group.type == 1 %}selected{% endif %}>图片</option>
                                <option value="2" {% if group.type is defined and group.type == 2 %}selected{% endif %}>视频</option>
                                <option value="3" {% if group.type is defined and group.type == 3 %}selected{% endif %}>FLASH</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">限制宽高</label>
                        <div class="col-xs-3">
                            <input type="checkbox" style="float:left;height:34px;line-height:34px;" id="islimit" name="islimit" required="required" {% if group.islimit is defined and 1 == group.islimit %}checked{% endif %}/>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">幻灯片宽度</label>
                        <div class="col-xs-3 input-group" style="padding:0 15px;">
                            <input class="form-control" id="width" name="width" {% if group.width is defined %} value="{{ group.width | e }}" {% else %} disabled="true"{% endif %}{% if group.islimit is defined and 1 == group.islimit %} required="true"{% endif %} />
                            <span class="input-group-addon">px</span>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">幻灯片高度</label>
                        <div class="col-xs-3 input-group" style="padding:0 15px;">
                            <input class="form-control" id="height" name="height" {% if group.height is defined %} value="{{ group.height | e }}" {% else %} disabled="true" {% endif %}{% if group.islimit is defined and 1 == group.islimit %} required="true"{% endif %} />
                            <span class="input-group-addon">px</span>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">文件大小限制</label>
                        <div class="col-xs-3 input-group" style="padding:0 15px;float:left;">
                            <input class="form-control" id="size" name="size" value="{% if group.width is defined %}{{ group.width | e }}{% else %}0{% endif %}" required="required" />
                            <span class="input-group-addon">kb</span>
                        </div>
                        <span class="col-xs-5 text-left" style="height:34px;line-height:34px;">为0则不限制，否则为最大限制值</span>
                    </div>
					
                    <div class="form-group" style="margin-top:30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                        	<input type="hidden" id="id" name="id" value="{% if group.id is defined %}{{ group.id | e }}{% endif %}" />
                            <button type="button" class="btn btn-success btn-sm" id="slideGroupSave" style="margin-right:50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="slideGroupCancel" style="width:70px;">取消</button>
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
        <script src="/bootstrap/toastr/toastr.min.js"></script>
        <script>
        	/*---------------------是否限制宽高选择--------------------*/
        	$( '#islimit' ).change( function(){
        		if( true == $( this ).prop( 'checked' ) ){
        			$( '#width' ).prop( 'disabled', false ).prop( 'required', true );
        			$( '#height' ).prop( 'disabled', false ).prop( 'required', true );
        		}else if( false == $( this ).prop( 'checked' ) ){
        			$( '#width' ).prop( 'disabled', true ).prop( 'required', false ).parents( 'div.form-group' ).removeClass( 'has-error' ).removeClass( 'has-success' );
        			$( '#height' ).prop( 'disabled', true ).prop( 'required', false ).parents( 'div.form-group' ).removeClass( 'has-error' ).removeClass( 'has-success' );
        		}
        	} );
        	
			var key = "<?php echo $this->security->getTokenKey();?>";
	     	var token = "<?php echo $this->security->getToken();?>";
	     	
	        /*-------------数据检验------------*/
	        $( 'input, select' ).blur( function(){
	        	
	            var objParent = $( this ).parents( '.form-group' );
	            var value = $( this ).val();
	            if ( !$( this ).attr( 'required' ) ){
	                return false;
	            }
	            if( value ){
					success( objParent );
	            }else{
					error( objParent );
				}
	            
	            var pattern = /^\d+$/;
	            var name = $( this ).attr( 'name' );
	            if( name == 'size' || name == 'height' || name == 'width' ){
	            	if( pattern.test( $( this ).val() ) ){
	            		success( objParent );
	            	}else{
						error( objParent );
	            	}
	            }else if( name == 'type' ){
	            	if( parseInt( $( this ).val() ) == 2 || parseInt( $( this ).val() ) == 3 ){
	            		error( objParent );
	            		toastr.error( '暂时只支持上传图片格式的幻灯片' );
	            	}
	            }
			} );
	        /* $( '#type' ).blur( function(){
	        	var objParent = $( this ).parents( '.form-group' );
            	if( parseInt( $( this ).val() ) == 2 || parseInt( $( this ).val() ) == 3 ){
            		error( objParent );
            		toastr.error( '暂不支持上传视频和FLASH' );
            	}
	        } ); */
	        
	        /*-----------提交数据-----------*/
	        $( '#slideGroupSave' ).click( function(){
	        	$( '#slideGroupSave' ).attr( 'disabled', true );
	        	
        		$( ':text, select' ).blur(); //重新检验一下数据
	           
	           if( !$( 'div.form-group' ).hasClass( 'has-error' ) ){ //数据正确可以提交表单了
					if( false == $( '#islimit' ).prop( 'checked' ) ){
						$( '#width' ).val( '' );
						$( '#height' ).val( '' );
					}
	           		var data = $( 'form' ).serialize();
	           		data += '&key=' + key + '&token=' + token;
	                //id为空说明是添加操作，否则是更新操作
					if( !$( '#id' ).val() ){
	                	$.post( '/admin/slidegroup/insert', data, function( ret ){
		                    switch( parseInt( ret.state ) ){
		                    	case 0:
		                    		successMsg( '添加成功' );
		                    		location.href = '/admin/slidegroup/index';
		                    		break;
		                    	case 1:
		                    		errorMsg( '添加失败' );
		    	                    $( '#slideGroupSave' ).attr( 'disabled', false );
		                    		break;
		                    	case 2:
		                    		errorMsg( '未找到信息，请重新添加' );
		    	                    $( '#slideGroupSave' ).attr( 'disabled', false );
		                    		break;
		                    	case 3:
		                    		errorMsg( '幻灯片组名重复，请修改' );
		                    		error( $( '#name' ).parents( 'div.form-group' ) );
		                    		$( '#slideGroupSave' ).attr( 'disabled', false );
		                    		break;
		                    }
		                    if( ret.status ){
		                    	errorMsg( ret.msg );
	                			$( '#slideGroupSave' ).attr( 'disabled', false );
		                    }
	               			key = ret.key;
	   	                    token = ret.token;
		                }, 'json' ).error( function(){
		                    errorMsg( '网络不通' );
		                } );
	                }else{
	                	$.post( '/admin/slidegroup/update', data, function( ret ){
		                    switch( parseInt( ret.state ) ){
		                    	case 0:
		                    		successMsg( '更新成功' );
		                    		location.href = '/admin/slidegroup/index';
		                    		break;
		                    	case 1:
		                    		errorMsg( '更新失败' );
		    	                    $( '#slideGroupSave' ).attr( 'disabled', false );
		                    		break;
		                    	case 2:
		                    		errorMsg( '信息传递失败，请重试' );
		    	                    $( '#slideGroupSave' ).attr( 'disabled', false );
		                    		break;
		                    	case 3:
		                    		errorMsg( '该条记录在数据库中不存在' );
		                    		$( '#slideGroupSave' ).attr( 'disabled', false );
		                    		break;
		                    }
		                    if( ret.status ){
		                    	errorMsg( ret.msg );
	                			$( '#slideGroupSave' ).attr( 'disabled', false );
		                    }
	               			key = ret.key;
	   	                    token = ret.token;
		                }, 'json' ).error( function(){
		                    errorMsg( '网络不通' );
		                } );
	                }
	            }else{
	            	$( '#slideGroupSave' ).attr( 'disabled', false );
	            }
	            return false;
	            
	        } );
	        
			/* ----------取消---------------*/
			$( '#slideGroupCancel' ).click( function(){
	            location = '/admin/slidegroup/index';
				return false;
			} );
		       
		    
		    function success( obj ){
				obj.addClass( 'has-success').removeClass('has-error');
		    }
		    
		    function error( obj ){
		        obj.addClass( 'has-error').removeClass('has-success');
		    }
		    
		    function errorMsg( msg ){
		        $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
		        $( '.alert span' ).text( msg );
		        $( '.alert' ).show().fadeOut( 3000 );
		    }
		    
		    function successMsg( msg ){
		        $( '.alert' ).addClass( 'alert-success' ).removeClass( 'alert-danger' );
		        $( '.alert span' ).text( msg );
		        $( '.alert' ).show().fadeOut( 3000 );
		    }
		    
    	</script>
    </body>
</html>
