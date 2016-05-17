<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/admin/font-awesome.min.css" >
        <style>
            .goods-pic {
                position:relative;margin:0 20px 20px 0;width:100px;height:100px;
                border:none;display:inline-block; vertical-align: middle;text-align: center;color:gray;cursor:pointer;
            }
            .goods-pic-add {
                border:1px dashed gray;
            }
            .goods-img:nth-child(2) .glyphicon-arrow-left {
                display:none;
            }
            .goods-img:last-child .glyphicon-arrow-right {
                display:none;
            }
            .goods-pic img {
               width:100px;height:100px;
            }
            .goods-pic-operate {
                position:absolute;bottom: 0; width:100%; text-align: center;background:gainsboro; display:none;
            }
            .goods-address div.col-xs-2 {
                padding-right:0;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation"><a href="/admin/goods/index">商品</a></li>
            <li role="presentation"class="active"><a href="#goodsAdd" >添加商品</a></li>
            <li role="presentation"><a href="#goodsArticle"  >添加商品文章</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="goodsAdd" style="padding-top:20px; margin-bottom: 30px; ">
                <form class="form-horizontal">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">商品分类</label>
                        <div class="col-xs-2">
                            <select class="form-control" id="categoryId" name="categoryId" value="">
                               {% if categorys is not empty %}
                                {% for first in categorys %}
                                <option value="{{ first[ 'id' ] | escape_attr }}" >{{ first[ 'name' ] | e }}</option>
                                {% if first[ 'sub' ] is defined %}
                                    {% for second in first[ 'sub' ] %}
                                        <option value="{{ second[ 'id' ] | escape_attr }}" style="padding-left:20px;" >--{{ second[ 'name' ] | e }}</option>
                                         {% if second[ 'sub' ] is defined %}
                                            {% for third in second[ 'sub' ] %}
                                            <option value="{{ third[ 'id' ] | escape_attr }}" style="padding-left:40px;" >---{{ third[ 'name' ] | e }}</option>
                                            {% endfor %}
                                        {% endif %}
                                    {% endfor %}
                                {% endif %}
                                {% endfor %}
                                {% endif %}
                            </select>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">商品名称</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="name" name="name" placeholder="请输入商品名称"/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">商品价格</label>
                        <div class="col-xs-2">
                            <strong style="position:absolute;left: 0; top:8px; margin-left:20px; font-size:14px; color:gray">￥</strong>
                            <input class="form-control" style="padding-left:20px;" type="text" id="price" name="price" placeholder="请输入商品价格" />
                        </div>
                    </div>
                  
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">商品库存</label>
                        <div class="col-xs-2">
                            <input class="form-control" type="text" id="password" name="skuleft" placeholder="请输入库存数量" />
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-xs-2 control-label"> 是否上架</label>
                        <div class="col-xs-8">
                            <label class="radio-inline"><input type="radio" name="status" value="1" checked=""/>上架</label>
                            <label class="radio-inline"><input type="radio" name="status" value="0"/>下架</label>
                        </div>
                    </div>
                     <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">商品图片</label>
                        <div class="col-xs-10 text-left">
                            <div class="goods-img-wrap" style="display:inline-block;">
                            <div class="goods-pic goods-img" style="display:none;">
                                <img  src=""/>
                                <input type="hidden" />
                                <div class="goods-pic-operate">
                                    <i class="glyphicon glyphicon-arrow-left" style="margin-right:10px;"></i>
                                    <i class="glyphicon glyphicon-trash" style="margin-right:10px;"></i>
                                    <i class="glyphicon glyphicon-arrow-right"></i>
                                </div>
                            </div>
                            </div>
                            <div class="goods-pic goods-pic-add" >
                                <i class="glyphicon glyphicon-plus" style="margin-top:40%;"></i>
                            </div>
                        </div>
                    </div>
                     <div class="form-group has-feedback text-right" >
                        <label class="col-xs-2 control-label">商品重量</label>
                        <div class="col-xs-2">
                            <strong style="position:absolute;left: 0; top:8px; margin-left:20px; font-size:13px; color:gray">kg</strong>
                            <input class="form-control" style="padding-left:23px;" type="text" id="password" name="weight" placeholder="请输入商品重量" /> 
                        </div>
                    </div>
                     <div class="form-group has-feedback text-right goods-address" >
                        <label class="col-xs-2 control-label">商品产地</label>
                        <div class="col-xs-2">
                            <select class="form-control" id="provinces" >
                                {% for item in provinces %}
                                <option value="{{ item[ 'id' ] | escape_attr }}" {% if item[ 'id' ] == 27 %} selected {% endif %}>{{ item[ 'name' ] | e }}</option>
                                {% endfor %}
                            </select>
                        </div>
                         <div class="col-xs-2">
                            <select class="form-control" id="citys" >
                                {% for item in citys %}
                                <option value="{{ item[ 'id' ] | escape_attr }}" {% if item[ 'id' ] == 438 %} selected {% endif %}>{{ item[ 'name' ] | e }}</option>
                                {% endfor %}
                            </select>
                        </div>
                         <div class="col-xs-2" id="">
                            <select class="form-control" name="address" value="" id="countrys" >
                                {% for item in countrys %}
                                <option value="{{ item[ 'id' ] | escape_attr }}" {% if item[ 'id' ] == 4673 %} selected {% endif %}>{{ item[ 'name' ] | e }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="goodsInsert" style="margin-right: 50px;width:70px;">保存
                                
                            </button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" style="width:70px;">返回</button>
                        </div>
                         <div class="col-xs-12 text-center loading"  style="margin-top:-20px; display:none;"> 
                            <i class="fa fa-pulse fa-spinner  fa-2x"  > </i>
                        </div>
                    </div>
                </form>
                
            </div>
            <div role="tabpannel" class="tab-pane" id="goodsArticle" style="padding-top:20px;height:1000px; margin-bottom: 30px;">
                <script type="text/plain" id="goodsArticleEdit" ></script>
                <input type="hidden" id="goodsId" value=""/>
                <div class="col-sm-6 text-center" style="margin:30px 0 0">
                    <button type="button" class="btn btn-success btn-sm" id="goodsArticleSave" style="margin-right: 50px;width:70px;">保存 </button> 
                    <button type="button" class="btn btn-default btn-sm" id="goodsArticleCancel" style="width:70px;">返回</button>
                </div>
                <div class="col-xs-12 text-center loading"  style="margin-top:-20px; display:none;"> 
                    <i class="fa fa-pulse fa-spinner  fa-2x"  > </i>
                </div>
            </div>
            
        </div>
        <div class="alert alert-danger text-center col-xs-2" style="position:fixed; bottom:20px; margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
       <!------选择图片----->
        <div class="modal fade" id="selectModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"  style="">
            <div class="modal-dialog modal-sm" style="width:680px;">
              <div class="modal-content" >
                    <div class="modal-body" >
                        <div>
                            <!--<iframe src="/admin/images/select" frameborder="0" style="width:300px; height:300px;">-->
                              <iframe id="imageSpace" name="imageSpace" width="650px" height="400px" frameborder="0" ></iframe>
                        </div>
                        <!---->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" id="imageSave">保存</button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
                    </div>
              </div>
            </div>
        </div>
       
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/u/ueditor.config.js"></script>
        <script src="/u/ueditor.all.js"></script>
        <script type="text/javascript" charset="utf-8" src="/u/lang/zh-cn/zh-cn.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script>
   
    $( function(){   
        /*------------------省市的切换----------------*/
        $( '#provinces' ).change( function(){
           var id = $( this ).val();
           $.get( '/admin/goods/getAddress', { 'id':id }, function( ret ) {
               if( ! ret.status )
               {
                   $( '#citys' ).html( '<option> 请选择市</option>' );
                   var address = ret.address;
                   for( var i in address )
                   {
                       $( '#citys' ).append( '<option value=' + address[i].id +'>' + address[i].name + '</option>' );
                   }
                   $( '#countrys' ).html( '<option>请选择县或区</option>' );
               }
               else
               {
                   errorMsg( ret.msg );
               }
           }, 'json').error( function(){
               errorMsg( '网络不通' );
           });
        });
        
        $( '#citys' ).change( function(){
           var id = $( this ).val();
           $.get( '/admin/goods/getAddress', { 'id':id }, function( ret ) {
               if( ! ret.status )
               {
                   $( '#countrys' ).html( '<option> 请选择县或区</option>' );
                   var address = ret.address;
                   for( var i in address )
                   {
                       $( '#countrys' ).append( '<option value=' + address[i].id +'>' + address[i].name + '</option>' );
                   }
               }
               else
               {
                   errorMsg( ret.msg );
               }
           }, 'json').error( function(){
               errorMsg( '网络不通' );
           });
        });
        /*--------------分页切换----------------------*/
        $('#tabs a').click(function (e) {
            if( $( this ).parent().index() === 0 ) //第一个分页是商品列表
                return;
            e.preventDefault();
            $(this).tab( 'show' );
          });
          
        /*------------------商品文章编辑器-----------------*/
        var articleEditor = UE.getEditor('goodsArticleEdit', {
            initialFrameWidth: 800,
            initialFrameHeight: 400,
            minFrameHeight: 400,
            initialStyle: 'body{font-size:12px}',
            topOffset: 200,
            sid: '<?php echo $this->session->getId();?>',
        	bizt:'shop',
            toolbars: [[
            'fullscreen', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
            'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',
            'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
            'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
            'print', 'preview', 'searchreplace', 'help', 'drafts'
        ]]
        });
        enableSaveArticle = true;//防止多次点击
        $( '#goodsArticleSave' ).click( function() { 
            var goodsId = $( '#goodsId' ).val();
            if( !goodsId )
            {
                errorMsg( '请先添加商品' );
                return false;
            }
            var goodsArticle = articleEditor.getContent();
            if( ! goodsArticle )
            {
                errorMsg( '请添加商品详情' );
                return false;
            }
            if( ! enableSaveArticle ) 
            {
               errorMsg( '正在保存，请稍后' );  
            }
            enableSaveArticle = false;
            $( '.loading' ).show();
            
            $.post( '/admin/goods/saveArticle', { content : goodsArticle, goodsId: goodsId }, function( ret ) {
                $( '.loading' ).hide();
                var objRet = eval( '(' + ret + ')' );
                if( ! objRet.status )
                {
                    successMsg( objRet.msg );
                }
                else
                {
                    errorMsg( objRet.msg );
                }
                enableSaveArticle = true;
            } ).error( function(){
                $( '.loading' ).hide();
                errorMsg( '网络不通' );
                enableSaveArticle = true;
            });
        });
        
        //文章取消   跳转到商品添加网页
         $( '#goodsArticleCancel' ).click( function() { 
             $('#tabs a[href="#goodsAdd"]').tab( 'show' );
         });
         
        /*---------------商品图片添加-------*/    
         $( '.goods-pic-add' ).click( function(){ //图片的添加
            $( '#selectModal').modal( 'toggle' );
            $( '.modal-backdrop' ).removeClass( 'in' ); //去掉阴影
            $( '#selectModal' ).find( 'modal-dialog' ).css( 'width', '800' );
            $( '#selectModal' ).find( 'iframe' ).attr( 'src', '/admin/images/select' );
        });
        
        $( '#imageSave' ).click( function(){ //保存所选择的图片
            var selected = $( window.frames[ "imageSpace" ].document ).find('.selected' );
            var goodsImg = $( 'form' ).data( 'changePic' );
            if( goodsImg ) //修改图片
            {
                var src = selected.eq(0).find( 'img' ).attr( 'src' );
                $( goodsImg ).attr( 'src', src );
                $( goodsImg ).siblings( 'input' ).val( src );
                $( 'form' ).data( 'changePic', false );
            }   
            else //添加图片
            {
                selected.each(function( ){
                    var src = $( this ).find( 'img' ).attr( 'src' ); 
                    var pic = $( '.goods-img ').eq(0).clone();

                    $( '.goods-img-wrap' ).append( pic ); //添加到后面
                    $( pic ).find( 'input' ).attr( 'name', 'pics[]' ); 
                    $( pic ).find( 'input' ).attr( 'value', src );
                    $( pic ).find( 'img' ).attr( 'src', src ); //保存网址
                    $( pic ).show();
               });
            }
           $( '#selectModal' ).modal( 'toggle' );
        });
        
        $( 'form' ).delegate( '.goods-img img', 'click', function(){ //图片修改
            $( '#selectModal' ).find( 'iframe' ).attr( 'src', '/admin/images/select' );
            $( '#selectModal' ).modal( 'toggle' );
            $( '.modal-backdrop' ).removeClass( 'in' ); //去掉阴影
            $( 'form' ).data( 'changePic', this );
        });
        
        /*-----------------显示对图片的操作--------------------*/
        $( 'form' ).delegate ( '.goods-img', 'mouseover', function(){ //显示对图片的操作
            $( this ).find( '.goods-pic-operate' ).show();
            return true;
        });
        $( 'form' ).delegate ( '.goods-img', 'mouseout', function(){ 
            $( this ).find( '.goods-pic-operate' ).hide();
        });
        $( 'form' ).delegate ( '.goods-pic-operate .glyphicon', 'mouseover', function(){ //显示对图片的操作
            $( this ).css( 'color', 'black' ); 
        });
        $( 'form' ).delegate ( '.goods-pic-operate .glyphicon', 'mouseout', function(){ 
           $( this ).css( 'color', 'gray' );
        });
        
        /*-----------------对图片的操作--------------------*/
        $( 'form' ).delegate( '.glyphicon-arrow-left', 'click', function(){
             var current = $( this ).parents( '.goods-pic' );
            current.insertBefore( current.prev() );
        });
        $( 'form' ).delegate( '.glyphicon-arrow-right', 'click', function(){
            var current = $( this ).parents( '.goods-pic' );
            current.insertAfter( current.next() );
        });
        $( 'form' ).delegate( '.glyphicon-trash', 'click', function(){
            $( this ).parents( '.goods-pic' ).remove();
        });
       
        /*-------------数据检验------------*/
        $( ':text' ).blur( function(){
            var objParent = $( this ).parents( '.form-group' );
            objParent.find( 'span' ).remove();
            var value = $( this ).val();

            if( value )
            {
                success( objParent );
             }
             else
             {
                error( objParent );
             }
        });
        /*-----------添加数据-----------*/
        enableSave = true; //只能成功保存一次
        $( '#goodsInsert' ).click( function(){
            $( ':text' ).blur(); //重新检验一下数据
            if( ! $( '#categoryId' ).val() )
            {
                errorMsg( '请选择分类' );
                return false;
            }
            if( $( '.goods-img-wrap .goods-img' ).last().is( ':hidden') ) //判断是否上传图片
            {
                errorMsg( '请上传商品图片' );
                return false;
            }
            
            if( ! $( 'form span' ).hasClass( 'glyphicon-remove') ) //数据正确可以提交表单了
            {
                var data = $( 'form' ).serialize();
                var key = '&<?php echo $this->security->getTokenKey();?>=<?php echo $this->security->getToken();?>';
                data += key;
                if( ! enableSave )
                {
                    errorMsg( '正在保存，请稍后' );
                    return false;
                }
                enableSave = false;
                $( '.loading' ).show();
                
                $.post( '/admin/goods/insert', data, function( ret ){
                    if( ! ret.status )
                    {
                        $( '#goodsId' ).val( ret.id ); //新添加的商品的id
                        $( '#goodsInsert' ).attr( 'disabled', 'disabled'); //禁止再次提交
                        successMsg( ret.msg );
                    }
                    else
                    {
                        errorMsg( ret.msg );
                        enableSave = true;
                    }
                    $( '.loading' ).hide();

                }, 'json').error(function(){
                    errorMsg( '网络不通' );
                    $( '.logding' ).hide();
                    enableSave = true;
                });
            }

            return false;
        });
       /* ----------取消---------------*/
       $( '#cancel' ).click( function(){
            location = '/admin/goods/index';
            return false;
       });
    });
    function success( obj )
    {
         obj.addClass( 'has-success').removeClass('has-error');
         obj.find('.form-control').after( '<span class="glyphicon glyphicon-ok form-control-feedback"></span>' );
    }
    function error( obj )
    {
         obj.addClass( 'has-error').removeClass('has-success');
         obj.find('.form-control').after( '<span class="glyphicon glyphicon-remove form-control-feedback"></span>' );
    }
    function errorMsg( msg )
    {
        $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
        $( '.alert span' ).text( msg );
        $( '.alert' ).show().fadeOut( 3000 );
    }
    function successMsg( msg )
    {
        $( '.alert' ).addClass( 'alert-success' ).removeClass( 'alert-danger' );
        $( '.alert span' ).text( msg );
        $( '.alert' ).show().fadeOut( 3000 );
    }
    </script>
    </body>
</html>
