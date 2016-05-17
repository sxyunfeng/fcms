<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet"  href="/css/admin/font-awesome.min.css" >
        <link rel="stylesheet" href="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.css">
        <style>
            .operate {
                margin-right: 10px;
            }
            .operate:hover {
                cursor:pointer;
                color:green;
            }
		.skinimg i:hover{-webkit-animation: tada 1s .2s ease both;-moz-animation: tada 1s .2s ease both;}
		@-webkit-keyframes tada{
			0%{-webkit-transform:scale(1);}
			10%, 
			20%{-webkit-transform:scale(0.9) rotate(-3deg);}
			30%, 50%, 70%, 
			90%{-webkit-transform:scale(1.1) rotate(3deg);}
			40%, 60%, 
			80%{-webkit-transform:scale(1.1) rotate(-3deg);}
			100%{-webkit-transform:scale(1) rotate(0);}
		}
		@-moz-keyframes tada{
			0%{-moz-transform:scale(1);}
			10%, 
			20%{-moz-transform:scale(0.9) rotate(-3deg);}
			30%, 50%, 70%, 
			90%{-moz-transform:scale(1.1) rotate(3deg);}
			40%, 60%, 
			80%{-moz-transform:scale(1.1) rotate(-3deg);}
			100%{-moz-transform:scale(1) rotate(0);}
		}
		span.info{
				font-size: 14px;
				color:#95a5a6;
		}
		.dropdown-submenu {
            position: relative;
        }
        .dropdown-submenu > .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
            -webkit-border-radius: 0 6px 6px 6px;
            -moz-border-radius: 0 6px 6px;
            border-radius: 0 6px 6px 6px;
        }
        .dropdown-submenu:hover > .dropdown-menu {
            display: block;
        }
        .dropdown-submenu > a:after {
            display: block;
            content: " ";
            float: right;
            width: 0;
            height: 0;
            border-color: transparent;
            border-style: solid;
            border-width: 5px 0 5px 5px;
            border-left-color: #ccc;
            margin-top: 5px;
            margin-right: -10px;
        }
        .dropdown-submenu:hover > a:after {
            border-left-color: #fff;
        }
        .dropdown-submenu.pull-left {
            float: none;
        }
        .dropdown-submenu.pull-left > .dropdown-menu {
            left: -100%;
            margin-left: 10px;
            -webkit-border-radius: 6px 0 6px 6px;
            -moz-border-radius: 6px 0 6px 6px;
            border-radius: 6px 0 6px 6px;
        }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#articlesList">已删文章</a></li>
        </ul>
        
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="userList">
                {% if page.items is defined and page.items is not empty %}
                <table class="table table-hover table-bordered">
                    <thead>
                    	<tr>
                    		<th colspan="6"></th>
                    		<th style="text-align:center;font-size:16px;width:100px;">
	                    		<span class="glyphicon glyphicon-share-alt" title="恢复本页中已选中文章" style="cursor:pointer;margin-right:10px;" id="recover_select"></span>
	                    		<span class="glyphicon glyphicon-repeat" title="恢复所有文章" style="cursor:pointer;" id="recover_all"></span>
	                    	</th>
                    	</tr>
                        <tr>
                        	<th>序号</th>
                        	<th>文章编号</th>
                            <th>文章标题</th>
                            <th>文章分类</th>
                            <th>发布日期</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody id="self_content">
                        {% for i,item in page.items %}
                        <tr id="article{{item.id}}">
                        	<td><input class="self_checkbox" type="checkbox" checkbox-id="{{ item.id | escape_attr }}"></td>
                        	<td>{{ item.id | e }}</td>
                            <td>{{ item.title | e }}</td>
                            <td>{{ item.artcate.name | e }}</td>
                            <td>{% if false == item.uptime %} / {% else %}{{ item.uptime | e }} {% endif %}</td>
                            <td>{{ item.uptime | e }}</td>
                            <td data-id="{{ item.id | escape_attr }}" class="skinimg" style="padding-left:2%;font-size:16px;" >
                                <i class="glyphicon glyphicon-file operate recover_one" title="恢复"></i>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                {% else %}
                <div style="height:150px;line-height:150px;text-align:center;">无已删除文章，请刷新重试！</div>
                {% endif %}
                
                <!-- 分页 -->
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="/admin/articletrash/index/page/{{page.before}}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="/admin/articletrash/index">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="/admin/articletrash/index/page/{{ page.before }}"><span >{{ page.before }}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="/admin/articletrash/index/page/{{ page.current }}"><span>{{ page.current }}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="/admin/articletrash/index/page/{{ page.next }}">{{ page.next }}</a></li>
                        {% endif %}
                        {% if page.next  < page.last - 1 %}
                        <li><a>...</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="/admin/articletrash/index/page/{{ page.last }}">{{ page.last }}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="/admin/articletrash/index/page/{{page.next}}" >&raquo;</a></li>

                    </ul>
                </nav>
                {% endif %}
            </div>
        </div>
        <div class="alert alert-danger text-center col-xs-2" style="display:none;margin-left: 40%;">
            <span>删除失败</span>
        </div>
        
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" style="margin-top:20%">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
	 			<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        				<span aria-hidden="true">&times;</span>
        			</button>
        		</div>
		      <div class="modal-body">
		       <div class="progress">
				  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
				    <span class="sr-only">40% Complete (success)</span>
				  </div>
				</div>
		      </div>
		    </div>
		  </div>
		</div>
		
		<div style="left: 30%;margin-left: -15px;margin-top: -15px;position: absolute;top: 50%; display:none;" class="text-center col-xs-4">
          	<div class="alert alert-dismissable ">
              <h4><i class="glyphicon glyphicon-info-sign"></i> 提示信息!</h4>
              <p id="dis_message"></p>
            </div>
    	</div>
		
