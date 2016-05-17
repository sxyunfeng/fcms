<!doctype html>
<html>
    <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
    <style>
        body{
        	background-color:rgba(238,238,238,1);
        }
		@font-face{
			font-family: 'FZZDHJW Regular';
			src: url('/public/css/fonts/FZZDHJW.eot');
			src: local('FZZDHJW Regular'),
			local('FZZDHJW'),
			url('/public/css/fonts/FZZDHJW.woff') format('woff'),
			url('/public/css/fonts/FZZDHJW.TTF') format('truetype'),
			url('/public/css/fonts/FZZDHJW.svg#FZZDHJW') format('svg');
		}
		.self_content{
			text-align:center;
			margin-top:100px;
		}
		.self_content span{
			font-family:'FZZDHJW';
		}
		
    </style>
    <body>
        <!-- <div class="row text-center">
            <div class="col-xs-offset-4 col-xs-4 ">
                 <div class="panel panel-danger">
                     <div class="panel-heading">
                         <i class="glyphicon  glyphicon-warning-sign"></i>
                         <span>404</span>
                         <div class="msg">
                             {%if data[ 'msg' ] is not empty %}
                             {{ data[ 'msg' ] }}
                             {% else %}
                             对不起，你找的页面不在！
                             {% endif %}
                         </div>
                     </div>
                     <div class="panel-footer text-center">
                            <i class="time">5</i> <span>秒后</span>
                            {% if data[ 'referer' ] is not empty %}
                            <a class='btn btn-sm btn-default' id="url" href="{{ data[ 'referer']}}"> 返回上一页</a>
                            {% else %}
                            <a class='btn btn-sm btn-default' id="url" href="/admin/index/show"> 返回首页</a>
                            {% endif %}
                     </div>
                    </div>
            </div>
        </div> -->
        
        <div class="self_main">
        	<div class="self_content">
        		<div>
        			<span style="font-size:100px;color:#be2828;">404</span>
        			<span style="font-size:20px;color:#333;margin-left:20px;">茫茫人海，你迷路了！</span>
        		</div>
        		<div style="margin-top:-30px;">
        			<span style="font-size:77px;color:#333;">Not Found</span>
        		</div>
        		<div style="font-style:italic;">
        			不要担心，让我为你指引回家的路！
        		</div>
        		<div>
					<i class="time">5</i> <span>秒后</span>
					<a href="/admin/index/show" id='url'> 返回首页</a>
				</div>
				<div style="display:none;">
                     {%if data[ 'msg' ] is not empty %}
                     {{ data[ 'msg' ] }}
                     {% endif %}
				</div>
			</div>
        </div>
        
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script> 
            decTime();
            function decTime()
            {
                var t = Number( $( '.time' ).text() );
                if( t > 0 )
                {
                    $( '.time' ).text( t - 1 );
                    setTimeout( 'decTime()', 1000 );
                }
                else
				{
                    var url = $( '#url' ).attr( 'href' );
                    var pos = url.lastIndexOf( '/' );
                    var action = url.substr( pos + 1 );
                    //控制器
					var u = url.substring( 0, pos  );
                    var cpos = u.lastIndexOf( '/' );
                    var controller = u.substr( cpos + 1 );
                    
                    if( action === 'index' && controller === 'index') //如果是首页，就用修改
                    {
                        url = url.substr(0, pos ) + '/show';
                    }
                    location = url;
                }
            }
        </script>
    </body>
</html>