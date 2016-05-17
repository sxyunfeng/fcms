//@author fzq
//@date   2012//11/30

//当前页不可点击
//顶而时上一页不可点击
//尾页时下一页不可点击
//（以节省运算资源）
function initList( pageNo, pageCount, searchFun )
{
	var iPagerCount = 15;//页面上最多能放在的页标签数量
	var iSavePageCount = 0;
	
	var aLink = "<div id='pagerDiv' class='pagination'>";
	
	if( pageNo <= 0 || pageNo > pageCount )
		pageNo = 1;
	
	if( pageCount == 0 )
	{
		return;
	}
	else if( pageCount >= 1 )
	{
		
		
		if( pageNo == 1 )
		{//current prev
			aLink += "<a onclick='false' class='current prev'>第一页</a>";
			aLink += "<a onclick='false' class='current prev'>上一页</a>";
		}
		else if( pageNo > 1 )
		{
			aLink += "<a class='next' href='javascript:" + searchFun + "(" + ( 1 ) + ");'>第一页</a>";
			aLink += "<a class='next' href='javascript:" + searchFun + "(" + ( pageNo - 1 ) + ");'>上一页</a>";
			
		}
		//else
		//{
		//	  aLink += "<a class='next' href='javascript:" + searchFun + "(" + ( 1 ) + ");'>第一页</a>";
		//	  aLink += "<a class='next' href='javascript:" + searchFun + "(" + pageNo + ");'>上一页</a>";
		//}
		
		if( pageNo < iPagerCount )// && pageCount <= iPagerCount
		{
			iSavePageCount = pageCount;
			
			if( pageCount > iPagerCount )
			{
				pageCount = iPagerCount;
			}
			
		    for( var i = 1; i <= pageCount; i++ )
		    {
		    	if( i != pageNo )
		    	{
		    		aLink += "<a class='ep' href='javascript:" + searchFun + "(" + i + ");'>" + i + "</a>";
		    	}
		    	else
		    	{//当前页
		    		//aLink += "<a class='current' onclick='false' href='javascript:" + searchFun + "(" + i + ");'>" + i + "</a>";
		    		
		    		aLink += "<a class='current' onclick='false' >" + i + "</a>";
		    	}
		    }
		    
		    pageCount = iSavePageCount;
		    
		}
		else
		{
			var iBase = 1;
			
			if( pageNo != iPagerCount )
			{
				iBase = iPagerCount * ( parseInt( pageNo / iPagerCount )) + 1;
				
				if( iBase > pageNo )
				{
					iBase -= iPagerCount;
				}

			}
			
			var iTop = iBase + iPagerCount - 1;
			
			if( iTop >= pageCount )
			{
				iTop = pageCount;
			}
			
		    for( var i = iBase; i <= iTop; i++ )
		    {
		    	if( i != pageNo )
		    	{
		    		aLink += "<a class='ep' href='javascript:" + searchFun + "(" + i + ");'>" + i + "</a>";
		    	}
		    	else
		    	{//当前页
		    		//aLink += "<a class='current' onclick='false' href='javascript:" + searchFun + "(" + i + ");'>" + i + "</a>";
		    		
		    		aLink += "<a class='current' onclick='false' >" + i + "</a>";
		    	}
		    }

		}
		
	    if( pageNo == pageCount )
	    {
	    	aLink += "<a onclick='false' class='current prev' >下一页</a>";
	    	aLink += "<a onclick='false' class='current prev' >最后一页</a>";
	    }
	    else if( pageNo < pageCount )
	    {
	    	aLink += "<a  class='next' href='javascript:" + searchFun + "(" + ( pageNo - 1 + 2 ) + ");'>下一页</a>";
	    	aLink += "<a class='next' href='javascript:" + searchFun + "(" + ( pageCount ) + ");'>最后一页</a>";
	    }
	    //else
	    //{
	    //	aLink += "<a  class='next' href='javascript:" + searchFun + "(" + pageNo + ");'>下一页</a>";
	    //	aLink += "<a class='next' href='javascript:" + searchFun + "(" + ( pageCount ) + ");'>最后一页</a>";
	    //}
	    
	    
		
	}

	document.getElementById( "pagerDiv" ).outerHTML = aLink + "</div>";
}

