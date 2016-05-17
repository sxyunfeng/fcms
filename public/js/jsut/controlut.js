function onBtnReturn()
{
	window.history.go( -1 );
}

function onBtnClose()
{
	window.close();	
}

function deleteConfirm( path )
{
	art.dialog.confirm('你确定要删除吗？',
	function () 
	{
		window.location.href = path;
		return true;
	}, 
	function () 
	{
	    
	});
}


function checkInput( objSel, objId )
{
	var selValue = document.getElementById( objId ).value;

	if( selValue != "其它" )
	{
		objSel.value = "";
		objSel.readOnly = true;
	}
	else
	{
		objSel.readOnly = false;
	}

}

function onSelChange( objSel, objId )
{
	var selValue = objSel.value;

	var other = document.getElementById( objId );
	
	if( selValue != "其它" )
	{
		other.value = "";
		other.readOnly = true;
	}
	else
	{
		other.readOnly = false;
	}
}




	//查看从业人员
function employeesDetail(employeesID,path)
{	
  art.dialog.open( path + '/manual/employeesDetail.do?employeesID='+employeesID,
  {	
      lock: true,
      background: '#F2F2F2', // 背景色
      opacity: 0.4,    // 透明度
      width: '1000px',
      height: '400px',
      drag: true,
      title:'查看从业人员',
      resize:true,
      fixed:true
  });
}


