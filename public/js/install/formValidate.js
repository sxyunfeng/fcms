/**
 * 
 */

$.extend( jQuery.validator.messages, {
    required: "必填",
	remote: "请修正该字段",
	email: "格式错误",
	number: "请输入合法数字",
	digits: "只能输入整数",
	equalTo: "请再次输入相同的值",
	maxlength: jQuery.validator.format("请输入一个 长度最多是 {0} 的字符串"),
	minlength: jQuery.validator.format("请输入一个 长度最少是 {0} 的字符串"),
	rangelength: jQuery.validator.format("请输入 一个长度介于 {0} 和 {1} 之间的字符串"),
	range: jQuery.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
	max: jQuery.validator.format("请输入一个最大为{0} 的值"),
	min: jQuery.validator.format("请输入一个最小为{0} 的值")
} );


$( document ).ready( function(){
	//正则判断commonInfo
	$.validator.addMethod( 'commonInput', function( value, element ){
		  var pattern = /^\w{3,15}$/;
		  return pattern.test( value );
	}, '请输入3-15位字母数字或下划线' );
	
	$.validator.addMethod( 'passwordInput', function( value, element ){
		  var pattern = /^\w{6,15}$/;
		  return pattern.test( value );
	}, '请输入6-15位字母数字或下划线' );
	
	//正则判断host
	$.validator.addMethod( 'hostInput', function( value, element ){
		  var pattern = /(^(\d{1,3}\.){3}\d{1,3}$)|(^localhost$)/;
		  return pattern.test( value );
	}, '请输入正确host主机名或IP地址' );
	
	//正则判断email
	$.validator.addMethod( 'emailInput', function( value, element ){
		  var pattern = /^\w+(\.\w+)*@\w+(\.\w+)+$/;
		  return pattern.test( value );
	}, '请输入Email' );
	
	$( "#inputInfo" ).validate( {
		//验证两次密码是否输入一致
		rules:{
			master_confirmpassword:{
                equalTo:"#master_password"
            }  
		},
		messages:{
            master_confirmpassword:{
                equalTo:"两次密码输入不一致"
            } 
		},
		//ajax发送数据（未使用）
		remote: {
		    url: "/install/index/test",     //后台处理程序
		    type: "post",               //数据发送方式
		    dataType: "json",           //接受数据格式   
		    data: {                     //要传递的数据
		        username: function() {
		            return $( "#db_username" ).val();
		        }
		    }
		},
		//设置错误信息显示位置
		errorPlacement:function( error, element ){
			element.parent().next().find( "span" ).css( "display", "none" );
		    error.appendTo( element.parent().next() );  
		},
		submitHandler: function() {
			
			var data = {
					"dbHost":$( "#db_host" ).val(),
					
					"dbPort":$( "#db_port" ).val(),
					
					"dbUsername":$( "#db_username" ).val(),
					
					"dbPassword":$( "#db_password" ).val(),
					
					"dbName":$( "#db_name" ).val(),
					
					"dbPrefix":$( "#db_prefix" ).val(),
					
					"masterUsername":$( "#master_username" ).val(),
					
					"masterPassword":$( "#master_password" ).val(),
					
					"masterEmail":$( "#master_email" ).val()
			};
			
			$.post( '/install/index/checkInputInfo', data, function( res ){
				if( 0 == res )
				{
					location.href = '/install/index/done';
				}
				else
				{
					alert( res );
				}
			} );
			
		}
		
	} );
} );
	
	
	

