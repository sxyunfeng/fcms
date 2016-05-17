function getAjaxPostData()
{
	var data_v = new Object();

	//搜集参数 [肯定就两种形式一种是input,一种是select]
	$("input").each(function(index, element) 
	{
		if ($(element).attr("name")) 
		{
			if( $(element).val() != null && String($(element).val()).Trim() != "" )
			{
				data_v[$(element).attr("name")] = $(element).val();//设置值
			}
		}
	});
	
	$("select").each(function(index, element) 
	{

		if ($(element).attr("name")) 
		{
			if( $(element).val() != null && String($(element).val()).Trim() != "" )
			{
				data_v[$(element).attr("name")] = $(element).val();//设置值
			}
		}
	});
	
	$("textarea").each(function(index, element) 
	{

		if ($(element).attr("name")) 
		{
			if( $(element).val() != null && String($(element).val()).Trim() != "" )
			{
				data_v[$(element).attr("name")] = $(element).val();//设置值
			}
		}
	});
	
	return data_v;
}