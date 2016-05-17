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



// 判断数据类型
var is = {
    types: ["Array", "Boolean", "Date", "Number", "Object", "RegExp",
			"String", "Window", "HTMLDocument"]
};
for (var i = 0, c; c = is.types[i++]; ) {
    is[c] = (function (type) {
        return function (obj) {
            return Object.prototype.toString.call(obj) == "[object " + type
					+ "]";
        }
    })(c);
}



/**
* 
* 因为base64的编码中含有 / 在url中传递会被当成路径符号，这里替换成[x]
* 
*/
function replaceX(base64) {
    var regS = new RegExp("/", "gi");
    var s = base64.replace(regS, "[x]"); // 全部替换
    return s;
}

// 把srcStr中的targetStr替换成replaceStr
function replace(srcStr, targetStr, replaceStr) {
    var regS = new RegExp(targetStr, "gi");
    var s = srcStr.replace(regS, replaceStr); // 全部替换
    return s;
}

// 毫秒数 转换成 日期格式
function changeDateFormat(cellval) {
    var date = new Date(parseInt(cellval));
    var month = date.getMonth() + 1 < 10 ? "0" + (date.getMonth() + 1) : date
			.getMonth()
			+ 1;
    var currentDate = date.getDate() < 10 ? "0" + date.getDate() : date
			.getDate();
    // var hour=date.getHours()< 10 ? "0" + date.getHours() : date.getHours();
    // var mints=date.getMinutes()< 10 ? "0" + date.getMinutes() :
    // date.getMinutes();
    // var sec=date.getSeconds()< 10 ? "0" + date.getSeconds()
    // :date.getSeconds();
    return date.getFullYear() + "-" + month + "-" + currentDate;
}

/**
 * 截取字符串，如果超过长度加省略号
 * @param {} str
 * @param {} len
 * @return {String}
 */
function subStr(str, len) {
            if (!str || !len) { return ''; }
            //预期计数：中文2字节，英文1字节
            var a = 0;
            //循环计数
            var i = 0;
            //临时字串
            var temp = '';
            for (i = 0; i < str.length; i++) {
                if (str.charCodeAt(i) > 255) {
                    //按照预期计数增加2
                    a += 2;
                }
                else {
                    a++;
                }
                //如果增加计数后长度大于限定长度，就直接返回临时字符串
                if (a > len) { return temp+"……"; }
                //将当前内容加到临时字符串
                temp += str.charAt(i);
            }
            //如果全部是单字节字符，就直接返回源字符串
            return str;
        }

// 删除文件
function delFile(fileid, fieldName, fileName, sysPath) {
    $.ajax({
        type: "POST",
        async: false,
        url: sysPath + "/upload/delFile.do",
        data: {
            requestId: fileid,
            fieldName: fieldName,
            fileName: fileName
        },
        success: function (data) {
            // data 有三个字段， fieldName,fileName,requestId

            // var t=$("a:contains('"+
            // decodeURI(fileName)+"')").attr("href");
            // 4b0e3db48be2410fb71af4c350479aac/practicingCertificate/Empty.doc
            var str = data.requestId + "/" + data.fieldName + "/"
							+ replaceX(base.encode(fileName)) + ".do";
            // var s=$("a[href$='"+str+"']").attr("href");
            $("div[id^='fileList']>div>a[href$='" + str + "']")
							.parent().remove();
        }
    });
}

function goURL(url) {
    location = url;
}

// 取得当前时间，表单没有变化的时候，提交到springmvc会提示404
function getTime() {
    var myDate = new Date();
    myDate.getYear(); // 获取当前年份(2位)
    myDate.getFullYear(); // 获取完整的年份(4位,1970-????)
    myDate.getMonth(); // 获取当前月份(0-11,0代表1月)
    myDate.getDate(); // 获取当前日(1-31)
    myDate.getDay(); // 获取当前星期X(0-6,0代表星期天)
    myDate.getTime(); // 获取当前时间(从1970.1.1开始的毫秒数)
    myDate.getHours(); // 获取当前小时数(0-23)
    myDate.getMinutes(); // 获取当前分钟数(0-59)
    myDate.getSeconds(); // 获取当前秒数(0-59)
    myDate.getMilliseconds(); // 获取当前毫秒数(0-999)
    // myDate.toLocaleDateString(); //获取当前日期
    // var mytime=myDate.toLocaleTimeString(); //获取当前时间
    // myDate.toLocaleString( ); //获取日期与时间
    // if (mytime<"23:30:00"){
    // alert(mytime);
    // }
    myDate = myDate.toLocaleDateString() + " " + myDate.toLocaleTimeString()
			+ "." + myDate.getMilliseconds();
    // alert(myDate);
    return myDate;

}

