var regEmail = /^([a-zA-Z0-9]+[_|\_|\.|-]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
var pattern =/(^[0-9]{3,4}\-[0-9]{3,8}$)|(^[0-9]{3,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^0{0}1[0-9]{10}$)/;
var cellReg = /^1(3|5|8|4|)\d{9}$/;

//提交之前验证
function checkVals()
{
	//登陆名称  - 首先获取全部登陆名称
	var strLogin = $( '#login_name' ).val();
	if( '' == strLogin || strLogin.length < 1 )
	{
		$( '#tipDialog' ).html( '请输入用户登陆名称' );
		$('#litModal').modal({
		  keyboard:true,
		  show:true,
		  backdrop:false,
		});
		$("#litModal").modal().css({
	        "margin-top": function () {
	            return ($(this).height() / 10 );
	        },
	        "margin-left": function () {
	            return ($(this).width() / 4 );
	        },
	    });
		setTimeout( function(){
			$( '#litModal' ).modal( 'hide' );
		}, 1567 );
		
		$( '#name-div' ).addClass( 'has-error' );
		$( '#name-div' ).removeClass( 'has-success' );
		$( '#nameerror' ).show();
		$( '#nameok' ).hide();
		return false;
	}
	else
	{
		if( false == iSign )
		{
			//ajax 重名验证
			$.get( '/pri/Users/getLoginName', function( ret ){
				if( 1 != ret.state )
				{
					var iLen = ret.data.length;
					for( i in ret.data )
					{
						if( $.trim(ret.data[i]) == $.trim( strLogin ) )
						{
							$( '#tipDialog' ).html( '该名称已被占用,请重新输入' );
							$('#litModal').modal({
							  keyboard:true,
							  show:true,
							  backdrop:false,
							});
							$("#litModal").modal().css({
						        "margin-top": function () {
						            return ($(this).height() / 10 );
						        },
						        "margin-left": function () {
						            return ($(this).width() / 4 );
						        },
						    });
							setTimeout( function(){
								$( '#litModal' ).modal( 'hide' );
							}, 1000 );
							
							$( '#name-div' ).removeClass( 'has-success' );
							$( '#name-div' ).addClass( 'has-error' );
							$( '#nameerror' ).show();
							$( '#nameok' ).hide();
							return false;
						}
					}
					
					$( '#name-div' ).addClass( 'has-success' );
					$( '#name-div' ).removeClass( 'has-error' );
					$( '#nameerror' ).hide();
					$( '#nameok' ).show();
					
				}
			}, 'json');
		}
		
	}
	//密码
	if( false == iSign )
	{
		var strPasswd = $( '#password' ).val();
		if( '' == strPasswd )
		{
			$( '#tipDialog' ).html( '密码项不能为空' );
			$('#litModal').modal({
			  keyboard:true,
			  show:true,
			  backdrop:false,
			});
			$("#litModal").modal().css({
		        "margin-top": function () {
		            return ($(this).height() / 10 );
		        },
		        "margin-left": function () {
		            return ($(this).width() / 4 );
		        },
		    });
			setTimeout( function(){
				$( '#litModal' ).modal( 'hide' );
			}, 1567 );
			
			$( '#passwd-div' ).removeClass( 'has-success' );
			$( '#passwd-div' ).addClass( 'has-error' );
			$( '#passwderror' ).show();
			$( '#passwdok' ).hide();
			return false;
		}
		else if( strPasswd.length < 6 )
		{
			$( '#tipDialog' ).html( '密码不安全,请您输入六位或六位以上' );
			$('#litModal').modal({
			  keyboard:true,
			  show:true,
			  backdrop:false,
			});
			$("#litModal").modal().css({
		        "margin-top": function () {
		            return ($(this).height() / 10 );
		        },
		        "margin-left": function () {
		            return ($(this).width() / 4 );
		        },
		    });
			setTimeout( function(){
				$( '#litModal' ).modal( 'hide' );
			}, 1567 );
			
			$( '#passwd-div' ).removeClass( 'has-success' );
			$( '#passwd-div' ).addClass( 'has-error' );
			$( '#passwderror' ).show();
			$( '#passwdok' ).hide();
			return false;
		}
		else
		{
			$( '#passwd-div' ).addClass( 'has-success' );
			$( '#passwd-div' ).removeClass( 'has-error' );
			$( '#passwderror' ).hide();
			$( '#passwdok' ).show();
		}
	}
	//角色
	var iRole = $( '#userRoles' ).val();
	if( 0 == iRole )
	{
		$( '#tipDialog' ).html( '请选择该用户的角色' );
		$('#litModal').modal({
		  keyboard:true,
		  show:true,
		  backdrop:false,
		});
		$("#litModal").modal().css({
	        "margin-top": function () {
	            return ($(this).height() / 10 );
	        },
	        "margin-left": function () {
	            return ($(this).width() / 4 );
	        },
	    });
		setTimeout( function(){
			$( '#litModal' ).modal( 'hide' );
		}, 1567 );
		return false;
	}
	//昵称
	var user_name = $( '#user_name' ).val();
	if( '' != user_name && user_name.length > 1 )
	{
		$( '#uname-div' ).addClass( 'has-success' );
		$( '#uname-div' ).removeClass( 'has-error' );
		$( '#unameerror' ).hide();
		$( '#unameok' ).show();
	}
	//电话
	var phone = $( '#phone' ).val();
	if( '' != phone && phone.length > 0 )
	{
		if( !pattern.test( phone ) )
		{
			$( '#tipDialog' ).html( '请输入正确的电话号码:电话号码格式为国家代码(2到3位)-区号(2到3位)-电话号码(7到8位)-分机号(3位)' );
			$('#litModal').modal({
			  keyboard:true,
			  show:true,
			  backdrop:false,
			});
			$("#litModal").modal().css({
		        "margin-top": function () {
		            return ($(this).height() / 10 );
		        },
		        "margin-left": function () {
		            return ($(this).width() / 4 );
		        },
		    });
			setTimeout( function(){
				$( '#litModal' ).modal( 'hide' );
			}, 1567 );
			
			$( '#phone-div' ).removeClass( 'has-success' );
			$( '#phone-div' ).addClass( 'has-error' );
			$( '#phoneerror' ).show();
			$( '#phoneok' ).hide();
			return false;
		}
		else
		{
			$( '#phone-div' ).addClass( 'has-success' );
			$( '#phone-div' ).removeClass( 'has-error' );
			$( '#phoneerror' ).hide();
			$( '#phoneok' ).show();
		}
	}
	//手机号
	var cellphone = $( '#cellphone' ).val();
	if( '' != cellphone && cellphone.length > 0 )
	{
		if( !cellReg.test( cellphone ) )
		{
			$( '#tipDialog' ).html( '请输入正确的手机号码' );
			$('#litModal').modal({
			  keyboard:true,
			  show:true,
			  backdrop:false,
			});
			$("#litModal").modal().css({
		        "margin-top": function () {
		            return ($(this).height() / 10 );
		        },
		        "margin-left": function () {
		            return ($(this).width() / 4 );
		        },
		    });
			setTimeout( function(){
				$( '#litModal' ).modal( 'hide' );
			}, 1567 );
			
			$( '#cellphone-div' ).removeClass( 'has-success' );
			$( '#cellphone-div' ).addClass( 'has-error' );
			$( '#cellphoneerror' ).show();
			$( '#cellphoneok' ).hide();
			return false;
		}
		else
		{
			$( '#cellphone-div' ).addClass( 'has-success' );
			$( '#cellphone-div' ).removeClass( 'has-error' );
			$( '#cellerror' ).hide();
			$( '#cellphoneok' ).show();
		}
	}
	//邮箱
	var strEmail = $( '#email' ).val();
	if( '' == strEmail || strEmail.length < 1 )
	{
		$( '#tipDialog' ).html( '邮箱地址不能为空' );
		$('#litModal').modal({
		  keyboard:true,
		  show:true,
		  backdrop:false,
		});
		$("#litModal").modal().css({
	        "margin-top": function () {
	            return ($(this).height() / 10 );
	        },
	        "margin-left": function () {
	            return ($(this).width() / 4 );
	        },
	    });
		setTimeout( function(){
			$( '#litModal' ).modal( 'hide' );
		}, 1567 );
		$( '#email-div' ).addClass( 'has-error' );
		$( '#email-div' ).removeClass( 'has-success' );
		$( '#emailerror' ).show();
		$( '#emailok' ).hide();
		return false;
	}
	else
	{
		iSign = iSign?iSign:0;
		$.get( '/pri/Users/getAllEmail/' + iSign, function( ret ){
			if( 1 != ret.state )
			{
				var iLen = ret.data.length;
				for( i in ret.data )
				{
					if( $.trim(ret.data[i]) == $.trim( strEmail ) )
					{
						$( '#tipDialog' ).html( '该邮箱已被注册,请重新输入' );
						$('#litModal').modal({
						  keyboard:true,
						  show:true,
						  backdrop:false,
						});
						$("#litModal").modal().css({
					        "margin-top": function () {
					            return ($(this).height() / 10 );
					        },
					        "margin-left": function () {
					            return ($(this).width() / 4 );
					        },
					    });
						setTimeout( function(){
							$( '#litModal' ).modal( 'hide' );
						}, 1000 );
						
						$( '#email-div' ).removeClass( 'has-success' );
						$( '#email-div' ).addClass( 'has-error' );
						$( '#emailerror' ).show();
						$( '#emailok' ).hide();
						return false;
					}
				}
				
				$( '#email-div' ).addClass( 'has-success' );
				$( '#email-div' ).removeClass( 'has-error' );
				$( '#emailerror' ).hide();
				$( '#emailok' ).show();
			}
		}, 'json');
	}
	if( !regEmail.test( strEmail ) )
	{
		$( '#tipDialog' ).html( '邮箱地址输入不正确,请重新输入' );
		$('#litModal').modal({
		  keyboard:true,
		  show:true,
		  backdrop:false,
		});
		$("#litModal").modal().css({
	        "margin-top": function () {
	            return ($(this).height() / 10 );
	        },
	        "margin-left": function () {
	            return ($(this).width() / 4 );
	        },
	    });
		setTimeout( function(){
			$( '#litModal' ).modal( 'hide' );
		}, 1567 );
		$( '#email-div' ).addClass( 'has-error' );
		$( '#email-div' ).removeClass( 'has-success' );
		$( '#emailerror' ).show();
		$( '#emailok' ).hide();
		return false;
	}
	else
	{
		$( '#email-div' ).addClass( 'has-success' );
		$( '#email-div' ).removeClass( 'has-error' );
		$( '#emailerror' ).hide();
		$( '#emailok' ).show();
	}
	
	//
	return true;
}

//输入验证
function validate( value,type )
{
	switch( type )
	{
		case 'logname':
			if( '' == value || value.length < 1 )
			{
				$( '#name-div' ).removeClass( 'has-success' );
				$( '#name-div' ).addClass( 'has-error' );
				$( '#nameerror' ).show();
				$( '#nameok' ).hide();
			}
			else
			{
				
			}
		break;
		case 'passwd':
			if( '' != value && value.length > 0 )
			{
				$( '#passwd-div' ).addClass( 'has-success' );
				$( '#passwd-div' ).removeClass( 'has-error' );
				$( '#passwderror' ).hide();
				$( '#passwdok' ).show();
			}
			else
			{
				$( '#passwd-div' ).removeClass( 'has-success' );
				$( '#passwd-div' ).addClass( 'has-error' );
				$( '#passwderror' ).show();
				$( '#passwdok' ).hide();
			}
		break;
		case 'phone':
			if( '' != value && value.length > 0 )
			{
				$( '#phone-div' ).addClass( 'has-success' );
				$( '#phone-div' ).removeClass( 'has-error' );
				$( '#phoneerror' ).hide();
				$( '#phoneok' ).show();
			}
			else if( !pattern.test( phone ) )
			{
				$( '#tipDialog' ).html( '请输入正确的电话号码:电话号码格式为国家代码(2到3位)-区号(2到3位)-电话号码(7到8位)-分机号(3位)' );
				$('#litModal').modal({
				  keyboard:true,
				  show:true,
				  backdrop:false,
				});
				$("#litModal").modal().css({
			        "margin-top": function () {
			            return ($(this).height() / 10 );
			        },
			        "margin-left": function () {
			            return ($(this).width() / 4 );
			        },
			    });
				setTimeout( function(){
					$( '#litModal' ).modal( 'hide' );
				}, 1567 );
				
				$( '#phone-div' ).removeClass( 'has-success' );
				$( '#phone-div' ).addClass( 'has-error' );
				$( '#phoneerror' ).show();
				$( '#phoneok' ).hide();
			}
			else
			{
				$( '#phone-div' ).removeClass( 'has-success' );
				$( '#phone-div' ).addClass( 'has-error' );
				$( '#phoneerror' ).show();
				$( '#phoneok' ).hide();
			}
		break;
		case 'cellphone':
			if( '' != value && value.length > 0 )
			{
				$( '#cellphone-div' ).addClass( 'has-success' );
				$( '#cellphone-div' ).removeClass( 'has-error' );
				$( '#cellphoneerror' ).hide();
				$( '#cellphoneok' ).show();
			}
			else if( !cellReg.test( cellphone ) )
			{
				$( '#tipDialog' ).html( '请输入正确的手机号码' );
				$('#litModal').modal({
				  keyboard:true,
				  show:true,
				  backdrop:false,
				});
				$("#litModal").modal().css({
			        "margin-top": function () {
			            return ($(this).height() / 10 );
			        },
			        "margin-left": function () {
			            return ($(this).width() / 4 );
			        },
			    });
				setTimeout( function(){
					$( '#litModal' ).modal( 'hide' );
				}, 1567 );
				
				$( '#cellphone-div' ).removeClass( 'has-success' );
				$( '#cellphone-div' ).addClass( 'has-error' );
				$( '#cellphoneerror' ).show();
				$( '#cellphoneok' ).hide();
			}
			else
			{
				$( '#cellphone-div' ).removeClass( 'has-success' );
				$( '#cellphone-div' ).addClass( 'has-error' );
				$( '#cellphoneerror' ).show();
				$( '#cellphoneok' ).hide();
			}
		break;
		case 'email':
			if( '' != value && value.length > 0 )
			{
				$( '#email-div' ).addClass( 'has-success' );
				$( '#email-div' ).removeClass( 'has-error' );
				$( '#emailerror' ).hide();
				$( '#emailok' ).show();
			}
			else if( !regEmail.test( strEmail ) )
			{
				$( '#tipDialog' ).html( '邮箱地址输入不正确,请重新输入' );
				$('#litModal').modal({
				  keyboard:true,
				  show:true,
				  backdrop:false,
				});
				$("#litModal").modal().css({
			        "margin-top": function () {
			            return ($(this).height() / 10 );
			        },
			        "margin-left": function () {
			            return ($(this).width() / 4 );
			        },
			    });
				setTimeout( function(){
					$( '#litModal' ).modal( 'hide' );
				}, 1567 );
				$( '#email-div' ).addClass( 'has-error' );
				$( '#email-div' ).removeClass( 'has-success' );
				$( '#emailerror' ).show();
				$( '#emailok' ).hide();
			}
			else
			{
				$( '#email-div' ).removeClass( 'has-success' );
				$( '#email-div' ).addClass( 'has-error' );
				$( '#emailerror' ).show();
				$( '#emailok' ).hide();
			}
		break;
	}
}