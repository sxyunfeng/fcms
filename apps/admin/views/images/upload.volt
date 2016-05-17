<! doctype html >
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap/fileinput/css/fileinput.min.css" >
    </head>
    <body class="wrap">
        <div class="col-xs-12 images" style="height:300px;">
             <input type="file"  id="imageUpload" multiple class=" file">
        </div>
        <div class="col-xs-12 text-center" style="margin:80px 0 50px;">
            <a href="/admin/images/index/pid/{{ id }}" class="btn btn-sm btn-success" style="margin-right:30px;width:70px;">确定</a>
            <a href="/admin/images/index/pid/{{ id }}" class="btn btn-sm btn-default" style="width:70px;">取消</a>
        </div>  
        
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/fileinput/js/fileinput.min.js"></script>
        <script src="/bootstrap/fileinput/js/fileinput_locale_zh.js"></script>
        <script>
             $("#imageUpload").fileinput({
                    showCaption: false,
                    showPreview: true,
                    allowedFileExtensions : ['jpg', 'png','gif'],
                    browseClass: "btn btn-primary btn-sm",
                    uploadClass: "btn btn-default btn-sm",
                    removeClass: "btn btn-default btn-sm",
                    uploadUrl: "/admin/images/saveImage",
                    language: "zh",
                    maxFileCount: 10,
                    overwriteInitial: true,
                    uploadAsync: true,
                    uploadExtraData: {
                        pid: "{{ id }}"
                    }
                });
                
             var cnt = 0
            $("#imageUpload").on('fileloaded', function(event, file, previewId, index) {
                ++cnt;
                if( cnt > 5 )
                {
                    $( '.images' ).css( 'height', '550' );
                }
                else if( cnt > 10 )
                {
                     $( '.images' ).css( 'height', '750' );
                }
            });
        </script>
    </body>
</html>