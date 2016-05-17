<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/css/admin/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/css/admin/shop.css">
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation" class=""><a href="{{ url( 'admin/shops/index' ) }}">商铺</a></li>
            <li role="presentation" class="active"><a href="#shopEdit">编辑商铺</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="shopEdit" style="padding-top:20px;">
                {% if shop is defined and shop is not empty %}
                <form class="form-horizontal" id="shopInfo">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">商铺分类</label>
                        <div class="col-xs-2">
                            <select class="form-control" id="categoryId" name="categoryId" value="">
                                {% if categorys is not empty %}
                                {% for first in categorys %}
                                <option value="{{ first[ 'id' ]}}" 
                                        {% if shopCateId == first[ 'id' ] %} selected {% endif %}>{{ first[ 'name' ] }}</option>
                                {% if first[ 'sub' ] is defined %}
                                {% for second in first[ 'sub' ] %}
                                <option  value="{{ second[ 'id' ]}}" style="padding-left:20px;" 
                                         {% if shopCateId == second[ 'id' ] %} selected {% endif %} >--{{ second[ 'name' ] }}</option>
                                {% if second[ 'sub' ] is defined %}
                                {% for third in second[ 'sub' ] %}
                                <option value="{{ third[ 'id' ]}}" style="padding-left:40px;" 
                                        {% if shopCateId == third[ 'id' ] %} selected {% endif %} >---{{ third[ 'name' ] }}</option>
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
                        <label class="col-xs-2 control-label">商铺名称</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="name" name="name" placeholder="请输入商铺名称" value='{{ shop[ 'name' ]}}'/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">联系人</label>
                        <div class="col-xs-2">
                            <input class="form-control" type="text" id="linkman" name="linkman" placeholder="请输入商铺联系人" value='{{ shop[ 'linkman' ]}}'  />
                        </div>
                    </div>
                    <div class="form-group  has-feedback text-right">
                        <label class="col-xs-2 control-label">联系电话</label>
                        <div class="col-xs-2">
                            <input class="form-control" type="text" id="tel" name="tel" placeholder="请输入联系电话" value="{{ shop[ 'tel' ]}}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label"> 商铺地址</label>
                        <div class="col-xs-10">
                            <div class="col-xs-2" style="padding-left:0;">
                                <select class="form-control input-sm" id="provinces" name="province">
                                    {% for item in provinces %}
                                    <option value="{{ item[ 'id' ] }}" {% if item[ 'id' ] == shop[ 'province' ] %} selected {% endif %}>{{ item[ 'name' ] }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                            <div class="col-xs-2">
                                <select class="form-control input-sm" id="citys" name="city" >
                                    {% for item in citys %}
                                    <option value="{{ item[ 'id' ] }}" {% if item[ 'id' ] == shop[ 'city' ] %} selected {% endif %}>{{ item[ 'name' ] }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                            <div class="col-xs-2" id="">
                                <select class="form-control input-sm" id="countrys" name="district">
                                    {% for item in countrys %}
                                    <option value="{{ item[ 'id' ] }}" {% if item[ 'id' ] == shop[ 'district' ] %} selected {% endif %}>{{ item[ 'name' ] }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">详细地址</label>
                        <div class="col-xs-3"> 
                            <input class="form-control" type="text" name="detail_addr" value="{{ shop[ 'detail_addr' ] }}" placeholder="请输入商铺详细地址"/>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <label class="col-xs-2 control-label" >当前状态</label>
                        <div class="col-xs-3 text-left">
                            <label class="radio-inline"> <input type="radio" value="1" name="status" {% if shop[ 'status' ] == 0 %}checked{% endif %} />正常</label>
                            <label class="radio-inline"> <input type="radio" value="2" name="status" {% if shop[ 'status' ] == 1 %}checked{% endif %} />欠款</label>
                            <label class="radio-inline"> <input type="radio" value="3" name="status" {% if shop[ 'status' ] == 2 %}checked{% endif %} />下架</label>
                            <label class="radio-inline"> <input type="radio" value="4" name="status" {% if shop[ 'status' ] == 3 %}checked{% endif %} />未审核</label>
                        </div>
                    </div>
                    <div class="form-group text-right qq">
                        <label class="col-xs-2 control-label">qq客服</label>
                        <div class="col-xs-3 ">
                            <table class="table table-bordered text-center">
                                <tbody>
                                    {% if qq is defined and qq is not empty %}
                                    {% for item in qq %}
                                    <tr>
                                        <td><input class="qqNumber" name="qq[]" type="text" value="{{ item[ 'qq' ] }}" placeholder="请输入qq号码"></td>
                                        <td><i class="fa fa-lightbulb-o light {% if item[ 'status' ] %} text-muted  {% else %} text-success {% endif %}"></i>
                                            <i class="fa fa-trash-o remove"></i>
                                            <input type="hidden" name="qqStatus[]" value="{{ item[ 'status' ] }}">
                                        </td>
                                    </tr>
                                    {% endfor %}
                                    {% else %}
                                    <tr>
                                        <td><input class="qqNumber" name="qq[]" type="text" value="" placeholder="请输入qq号码"></td>
                                        <td><i class="fa fa-lightbulb-o light text-success"></i>
                                            <i class="fa fa-trash-o remove"></i>
                                            <input type="hidden" name="qqStatus[]" value="0">
                                        </td>
                                     </tr>  
                                    {% endif %}
                                    <tr>
                                        <td colspan="2"> <i class="fa fa-plus add"></i></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="shopUpdate">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" >取消</button>
                        </div>
                    </div>
                    <input type="hidden" name="shopId"  value="{{ shop['id'] }}" />
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
      /*----------------------qq客服----------------------------*/
    //启用qq号
    $( '.qq' ).delegate( '.light', 'click', function(){
        if( $( this ).hasClass( 'text-muted' ) )
        {
            $( this ).addClass( 'text-success' ).removeClass( 'text-muted' );
            $( this ).siblings( 'input' ).val( '0' );
        }
        else
        {
            $( this ).addClass( 'text-muted' ).removeClass( 'text-success' );
            $( this ).siblings( 'input' ).val( '1' );
        }
    } );
    //删除qq号
    $( '.qq' ).delegate( '.remove', 'click', function(){
        var len = $( 'tr' ).length;
        if( len <= 2 )
        {
            alert( '不可再删除' );
        }
        else
        {
            $( this ).parents( 'tr' ).remove();
        }
    } );
    //添加qq号,复制前一个数据
    $( '.add' ).click( function(){
        var self = $( this ).parents( 'tr' );
        var before = self.prev();
        var clone = before.clone();
        clone.find( '.light' ).removeClass( 'text-success' ).addClass( 'text-muted' );
        clone.find( 'input[name="qq[]"]' ).val( '' );
        clone.find( 'input[name="qqStatus[]"]' ).val( '1' );
        clone.insertBefore( self );
    } );

    /*------------------省市的切换----------------*/
    $( '#provinces' ).change( function(){
        var id = $( this ).val();
        $.get( '/admin/shops/getAddress', { 'id': id }, function( ret ){
            if( !ret.status )
            {
                $( '#citys' ).html( '<option> 请选择市</option>' );
                var address = ret.address;
                for( var i in address )
                {
                    $( '#citys' ).append( '<option value=' + address[i].id + '>' + address[i].name + '</option>' );
                }
                $( '#countrys' ).html( '<option>请选择县或区</option>' );
            }
            else
            {
                errorMsg( ret.msg );
            }
        }, 'json' ).error( function(){
            errorMsg( '网络不通' );
        } );
    } );

    $( '#citys' ).change( function(){
        var id = $( this ).val();
        $.get( '/admin/shops/getAddress', { 'id': id }, function( ret ){
            if( !ret.status )
            {
                $( '#countrys' ).html( '<option> 请选择县或区</option>' );
                var address = ret.address;
                for( var i in address )
                {
                    $( '#countrys' ).append( '<option value=' + address[i].id + '>' + address[i].name + '</option>' );
                }
            }
            else
            {
                errorMsg( ret.msg );
            }
        }, 'json' ).error( function(){
            errorMsg( '网络不通' );
        } );
    } );

    /*------------商铺验证----------------*/
    $( '#shopInfo :text' ).blur( function(){
        var objParent = $( this ).parents( '.form-group' );
        if( objParent.is( '.qq' ) ) //qq就不检验
        {
            return false;
        }
        
        objParent.find( 'span' ).remove();
        var value = $( this ).val();
        var id = $( this ).attr( 'id' );
        if( value )
        {
            if( 'tel' === id ) //验证手机是否正确
            {
                var filter = /^1[1-9]{1}[0-9]{9}$/;
                if( !filter.test( value ) )
                {
                    error( objParent );
                    return;
                }
            }
            success( objParent );
        }
        else
        {

            error( objParent );
        }
    } );

    /*-----------更新商铺-----------*/
    $( '#shopUpdate' ).click( function(){
        $( '#shopInfo :text' ).blur(); //重新检验一下数据

        if( !$( '#shopInfo span' ).hasClass( 'glyphicon-remove' ) ) //数据正确可以提交表单了
        {
            var data = $( '#shopInfo' ).serialize();
            var key = '&<?php echo $this->security->getTokenKey(); ?>=<?php echo $this->security->getToken(); ?>';
            data += key;

            $.post( '/admin/shops/update', data, function( ret ){
                if( !ret.status )
                {
                    location = '/admin/shops/index';
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
        location = '/admin/shops/index';
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