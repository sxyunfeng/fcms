function  setMsg(str_type,str_Name,str_errMsg)
{
	// div[class='msgbox']->span[class='errmsg'] 设置内容为str_errMsg，然后这个对象三秒钟内消失。
	var msgspan=$("span[class='errmsg']");
	$(msgspan).text(str_errMsg);
	
	var msgbox=$("div[class='msgbox']");
	//$(msgbox).css("visibility","visible");
	$(msgbox).slideDown("slow");
	setTimeout(callLater(showmsg, msgbox),3000);
	
	//高亮文本框
	setheighLight(str_type,str_Name)
	setTimeout(callLaterSetheighLight(removeheighLight,str_type,str_Name),3000);
	$(""+str_type+"[name='"+str_Name+"']").focus();
	
}

function callLaterSetheighLight(fRef,arg1,arg2)
{
    return (function() {
		fRef(arg1,arg2);
	});	
}

function setheighLight(arg1,arg2)
{
	$(""+arg1+"[name='"+arg2+"']").addClass("errHighlight");
}
function removeheighLight(arg1,arg2)
{
	$(""+arg1+"[name='"+arg2+"']").removeClass("errHighlight");
}


function callLater(fRef, argu1)
{
	return (function() {
		fRef(argu1);
	});
}; 

function  showmsg(msgbox)
{
	$(msgbox).slideUp("slow");
	//$(msgbox).css("visibility","hidden");
}

