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
			.slide-pic{
                position:relative;
                margin:10px 0;
                width:100px;
                height:100px;
                border:none;
                display:inline-block;
				vertical-align:middle;
				text-align:center;
				color:gray;
				cursor:pointer;
            }
            .slide-pic-add{
                border:1px dashed gray;
            }
            .slide-img:nth-child(2) .glyphicon-arrow-left{
                display:none;
            }
            .slide-img:last-child .glyphicon-arrow-right{
                display:none;
            }
            .slide-pic img{
				max-height:100px;
				max-width:1200px;
            }
            .slide-pic-operate{
                position:absolute;
                bottom:0;
                width:100%;
            	text-align:center;
            	background:gainsboro;
            	display:none;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation"><a href="/admin/slide/index">幻灯片管理</a></li>
            <li role="presentation" class="active"><a href="#slideAdd" >{% if slide.id is defined %}修改幻灯片{% else %}添加幻灯片{% endif %}</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" style="padding-top:20px;">
                <form class="form-horizontal">
                
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">分组</label>
                        <div class="col-xs-2">
                            <select class="form-control" id="group" name="group" required="required">
                            	{% if groups is not empty and groups != false %}
	                            	<option value="0" >请先选择分组</option>
                            		{% for group in groups %}
                               		<option value="{{ group.id | e }}" {% if slide.groupid is defined and group.id == slide.groupid %}selected{% endif %}>{{ group.name | e }}</option>
                                	{% endfor %}
                                {% endif %}
                            </select>
                        </div>
                        <span class="col-xs-1 text-left" style="height:34px;line-height:34px;">必选</span>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">幻灯片</label>
                        <div class="col-xs-9 text-left">
                            <div style="{% if slide.dir is defined %}display:inline-block;{% else %}display:none;{% endif %}" class="slide-img-wrap">
                                <div style="{% if slide.dir is defined %}display:block;{% else %}display:none;{% endif %}" class="slide-pic slide-img">
                                    <img src="{% if slide.dir is defined %}{{ slide.dir | e }}{% endif %}" />
                                    <input type="hidden" id="dir" name="dir" value="{% if slide.dir is defined %}{{ slide.dir | escape_attr }}{% endif %}" />
                                    <div class="slide-pic-operate">
                                        <i style="margin-right:10px;" class="glyphicon glyphicon-trash"></i>
                                        <i style="margin-right:10px;" class="glyphicon glyphicon-edit"></i>
                                        <i class="glyphicon glyphicon-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="slide-pic slide-pic-add" style="{% if slide.dir is defined %} display:none; {% else %}display:block;{% endif %}">
                                <i style="margin-top:40%;" class="glyphicon glyphicon-plus"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">标题</label>
                        <div class="col-xs-3">
                            <input class="form-control" id="title" name="title" value="{% if slide.title is defined %}{{ slide.title | e }}{% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">内容</label>
                        <div class="col-xs-3">
                            <input class="form-control" id="content" name="content" value="{% if slide.content is defined %}{{ slide.content | e }}{% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">幻灯片alt</label>
                        <div class="col-xs-3">
                            <input class="form-control" id="alt" name="alt" value="{% if slide.alt is defined %}{{ slide.alt | e }}{% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">超链接</label>
                        <div class="col-xs-3">
                            <input class="form-control" id="url" name="url" value="{% if slide.url is defined %}{{ slide.url | e }}{% endif %}" />
                        </div>
                        <span class="col-xs-5 text-left" style="height:34px;line-height:34px;">格式为 http://xxx.xxx 或https://xxx.xxx</span>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">幻灯片类型</label>
                        <div class="col-xs-3">
							<input class="form-control" id="typename" name="typename" readonly="true" value="{% if slide.slidegroup.type is defined %}{% if slide.slidegroup.type === '1' %}图片{% elseif slide.slidegroup.type === '2' %}视频{% elseif slide.slidegroup.type === '3' %}FLASH{% endif %}{% endif %}" />
                        	<input class="form-control" type="hidden"　id="type" name="type" value="{% if slide.slidegroup.type is defined %}{{ slide.slidegroup.type }}{% endif %}" />
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">幻灯片宽度</label>
                        <div class="col-xs-3 input-group" style="padding:0 15px;">
                            <input class="form-control" id="width" name="width" readonly="true" value="{% if slide.width is defined %}{{ slide.width | e }}{% endif %}" />
                            <span class="input-group-addon">px</span>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">幻灯片高度</label>
                        <div class="col-xs-3 input-group" style="padding:0 15px;">
                            <input class="form-control" id="height" name="height" readonly="true" value="{% if slide.height is defined %}{{ slide.height | e }}{% endif %}" />
                            <span class="input-group-addon">px</span>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">文件大小</label>
                        <div class="col-xs-3 input-group" style="padding:0 15px;float:left;">
                            <input class="form-control" id="size" name="size" readonly="true" value="{% if slide.slidegroup.size is defined %}{{ slide.slidegroup.size | e }}{% endif %}"/>
                            <span class="input-group-addon">KB</span>
                        </div>
						<span class="col-xs-5 text-left" style="height:34px;line-height:34px;">为0则不限制，否则为最大限制值</span>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">排序</label>
                        <div class="col-xs-3" >
                            <input class="form-control" id="sort" name="sort" value="{% if slide.sort is defined %}{{ slide.sort | e }}{% else %}50{% endif %}" />
                        </div>
                        <span class="col-xs-5 text-left" style="height:34px;line-height:34px;">默认为50，数值大者优先显示，只能为非负整数</span>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">是否显示</label>
                        <div class="col-xs-3">
                            <input type="checkbox" style="float:left;height:34px;line-height:34px;" id="isshow" name="isshow" checked="true" />
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-top:30px;">
                        <div class="col-sm-offset-2 col-sm-3">
                        	<input type="hidden" id="id" name="id" value="{% if slide.id is defined %}{{ slide.id | e }}{% endif %}" />
                        	<input type="hidden" id="islimit" name="islimit" value="{% if slide.slidegroup.islimit is defined %}{{ slide.slidegroup.islimit | e }}{% endif %}" />
                        	<input type="hidden" id="groupid" name="groupid" value="{% if slide.groupid is defined %}{{ slide.groupid | e }}{% endif %}" />
                            <button type="button" class="btn btn-success btn-sm" id="slideSave" style="margin-right:50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="slideCancel" style="width:70px;">取消</button>
                        </div>
                        {% if slide.id is defined %}
                        <span class="col-xs-5 text-left" style="height:34px;line-height:34px;">保存后更新的数据才生效</span>
                        {% endif %}
                    </div>
                    
                </form>
                
            </div>
            
        </div>
        
        <div class="alert alert-danger text-center col-xs-2" style="position:fixed; bottom:0; margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
        
     	<script type="text/plain" id="upload_image" style="display:none"></script>
     	<script type="text/plain" id="upload_video"></script>
     	<script type="text/plain" id="upload_flash"></script>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="/bootstrap/toastr/toastr.min.js"></script>
        <script src="/js/fcmsIndex/iframeStyle.js"></script>
        <script src="/u/ueditor.config.js"></script>
        <script src="/u/ueditor.all.js"></script>
        <script type="text/javascript" charset="utf-8" src="/u/lang/zh-cn/zh-cn.js"></script>
        <script>
		//对于宽高是否与组信息中宽高一致的判断标记量（为true即可提交）
    	var iSubmit = false;
    	//对于是否选择幻灯片组的判断标记量（先选择过幻灯片组才可以进行下一步操作）
    	var iSelect = false;
    	//csrf验证信息
    	var key = "<?php echo $this->security->getTokenKey();?>";
     	var token = "<?php echo $this->security->getToken();?>";
     	//初始化幻灯片组信息
     	var id = 0;
    	var type = 0;
    	var typeName = '';
    	var isLimit = 0;
    	var width = 0;
    	var height = 0;
    	var size = 0;
    	var groupId = 0;
    	/*--------------初始化所有数据------------*/
    	{% if slide is defined %}
	       	$( document ).ready( function(){
	       		iSubmit = {% if slide is defined %}true{% endif %};
	       		iSelect = {% if slide is defined %}true{% endif %};
	       		id = {% if slide.id is defined %}{{ slide.id | e }}{% else %}0{% endif %};
	           	type = {% if slide.slidegroup.type is defined %}{{ slide.slidegroup.type | e }}{% else %}0{% endif %};
	           	typeName = "{% if slide.slidegroup.type is defined %}{% if slide.slidegroup.type === '1' %}图片{% elseif slide.slidegroup.type === '2' %}视频{% elseif slide.slidegroup.type === '3' %}FLASH{% else %}''{% endif %}{% endif %}";
	           	groupId = {% if slide.groupId is defined %}{{ slide.groupId | e }}{% else %}0{% endif %};
	           	isLimit = {% if slide.slidegroup.islimit is defined %}{{ slide.slidegroup.islimit | e }}{% else %}0{% endif %};
	           	width = {% if slide.width is defined %}{{ slide.width | e }}{% else %}0{% endif %};
	           	height = {% if slide.height is defined %}{{ slide.height | e }}{% else %}0{% endif %};
	           	size = {% if slide.slidegroup.size is defined %}{{ slide.slidegroup.size | e }}{% else %}0{% endif %};
	       	} );
       	{% endif %}
           	
       	/*--------------初始化图片上传插件------------*/
		var image_editor = UE.getEditor( 'upload_image', { 
			bizt : 'user',
            serverUrl:'/common/upload/ctrl.php'
		} );
		image_editor.ready( function(){
			if( parseInt( size ) ){
				this.options.imageMaxSize = parseInt( size ) * 1024;//限制上传图片大小，单位为byte
			}else{
				image_editor.options.imageMaxSize = 2 * 1024 * 1024;//默认上传图片大小限制2M
			}
			image_editor.hide();
			image_editor.addListener( 'beforeInsertImage', function( t, arg ) { //侦听图片上传
				if( arg[0].title ){
					arg[0].src = arg[0].src;
				}
				$( 'div.slide-img' ).find( 'img' ).attr( 'src' , arg[ 0 ].src );
            	$( 'div.slide-img' ).find( 'input[ type = "hidden" ]' ).val( arg[ 0 ].src );
            	$( 'div.slide-img-wrap' ).show();
            	$( 'div.slide-img' ).show();
            	$( 'div.slide-pic-add' ).hide();
            	//如果限制宽高，则与组信息进行比较，不符合则提示
            	if( parseInt( isLimit ) ){
            		$.post( '/admin/slide/getInfo', { 'dir' : arg[ 0 ].src }, function( ret ){
            			if( !ret.state ){
            				if( width != ret.width || height != ret.height ){
	            				iSubmit = false;
	            				toastr.error( '图片宽高与幻灯片组要求不符，请更换图片！' );
	            				error( $( '#dir' ).parents( 'div.form-group' ) );
	            			}else{//限制宽高时上传成功
	            				iSubmit = true;
	            				$( '#dir' ).val( arg[ 0 ].src );
	            				success( $( '#dir' ).parents( 'div.form-group' ) );
	            			}
            			}else{
            				iSubmit = false;
            				toastr.error( '验证失败，请重试' );
            				error( $( '#dir' ).parents( 'div.form-group' ) );
            			}
            		}, 'json' );
            	}else{//不限制宽高时上传成功
            		iSubmit = true;
            		$( '#dir' ).val( arg[ 0 ].src );
            		success( $( '#dir' ).parents( 'div.form-group' ) );
            	}
            } );
			image_editor.setDisabled( "insertimage" );
        } );
			
		/*--------------初始化视频上传插件------------*/
		/* var video_editor = UE.getEditor( 'upload_video', { 
			bizt : 'video'
		} );
		video_editor.ready( function(){
			video_editor.hide();
			video_editor.addListener( 'beforeInsertVideo', function( t, arg ) { //侦听图片上传
				$( 'div.slide-img' ).find( 'img' ).attr( 'src' , arg[ 0 ].src );
            	$( 'div.slide-img' ).find( 'input[ type = "hidden" ]' ).val( arg[ 0 ].src );
            	$( 'div.slide-img' ).show();
            	$( 'div.slide-pic-add' ).hide();
            } );
			video_editor.setDisabled( "insertvideo" );
        } ); */
		
		/*--------------初始化FLASH上传插件------------*/
		/* var flash_editor = UE.getEditor( 'upload_flash', { 
			bizt : 'flash'
		} );
		
		flash_editor.ready( function(){
			flash_editor.hide();
			flash_editor.addListener( 'beforeInsertImage', function( t, arg ) { //侦听图片上传
				$( 'div.slide-img' ).find( 'img' ).attr( 'src' , arg[ 0 ].src );
            	$( 'div.slide-img' ).find( 'input[ type = "hidden" ]' ).val( arg[ 0 ].src );
            	$( 'div.slide-img' ).show();
            	$( 'div.slide-pic-add' ).hide();
            } );
			flash_editor.setDisabled( "insertflash" );
        } ); */
        
        //点击删除动作
       	$( 'div.slide-pic-add' ).click( function(){
       		if( type ){
				switch( parseInt( type ) ){
      				case 1:
      					var insertDialog = image_editor.getDialog( "insertimage" );
      					break;
       				case 2:
       					var insertDialog = video_editor.getDialog( "insertvideo" );
      					break;
       				case 3:
       					var insertDialog = flash_editor.getDialog( "insertimage" );
      					break;
      				}
      				insertDialog.open();
      			}else{
      				toastr.error( '请先选择分组！' );
      				error( $( '#group' ).parents( 'div.form-group' ) );
      			}
       	} );
        
      	//点击编辑动作
        $( 'div.slide-pic-operate i.glyphicon-edit' ).click( function(){
			var myImage = image_editor.getDialog( "insertimage" );
            myImage.open();
        } );
      	
		//点击图片动作
		$( 'form' ).delegate( '.slide-img img', 'click', function(){ //图片修改
			var myImage = image_editor.getDialog( "insertimage" );
			myImage.open();
			$( 'form' ).data( 'changePic', this );
		} );
       	
		/*-------------------显示对图片的操作------------------*/
		$( 'form' ).delegate ( '.slide-img', 'mouseover', function(){ //显示对图片的操作
		    $( this ).find( '.slide-pic-operate' ).show();
		    return true;
		} );
		$( 'form' ).delegate ( '.slide-img', 'mouseout', function(){ 
		    $( this ).find( '.slide-pic-operate' ).hide();
		} );
		$( 'form' ).delegate ( '.slide-pic-operate .glyphicon', 'mouseover', function(){ //显示对图片的操作
		    $( this ).css( 'color', 'black' ); 
		} );
		$( 'form' ).delegate ( '.slide-pic-operate .glyphicon', 'mouseout', function(){ 
		   $( this ).css( 'color', 'gray' );
		} );
		
		$( 'form' ).delegate( '.glyphicon-trash', 'click', function(){
			$( 'div.slide-img' ).find( 'img' ).attr( 'src', '' );
            $( '#dir' ).val( '' );
            $( this ).parents( '.slide-pic' ).hide();
            $( '.slide-pic-add' ).show();
            if( 0 == isLimit ){
            	$( '#height' ).val( '' );
            	$( '#width' ).val( '' );
            	width = 0;
            	height = 0;
            }
            initialize();
		} );
       	
        /*-------------数据检验------------*/
        $( ':text' ).blur( function(){
            var objParent = $( this ).parents( '.form-group' );
            var value = $( this ).val();
            var sortPattern = /^\d+$/;
            var urlPattern = /^[\.\-\_\=\?\&\/\d\w\:]+$/;
            var httpPattern = /^[(http\:\/\/)(https\:\/\/)]{1}/;
            //验证排序
			if( 'sort' == $( this ).attr( 'name' ) ){
            	if( sortPattern.test( $( this ).val() ) ){
            		success( objParent );
				}else{
					error( objParent );
					return;
				}
            }else if( 'url' == $( this ).attr( 'name' ) ){//验证url
            	if( $( this ).val() ){//如果不为空再进行正则判断，如果为空就不用管
            		if( urlPattern.test( $( this ).val() ) ){
                		if( !httpPattern.test( $( this ).val() ) ){
                			$( this ).val( 'http://' + $( this ).val() );
                			success( objParent );
                		}
    				}else{
    					error( objParent );
    					return;
    				}
            	}else{
            		clear( objParent );
            	}
            }
            
            if ( !$( this ).attr( 'required' ) ){
                return false;//只检查必选项
            }
            if( value ){
				success( objParent );
			}else{
				error( objParent );
				return;
			}
            
		} );
        
        /*--------------切换幻灯片组触发------------*/
       	$( 'select#group' ).change( function(){
       		groupId = parseInt( $( this ).find( 'option:selected' ).val() );
       		if( groupId ){
       			iSelect = true;
       			$.get( '/admin/slide/getgroups/id/' + groupId, function( ret ){
       				if( ret ){
       					type    = ret.type;
          				isLimit = ret.islimit;
           				width   = ret.width?ret.width:0;
           				height  = ret.height?ret.height:0;
           				size 	= ret.size;
           				switch ( parseInt( type ) ){
                			case 1:
                				typeName = '图片';
                 				break;
                			case 2:
                 				typeName = '视频';
                 				break;
                 			case 3:
                 				typeName = 'FLASH';
                 				break;
    					}
           				
           				$( '#type' ).val( type );
           				$( '#typename' ).val( typeName );
                   		$( '#width' ).val( width );
                   		$( '#height' ).val( height );
                   		$( '#size' ).val( size );
                   		$( '#islimit' ).val( isLimit );
                   		$( '#groupid' ).val( groupId );
                   		success( $( '#group' ).parents( 'div.form-group' ) );
                   		
                   		if( size ){
                   			image_editor.options.imageMaxSize = parseInt( size ) * 1024;//限制上传图片大小，单位为byte
                   		}else{
                   			image_editor.options.imageMaxSize = 2 * 1024 * 1024;//默认上传图片大小限制2M
                   		}
       				}
           		}, 'json' );
       		}else{
       			iSelect = false;
       			type = 0;
               	typeName = '';
               	isLimit = 0;
               	width = 0;
               	height = 0;
               	size = 0;
               	error( $( '#group' ).parents( 'div.form-group' ) );
       		}
       	} );
        
        /*-----------提交数据-----------*/
        $( '#slideSave' ).click( function(){
        	$( '#slideSave' ).attr( 'disabled', true );
        	
       		$( ':text' ).blur(); //重新检验一下数据
           
       		if( !iSelect ){
       			errorMsg( '还未选择分组' );
       			error( $( '#group' ).parents( 'div.form-group' ) );
       			$( '#slideSave' ).attr( 'disabled', false );
       		}else if( !iSubmit ){
       			errorMsg( '幻灯片信息有误' );
       			error( $( '#dir' ).parents( 'div.form-group' ) );
       			$( '#slideSave' ).attr( 'disabled', false );
       		}else if( $( 'div.form-group' ).hasClass( 'has-error' ) ){ //数据正确可以提交表单了
       			errorMsg( '请检查数据后再提交' );
            	$( '#slideSave' ).attr( 'disabled', false );
            }else if( !$( '#dir' ).val() ){
            	errorMsg( '请先添加幻灯片' );
            	error( $( '#dir' ).parents( 'div.form-group' ) );
            	$( '#slideSave' ).attr( 'disabled', false );
            }else{
            	var data = $( 'form' ).serialize();
                data += '&key=' + key + '&token=' + token;
                
                //id为空说明是添加操作，否则是更新操作
				if( !$( '#id' ).val() ){
                	$.post( '/admin/slide/insert', data, function( ret ){
	                    switch( parseInt( ret.state ) ){
	                    	case 0:
	                    		successMsg( '添加成功' );
	                    		location.href = '/admin/slide/index';
	                    		break;
	                    	case 1:
	                    		errorMsg( '添加失败' );
	    	                    $( '#slideSave' ).attr( 'disabled', false );
	                    		break;
	                    	case 2:
	                    		errorMsg( '未找到信息，请重新添加' );
	    	                    $( '#slideSave' ).attr( 'disabled', false );
	                    		break;
	                    }
	                    if( ret.status ){
	                    	errorMsg( ret.msg );
                			$( '#slideSave' ).attr( 'disabled', false );
	                    }
	                    key = ret.key;
	                    token = ret.token;
	                }, 'json' ).error( function(){
	                    errorMsg( '网络不通，请刷新后重试' );
	                    $( '#slideSave' ).attr( 'disabled', false );
	                } );
                }else{
                	$.post( '/admin/slide/update', data, function( ret ){
	                    switch( parseInt( ret.state ) ){
	                    	case 0:
	                    		successMsg( '更新成功' );
	                    		location.href = '/admin/slide/index';
	                    		break;
	                    	case 1:
	                    		errorMsg( '更新失败' );
	    	                    $( '#slideSave' ).attr( 'disabled', false );
	                    		break;
	                    	case 2:
	                    		errorMsg( '信息传递失败，请重试' );
	    	                    $( '#slideSave' ).attr( 'disabled', false );
	                    		break;
	                    }
	                    if( ret.status ){
	                    	errorMsg( ret.msg );
                			$( '#slideSave' ).attr( 'disabled', false );
	                    }
	                    key = ret.key;
	                    token = ret.token;
	                }, 'json' ).error( function(){
	                    errorMsg( '网络不通，请刷新后重试' );
	                    $( '#slideSave' ).attr( 'disabled', false );
	                } );
                }
            }
            return false;
            
        } );
        
		/* ----------取消---------------*/
		$( '#slideCancel' ).click( function(){
            location = '/admin/slide/index';
			return false;
		} );
	    
		/* ----------初始化幻灯片上传---------------*/
		function initialize(){
			iSubmit = false;
	     	$( '#dir' ).val( '' );
        	$( 'div.has-error,div.has-success' ).each( function(){
        		$( this ).removeClass( 'has-error' );
        		$( this ).removeClass( 'has-success' );
        	} );
		}
	    
	    function success( obj ){
			obj.addClass( 'has-success' ).removeClass( 'has-error' );
	    }
	    
	    function error( obj ){
	        obj.addClass( 'has-error' ).removeClass( 'has-success' );
	    }
	    
	    function clear( obj ){
	    	obj.removeClass( 'has-error' ).removeClass( 'has-success' );
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