//检查是否已经全部选中
function checkAllSelected(win) {
    var flag = true;
    $(win).find("input").each(function (index, element) {
        // checkbox ck1=true 或者 ck1=true,false
        if ($(element).attr("name") && $(element).attr("type") == "checkbox") {

            //有一个没有选中
            if (!$(element).attr("checked") && $(element).attr("name") != 'ckb_all') {
                flag = false;
                //发现一个没有选中直接跳出就循环
                return false;
            }
            else {
                flag = true;
            }
        }
    });
    return flag;
}

/**
* 检查是否至少有一个没有选中	
*/
function checkLastoneNotSelected(win) {
    var flag = false;
    $(win).find("input").each(function (index, element) {
        // checkbox ck1=true 或者 ck1=true,false
        if ($(element).attr("name") && $(element).attr("type") == "checkbox") {

            //有一个没有选中
            if (!$(element).attr("checked") && $(element).attr("name") != 'ckb_all') {
                flag = true; //已经检查到有一个没有选中
                //发现一个没有选中直接跳出就循环
                return false;
            }

        }
    });
    return flag;
}
 

function setTimeInHidden() {
    var myDate = getTime();
    document.getElementById('hiddentime').value = myDate;
    return myDate;
}

function winreload(win) {
    win.location.reload();
}
// 判断是否为有效的手机号码
function checktelephone(obj) {
    var cellPhone = document.getElementById(obj.id).value;
    if (cellPhone.search(/^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/) != -1) {
        redflag = 0;
        return true;
    } else {
        alert("手机格式错误");
        redflag = 1;
        return false;
    }
}
 

// 判断是否为有效的身份证号
function isIdCardNo(obj) {
    var num = $(obj).val();
    if (isNaN(num)) 
   	{
       // alert("输入的不是数字");
    	return false;
    }
    var len = num.length, re;
    if (len == 15)
        re = new RegExp(/^(\d{6})()?(\d{2})(\d{2})(\d{2})(\d{3})$/);
    else if (len == 18)
        re = new RegExp(/^(\d{6})()?(\d{4})(\d{2})(\d{2})(\d{3})(\d)$/);
    else {
        //alert("输入的数字位数不对");
        return false;
    }
    return true;
}

// 匹配中国邮政编码(6位)
function isPostCode(obj) {
    var str = document.getElementById(obj.id).value;
    var reg = str.match(/[1-9]\d{5}(?!\d)/);
    if (reg == null) {
        alert("邮政编码不符合");
        return false;
    }
}
// 验证只能为中文
function isCN(obj) {
    var str = document.getElementById(obj.id).value;
    var reg = new RegExp("^[\u4e00-\u9fa5],{0,}$");
    if (!str.test(reg)) {
        alert("只能输入中文");
        return false;
    }
}
// 验证只能为英文和数字
function isENOrNum(obj) {
    var str = document.getElementById(obj.id).value;
    var reg = new RegExp("^[A-Za-z0-9]+$");
    if (!reg.test(str)) {
        alert("只能输入英文和数字");
        return false;
    }
}

// 判断固定电话
function checktel(obj) {
    var tel = document.getElementById(obj.id).value;

    var pattern = /(^[0-9]{3,4}\-[0-9]{3,8}$)|(^[0-9]{3,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^0{0,1}13[0-9]{9}$)/;
    if (pattern.test(tel)) {
        return true;
    } else {
        alert("电话号码格式不正确");
        return false;
    }
}

// 只能输入正整数
function checkNum(obj) {
    var reg1 = /^\d+$/;
    var num = document.getElementById(obj.id).value;
    if (num.match(reg1) == null) {
        alert("只能输入正整数");
        return false;
    }
}

// 只能输入正浮点数
function checkDouble(obj) {
    var reg = /^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*))$/;
    var num = document.getElementById(obj.id).value;
    if (num.match(reg) == null) {
        alert("只能输入正数");
        return false;
    }
}

 

function getFront(obj, position) {
    if (obj == null) {
        return obj;
    }

    var temp = obj.toString();
    if (temp.length <= position) {
        return temp;
    } else {
        return temp.substring(0, position) + "...";
    }
}
	

function toLocaltime(times)
{
	var date = new Date(times);
 	var  dateStr=date.toLocaleString();
    //alert(dateStr);	
	return dateStr;
}
