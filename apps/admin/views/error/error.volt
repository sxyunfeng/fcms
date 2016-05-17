<!doctype html>
<html>
    <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap/jqueryConfirm/2.5.0/jquery-confirm.css">
    <link>
    <style>
        body {
             font-family: "Arial","微软雅黑",sans-serif;
        }
        .glyphicon { 
            top: 2px;
        }
        
    </style>
    <body class="wrap">
        <div class="hidden" id="msg">
            <i class="glyphicon glyphicon-exclamation-sign text-danger"></i> 
            <span class="text-danger" style="margin-left:0.5em;">
            {% if data[ 'msg' ] is not empty %}{{ data[ 'msg' ] | e }}{% endif %}
            </span>
        </div>
    <script src="/js/jquery/jquery-1.11.1.min.js"></script>
    <script src="/bootstrap/jqueryConfirm/2.5.0/jquery-confirm.js"></script>
    <script>
        var msg = $( '#msg' ).html();
        $.dialog( { title : msg, onOpen :  function(){ 
            $( 'span.title' ).addClass( 'text-center' ).css( 'width', '100%');
            setTimeout( 'location = document.referrer', 2000 );
        } } );
    </script>
    </body>
</html>