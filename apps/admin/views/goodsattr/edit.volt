<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class=""><a href="{{ url( 'admin/goodsAttr/index' ) | escape_attr }}">商品属性</a></li>
            <li role="presentation"class=""><a href="{{ url( 'admin/goodsAttr/add' ) | escape_attr }}" >添加商品属性</a></li>
            <li role="presentation" class="active"><a href="#goodsAttrEdit">编辑商品属性</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="goodsAttrEdit" style="padding-top:20px;">
                {% if goodsAttr is defined and goodsAttr is not empty %}
                <form class="form-horizontal">

                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">属性名称</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="name" name="name" placeholder="请输入属性名称" value='{{ goodsAttr[ 'name' ]|escape_attr}}'/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">属性归类</label>
                        <div class="col-xs-2">
                            <select class="form-control" id="kind_id" name="kind_id" value="" required="required">
                                {% if kinds is not empty %}
                                <option value="0" /> 请选择
                                {% for val in kinds %}
                                <option value="{{ val[ 'id' ]|escape_attr}}" {% if val['id'] == kind[ 'kind_id' ] %} selected {% endif %}/>{{ val[ 'title' ]|e}}
                                {% endfor %}
                                {% endif %}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label"> 是否在详情页展示</label>
                        <div class="col-xs-8">
                            <label class="radio-inline"><input type="radio" name="indetail" value="0" {% if ! kind[ 'indetail' ] %} checked {% endif %}/>是</label>
                            <label class="radio-inline"><input type="radio" name="indetail" value="1" {% if kind[ 'indetail'] %} checked {% endif %}/>否</label>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">属性容量</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="length" name="length" placeholder="请输入属性容量" value='{{ goodsAttr[ 'length' ]|escape_attr}}'/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label"> 选填方式</label>
                        <div class="col-xs-8">
                            <label class="radio-inline"><input type="radio" name="itype" value="0"  {% if ! goodsAttr[ 'itype' ] %} checked {% endif %}/>填写</label>
                            <label class="radio-inline"><input type="radio" name="itype" value="1" {% if goodsAttr[ 'itype'] %} checked {% endif %}/>选择</label>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">属性单位</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="unit" name="unit" placeholder="请输入属性单位" value='{{ goodsAttr[ 'unit' ]|escape_attr}}'/>
                        </div>
                    </div>

                    <div class="form-group has-feedback text-right">

                        <label class="col-xs-2 control-label">属性值</label>
                        <div class="col-xs-3">
                            {% if goodsAttrVal is defined %}
                            <input class="form-control" type="text" id="val" name="val" placeholder="请输入属性值" value='{{ goodsAttrVal|escape_attr}}'/>
                            属性值请用英文','号分割
                            {% else %}
                            <input class="form-control" type="text" id="val" name="val" placeholder="请输入属性值" />
                            属性值请用英文','号分割
                            {% endif %}
                        </div>

                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="goodsAttrUpdate" style="margin-right: 50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" style="width:70px;" >取消</button>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{ goodsAttr['id'] | e }}" />
                </form>
                {% else %}
                <div class="col-xs-12 text-center text-danger">没有数据</div>
                {% endif %}
            </div>
        </div>
        <div class="alert alert-danger col-xs-2 text-center" style="margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
$( function(){


    /*-------------表单数据验证---------------*/
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
    } );

    /*-----------更新数据-----------*/
    $( '#goodsAttrUpdate' ).click( function(){
        $( ':text' ).blur(); //重新检验一下数据


        if( !$( 'form span' ).hasClass( 'glyphicon-remove' ) ) //数据正确可以提交表单了
        {
            var data = $( 'form' ).serialize();
            var key = '&<?php echo $this->security->getTokenKey(); ?>=<?php echo $this->security->getToken(); ?>';
            data += key;

            $.post( '/admin/goodsAttr/update', data, function( ret ){
                if( !ret.status )
                {
                    location = '/admin/goodsAttr/index';
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
        location = '/admin/goodsAttr/index';
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
    $( '.alert span' ).text( msg );
    $( '.alert' ).show().fadeOut( 3000 );
}
        </script>
    </body>
</html>