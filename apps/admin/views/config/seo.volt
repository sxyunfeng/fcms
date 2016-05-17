<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel='stylesheet' href='/public/bootstrap/3.3.0/css/bootstrap.min.css'>
        <style>
            .input-group[ class*='col-']{
                /*margin-top:10px;*/
                margin-left:5px;
                float:left;
            }
            button {
                width:70px;
            }
        </style>
    </head>
    <body class="wrap">
        <form class="form-horizontal"  id="">
            {% if seo is defined %}
            {% for item in seo %}
            <div class="form-group">
                <label class="col-xs-2 control-label">{{ item[ 'title'] | e }}</label>
                <div class="col-xs-10">
                    <div class="col-xs-2 input-group">
                        <div class="input-group-addon"> k </div> 
                        <input class="form-control" type="text" name="key[]" value="{{ item[ 'key'] | escape_attr }}">
                    </div>
                    <div class="col-xs-6 input-group" style="">
                        <div class="input-group-addon"> v </div> 
                        <input class="form-control" type="text" name="value[]" value="{{ item[ 'value'] | escape_attr }}">
                    </div>
                </div>
            </div>
            {% endfor %}
            {% endif %}
        </form>
        <div class="col-xs-offset-2 col-xs-6 text-center">
            <button class="btn btn-sm btn-success" id="save">保存</button>
        </div>

        <div class="alert alert-danger text-center col-xs-2" style="margin-left:50%;display:none;">
             <i class="glyphicon glyphicon-ok pull-left"></i>
            <span>网络错误</span>
        </div>
        <script src="/public/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
    $( function(){
    	
    	/*------------修改数据时取消保存按钮的禁用-----------*/
		$( 'input' ).change( function(){
        	if( $( this ).attr( 'disabled' ) != "undefined" )
        	{
        		$( "#save" ).removeAttr( 'disabled' );
        	}
        } ).keydown( function(){
        	if( $( this ).attr( 'disabled' ) != "undefined" )
        	{
        		$( "#save" ).removeAttr( 'disabled' );
        	}
        } );
    	
		/*------------保存数据-----------*/
		$( '#save' ).click( function(){
			var data = $( 'form' ).serialize();
			$( "#save" ).attr( 'disabled', 'disabled' );
            $.post( '/admin/config/seosave', data, function( ret ){
                if( ! ret.status )
                {
                    successMsg( ret.msg );
                }
                else
				{
                    errorMsg( ret.msg );
                    $( "#save" ).removeAttr( 'disabled' );
                }
            }, 'json' ).error( function(){
             errorMsg( '网络不通' );
             $( "#save" ).removeAttr( 'disabled' );
          });

       });
    });
    function  errorMsg( msg )
    {
       $( '.alert span' ).text( msg );
       $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
       $( '.alert i' ).removeClass( 'glyphicon-ok' ).addClass( 'glyphicon-warning-sign' );
       $( '.alert' ).show().fadeOut( 3000 );
    }
    function  successMsg( msg )
    {
        $( '.alert span' ).text( msg );
        $( '.alert' ).removeClass( 'alert-danger' ).addClass( 'alert-success' );
        $( '.alert i' ).addClass( 'glyphicon-ok' ).removeClass( 'glyphicon-warning-sign' );
        $( '.alert' ).show().fadeOut( 3000 );
    }
</script>
    </body>
</html>