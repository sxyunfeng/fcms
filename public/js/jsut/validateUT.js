function checkNum(obj) 
{
	//检查是否是非数字值
	if (isNaN(obj.value)) 
	{
   	  	obj.value = "";
   	  	
   	  	return false;
	}
	if (obj != null) 
	{
	    //检查小数点后是否对于两位
	   	if (obj.value.toString().split(".").length > 1 && obj.value.toString().split(".")[1].length > 3) 
	   	{
	        	alert("小数点后多于三位！");
	        	obj.value = "";
	        	
	        	return false;
	   	}
	}
	
	return true;
}

function checkFloat(obj) 
{
	//检查是否是非数字值
	if (isNaN(obj.value)) 
	{
   	  	obj.value = "";
   	  	
   	  	return false;
	}
	if (obj != null) 
	{
	    //检查小数点后是否对于两位
	   	if (obj.value.toString().split(".").length > 1 && obj.value.toString().split(".")[1].length > 4) 
	   	{
	        	alert("小数点后多于四位！");
	        	obj.value = "";
	        	
	        	return false;
	   	}
	}
	
	return true;
}

function checkInt(obj) 
{
	//检查是否是非数字值
	if (isNaN(obj.value)) 
	{
   	obj.value = "";
   	
   	return;
	}
	
	if (obj != null) 
	{
    //检查小数点后是否对于两位
   	if (obj.value.toString().split(".").length > 1 && obj.value.toString().split(".")[1].length > 0) 
   	{
        	alert("不能是小数！");
        	obj.value = "";
        	
        	return;
    	}
    	
    	if( parseInt( obj.value, 10 ) < 0 )
    	{
		alert( "不能为负数！" );
		
		obj.value = "";	         	
    	}

	}
}


function checkYear( obj ) 
{
	//检查是否是非数字值
	if (isNaN(obj.value)) 
	{
		obj.value = "";
   	
		return;
	}
	
	if (obj != null) 
	{
		//检查小数点后是否对于两位
		if (obj.value.toString().split(".").length > 1 && obj.value.toString().split(".")[1].length > 0) 
		{
			alert("不能是小数！");
			obj.value = "";
			
			return;
		}
			
		var date = new Date();
		
		if( parseInt( obj.value, 10 ) < 1900 || parseInt( obj.value, 10 ) > date.getFullYear() )
		{
			alert( "年份有错，请检查输入！" );
			
			obj.value = "";	         	
		}

	}
}

function isTel(object)
{
	//国家代码(2到3位)-区号(2到3位)-电话号码(7到8位)-分机号(3位)"

	var s =document.getElementById(object.id).value; 
	var pattern =/(^[0-9]{3,4}\-[0-9]{3,8}$)|(^[0-9]{3,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^0{0}1[0-9]{10}$)/;
	//var pattern =/(^[0-9]{3,4}\-[0-9]{7,8}$)|(^[0-9]{7,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^0{0,1}13[0-9]{9}$)/; 
     if(s!="")
     {
         if(!pattern.exec(s))
         {
          alert('请输入正确的电话号码:电话号码格式为国家代码(2到3位)-区号(2到3位)-电话号码(7到8位)-分机号(3位)"');
          object.value="";
          object.focus();
         }
     }
}