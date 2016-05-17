<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.css">
        <style>

            .goods-pic {
                position:relative;margin:0 20px 20px 0;
                border:1px dashed gray;display:inline-block; vertical-align: middle;text-align: center;color:gray;cursor:pointer;
            }
            .goods-img:nth-child(2) .glyphicon-arrow-left {
                display:none;
            }
            .goods-img:last-child .glyphicon-arrow-right {
                display:none;
            }
            .goods-pic img {
                margin:5px; max-width:500px;max-height:300px;
            }
            .goods-pic-operate {
                position:absolute;bottom: 0; width:100%; text-align: center;background:gainsboro; display:none;
            }
            .goods-address div.col-xs-2  {
                padding-right: 0;
            }

            .ad-pic-operate {
                position:absolute;bottom: 0; width:100%; text-align: center;background:gainsboro; display:none;
            }
            .col-xs-2 {
                padding-right: 0;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation"><a href="/admin/ad/index">广告</a></li>
            <li role="presentation"class="active"><a href="#adEdit" >编辑广告</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="adEdit" style="padding-top:20px;">
                <form class="form-horizontal">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">广告分类</label>
                        <div class="col-xs-2">
                            <select class="form-control" id="categoryId" name="categoryId" value="" required="required">
                                {% if categorys is not empty %}
                                {% for first in categorys %}
                                <option value="{{ first[ 'id' ]| escape_attr}}" 
                                        {% if ad[ 'cat_id' ] == first[ 'id'] %} selected {% endif %}>{{ first[ 'name' ] |e}}</option>
                                {% if first[ 'sub' ] is defined %}
                                {% for second in first[ 'sub' ] %}
                                <option value="{{ second[ 'id' ]| escape_attr}}" style="padding-left:20px;" 
                                        {% if ad[ 'cat_id' ] == second[ 'id'] %} selected {% endif %} >--{{ second[ 'name' ] |e}}</option>
                                {% if second[ 'sub' ] is defined %}
                                {% for third in second[ 'sub' ] %}
                                <option value="{{ third[ 'id' ]| escape_attr}}" style="padding-left:40px;" 
                                        {% if ad[ 'cat_id' ] == third[ 'id'] %} selected {% endif %} >---{{ third[ 'name' ] |e}}</option>
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
                        <label class="col-xs-2 control-label">广告标题</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="title" name="title" placeholder="请输入广告标题" required="required" value="{{ ad[ 'title' ]| escape_attr }}"/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">广告名称</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="name" name="name" placeholder="请输入广告名称" required="required" value="{{ ad[ 'name' ]| escape_attr }}"/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">开始时间</label>
                        <div class="col-xs-3">
                            <input class="form-control form_datetime" type="text" id="begin_time" name="begin_time" placeholder="请输开始时间" value="<?php echo $this->escaper->escapeHtmlAttr( date( 'Y-m-d',
                $ad[ 'begin_time' ] ) ) ?>" required="required"/>
                        </div>
                    </div>

                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">结束时间</label>
                        <div class="col-xs-3">
                            <input class="form-control form_datetime" type="text" id="end_time" name="end_time" placeholder="请输结束时间" value="<?php echo $this->escaper->escapeHtmlAttr( date( 'Y-m-d',
                $ad[ 'end_time' ] ) ) ?>" required="required"/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">广告排序</label>
                        <div class="col-xs-3">
                            <input class="form-control"  type="text" id="sort_order" name="sort_order" placeholder="请输入广告排序" value="{{ ad[ 'sort_order' ] | escape_attr}}" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label"> 广告类型</label>
                        <div class="col-xs-8">
                            <label class="radio-inline"><input type="radio" name="media_type" value="0" {% if ! ad[ 'media_type' ] %} checked {% endif %}/>图片</label>
                            <label class="radio-inline"><input type="radio" name="media_type" value="1" {% if ad[ 'media_type'] %} checked {% endif %} />视频</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label"> 是否展示</label>
                        <div class="col-xs-8">
                            <label class="radio-inline"><input type="radio" name="enabled" value="0" {% if ! ad[ 'enabled' ] %} checked {% endif %}/>否</label>
                            <label class="radio-inline"><input type="radio" name="enabled" value="1" {% if ad[ 'enabled'] %} checked {% endif %} />是</label>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">上传图片</label>
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
                                {% if ad[ 'url' ] is defined %}
                                <div class="goods-pic goods-img" >
                                    <img  src="{{ ad[ 'url' ]| escape_attr }}"/>
                                    <input type="hidden" value="{{ ad[ 'url' ]| escape_attr }}" name="pics" />
                                    <div class="goods-pic-operate">
                                        <i class="glyphicon glyphicon-arrow-left" style="margin-right:10px;"></i>
                                        <i class="glyphicon glyphicon-trash" style="margin-right:10px;"></i>
                                        <i class="glyphicon glyphicon-arrow-right"></i>
                                    </div>
                                </div>
                                {% endif %}
                            </div>
                            <div class="goods-pic goods-pic-add" >
                                <i class="glyphicon glyphicon-plus" style="width:100px;height:80px; margin-top:50%;" ></i>
                            </div>
                            <div style="display:none;">
                                <script type="text/plain" id="goodsPicEdit" ></script>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label"> 广告链接</label>
                        <div class="col-xs-3">
                            <input class="form-control"  type="text" id="source_url" name="source_url" placeholder="请输入广告链接" value="{{ ad[ 'src' ] | escape_attr}}" required="required"/>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="adUpdate" style="margin-right: 50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" style="width:70px;">取消</button>
                        </div>
                    </div>
                    <input type="hidden" id="adId" name='adId' value="{{ ad[ 'id' ] | escape_attr }}"/>
                </form>

            </div>



        </div>
        <div class="alert alert-danger text-center col-xs-2" style="position:fixed; bottom:0; margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>

        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/u/ueditor.config.js"></script>
        <script src="/u/ueditor.all.js"></script>
        <script type="text/javascript" charset="utf-8" src="/u/lang/zh-cn/zh-cn.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
        <script>