<script src="/js/jquery/jquery-1.11.1.min.js"></script>
<script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="/js/admin/static/optStatic.js"></script>
<script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.js"></script>
		<script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script>
var page = <?php if( isset( $page ) && !empty( $page ) ) echo $page->current; else echo 0; ?>;

var csrfName = "<?php echo $this->security->getTokenKey();?>";
var csrfValue = "<?php echo $this->security->getToken();?>";

$( function(){
	
	/*----------------单篇文章恢复-----------------*/
	$( 'table' ).delegate( '.recover_one', 'click', function(){
		var isRec = confirm( '是否恢复该文章' );
		if( isRec )
		{
			var id = $( this ).parent( 'td' ).attr( 'data-id' );
			var _this = this;
            var data = '&ids=' + id + '&' + csrfName + '=' + csrfValue;
            $.post( '/admin/articleTrash/recoverSelect', data, function( ret ){
                if( !ret.status )
                {
                    $( _this ).parents( 'tr' ).remove();
                }
                else
				{
					error( ret.msg );
                }
                csrfName = ret.csrfname;
                csrfValue = ret.csrfval;
            }, 'json').error( function(){ //网络不通
                error( '网络不通' );
			});
		}
		
	} );
	
	/*----------------选中文章恢复-----------------*/
	$( '#recover_select' ).click( function(){
		var areRec = confirm( '是否恢复所选文章' );
		if( areRec )
		{
			var params = '&' + csrfName + '=' + csrfValue;
			var ids = [];
			$( "input.self_checkbox" ).each( function( index ){
        		if( $( this ).prop( 'checked' ) == true )
        		{
        			ids[ index ]= $( this ).attr( 'checkbox-id' );
        		}
        	} );
			params += '&ids=' + ids;
			$.post( '/admin/articleTrash/recoverSelect', params, function( ret ){
                if( !ret.status )
                {
                    var iLens = ret.optids.length;
                    if( iLens > 0 )
                   	{
                   		for( var i=0; i<iLens; i++ )
              			{
                   			$( '#article' + ret.optids[i] ).remove();
              			}
                   	}
                }
                csrfName = ret.csrfname;
                csrfValue = ret.csrfval;
            }, 'json').error( function(){ //网络不通
                error( '网络不通' );
			});
		}
	} );
	
	/*----------------所有文章恢复-----------------*/
	$( '#recover_all' ).click( function(){
		var areRec = confirm( '是否恢复所有文章' );
		if( areRec )
		{
			var params = '&type=all&' + csrfName + '=' + csrfValue;
			$.post( '/admin/articleTrash/recoverSelect', params, function( ret ){
                if( !ret.status )
                {
                    var iLens = ret.optids.length;
                    if( iLens > 0 )
                   	{
                   		for( var i=0; i<iLens; i++ )
              			{
                   			$( '#article' + ret.optids[i] ).remove();
              			}
                   	}
                }
                csrfName = ret.csrfname;
                csrfValue = ret.csrfval;
            }, 'json').error( function(){ //网络不通
                error( '网络不通' );
			});
		}
	} );
	
	
	
   	/*----------------搜索框内容填充---------------*/
   	$( 'ul.multi-level' ).find( 'a' ).each( function(){
	  	$( this ).click( function(){
			var cat_id = $( this ).parent( 'li' ).attr( 'data-id' );
			var cat_name = $( this ).html();
		  	$( '#s_catid' ).val( cat_id );
		  	$( '#cat_name' ).html( cat_name );
	  	} );
  	 } );
   
   	/*----------------时间插件-----------------*/
  	 $( '#s_pubtime' ).datetimepicker( {
		language: 'zh-CN',
	    autoclose: true,
	    todayBtn: true,
	    pickerPosition: "bottom-right",
	    minView:'month',
	 	startView:3,
	    format: 'yyyy-mm-dd',
	   	fontAwesome:true,
	} );
   	
} );

/*----------------输出错误信息-----------------*/
function error( msg )
{
   $( '.alert span' ).text( msg );
   $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
   $( '.alert' ).show().fadeOut( 3000 );
}

</script>
</body>
</html>