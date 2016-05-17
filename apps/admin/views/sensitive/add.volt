<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <style>
            .articles-pic-operate {
                position:absolute;bottom: 0; width:100%; text-align: center;background:gainsboro; display:none;
            }
             .col-xs-2 {
                padding-right: 0;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation"><a href="/admin/sensitive/index">敏感词管理</a></li>
            <li role="presentation"class="active"><a href="#sensitiveAdd" >添加敏感词</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="sensitiveAdd" style="padding-top:20px;">
                <form class="form-horizontal" method="post" action="/admin/sensitive/save">
                     <div class="form-group has-feedback text-right" >
                        <label class="col-xs-1 control-label">敏感词</label>
                        <div class="col-xs-5">
                            <textarea class="form-control"  rows="10" cols="60" id="key" name="key" placeholder="一行一个敏感词" required></textarea>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-1 col-sm-10">
                           	<input type="submit" value="提交" name="submit" class="btn btn-info col-sm-6 col-xs-3" id="has_submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="alert alert-danger text-center col-xs-2" style="position:fixed; bottom:0; margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
     
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
        $( function(){
    		$( 'textarea' ).keydown( function(){
    			$( '#has_submit' ).removeAttr( 'disabled' );
    		} ).change( function(){
    			$( '#has_submit' ).removeAttr( 'disabled' );
    		} );
    	} );
    	$( '#has_submit' ).click( function(){
    		$( this ).attr( 'disabled', 'disabled' );
    	} );
        </script>
    </body>
</html>