$( function(){
    $( '.form_datetime' ).datetimepicker( {
        language: 'zh-CN',
        autoclose: 1,
        todayBtn: 1,
        pickerPosition: "bottom-left",
        minuteStep: 5,
        format: 'yyyy-mm-dd',
        minView: 'month'　　　　//日期时间选择器所能够提供的最精确的时间选择视图。
    } );
    /*--------------分页切换----------------------*/
    $( '#tabs a' ).click( function( e ){
        if( $( this ).parent().index() === 0 ) //第一个分页是商品列表
            return;
        e.preventDefault();
        $( this ).tab( 'show' );
    } );

    /*---------------商品图片添加-------*/
    var picEditor = UE.getEditor( 'goodsPicEdit', { sid: '<?php echo $this->session->getId(); ?>', isShow: false,
        toolbars: [ [ 'insertimage' ] ], bizt: 'user' } );
    picEditor.addListener( 'beforeInsertImage', function( t, arg ){     //侦听图片上传
        if( arg.length )
        {
            var goods_img = $( 'form' ).data( 'changePic' ); //单个图片的更新
            if( goods_img )
            {
                $( goods_img ).attr( 'src', arg[0].src );
                $( goods_img ).siblings( 'input' ).val( arg[0].src );
                $( 'form' ).data( 'changePic', false );
            }
            else
            {
                for( var i in arg )
                {
                    var pic = $( '.goods-img ' ).eq( 0 ).clone();
                    $( '.goods-img-wrap' ).append( pic ); //添加到后面

                    $( pic ).find( 'input' ).attr( 'name', 'pics' );
                    var data = arg[i].src;
                    $( pic ).find( 'input' ).attr( 'value', data );

                    $( pic ).find( 'img' ).attr( 'src', arg[i].src ); //保存网址
                    $( pic ).show();
                }
            }
        }
    } );
    $( '.goods-pic-add' ).click( function(){ //图片的添加
        var myImage = picEditor.getDialog( "insertimage" );
        myImage.open();
    } );
    $( 'form' ).delegate( '.goods-img img', 'click', function(){ //图片修改
        var myImage = picEditor.getDialog( "insertimage" );
        myImage.open();
        $( 'form' ).data( 'changePic', this );
    } );
    /*-----------------显示对图片的操作--------------------*/
    $( 'form' ).delegate( '.goods-img', 'mouseover', function(){ //显示对图片的操作
        $( this ).find( '.goods-pic-operate' ).show();
        return true;
    } );
    $( 'form' ).delegate( '.goods-img', 'mouseout', function(){
        $( this ).find( '.goods-pic-operate' ).hide();
    } );
    $( 'form' ).delegate( '.goods-pic-operate .glyphicon', 'mouseover', function(){ //显示对图片的操作
        $( this ).css( 'color', 'black' );
    } );
    $( 'form' ).delegate( '.goods-pic-operate .glyphicon', 'mouseout', function(){
        $( this ).css( 'color', 'gray' );
    } );

    /*-----------------对图片的操作--------------------*/
    $( 'form' ).delegate( '.glyphicon-arrow-left', 'click', function(){
        var current = $( this ).parents( '.goods-pic' );
        current.insertBefore( current.prev() );
    } );
    $( 'form' ).delegate( '.glyphicon-arrow-right', 'click', function(){
        var current = $( this ).parents( '.goods-pic' );
        current.insertAfter( current.next() );
    } );
    $( 'form' ).delegate( '.glyphicon-trash', 'click', function(){
        $( this ).parents( '.goods-pic' ).remove();
    } );

    /*-------------数据检验------------*/
    $( ':text' ).blur( function(){
        var objParent = $( this ).parents( '.form-group' );
        objParent.find( 'span' ).remove();
        var value = $( this ).val();
        if( !$( this ).attr( 'required' ) )
            return false;

        if( value )
        {
            success( objParent );
        }
        else
        {
            error( objParent );
        }
    } );
    /*-----------添加数据-----------*/
    $( '#adUpdate' ).click( function(){
        $( ':text' ).blur(); //重新检验一下数据
        if( !$( '#categoryId' ).val() )
        {
            errorMsg( '请选择分类' );
            return false;
        }

        if( $( '.goods-img-wrap .goods-img' ).last( ).is( ':hidden' ) ) //判断是否上传图片
        {
            alert( '请上图片' );
            return false;
        }


        if( !$( 'form span' ).hasClass( 'glyphicon-remove' ) ) //数据正确可以提交表单了
        {
            var data = $( 'form' ).serialize();
            var key = '&<?php echo $this->security->getTokenKey(); ?>=<?php echo $this->security->getToken(); ?>';
            data += key;
            $.post( '/admin/ad/update', data, function( ret ){
                if( !ret.status )
                {
                    $( '#adId' ).val( ret.id ); //新添加的广告id 保存下

                    successMsg( ret.msg );
                }
                else
                {
                    errorMsg( ret.msg );
                }

            }, 'json' ).error( function(){
                errorMsg( '网络不通' );
            } );
        }

        return false;
    } );
    /* ----------取消---------------*/
    $( '#cancel' ).click( function(){
        location = '/admin/ad/index';
        return false;
    } );
} );
function success( obj )
{
    obj.addClass( 'has-success' ).removeClass( 'has-error' );
    obj.find( '.form-control' ).after( '<span class="glyphicon glyphicon-ok form-control-feedback"></span>' );
}
function error( obj )
{
    obj.addClass( 'has-error' ).removeClass( 'has-success' );
    obj.find( '.form-control' ).after( '<span class="glyphicon glyphicon-remove form-control-feedback"></span>' );
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
