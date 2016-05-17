<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap/toastr/toastr.min.css">
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/css/admin/privilege.css">
        <link rel="stylesheet" href="/bootstrap/jqueryConfirm/2.5.0/jquery-confirm.css">
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist"> 
            <li role="presentation" ><a href="/admin/privilege/index">权限</a></li>
            <li role="presentation" class="active"><a href="#">{% if id is not empty %}编辑{% else %}添加{% endif %}</a></li>
        </ul>
        <div class="tab-content wrap-tab-content">
            <div role="tabpannel" class="tab-pane active">
                <form class="form-horizontal" id="form">
                    <div class="form-group">
                        <label class="col-xs-2 control-label">上级</label>
                        <div class="col-xs-3">
                             <p class="form-control-static">{% if pname is not empty %}{{ pname | escape_attr }}{% else %} 无 {% endif %}</p>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">菜单名</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" name="name" placeholder="请输入权限名" value='{% if name is not empty %}{{ name | escape_attr }}{% endif %}'/>
                            <span class="glyphicon form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">排序</label>
                        <div class="col-xs-2">
                            <input class="form-control" type="text"  name="sort" placeholder="请输入数字" value='{% if sort is not empty %}{{ sort | escape_attr }}{% else %}0{% endif %}'/>
                            <span class="glyphicon form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">加载模式</label>
                        <div class="col-xs-8 text-left">
                            <label class="radio-inline">
                                <input type="radio" name="loadmode" value="1"  {% if loadmode is not empty %} checked {% endif %} />同步
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="loadmode" value="0" {% if loadmode is empty %} checked {% endif %} />异步
                            </label>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">是否显示</label>
                        <div class="col-xs-8 text-left">
                            <label class="radio-inline">
                                <input type="radio" name="display" value="1"  {% if display is not empty %} checked {% endif %} />是&#12288;
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="display" value="0" {% if display is empty %} checked {% endif %} />否&#12288;
                            </label>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">是否只是菜单</label>
                        <div class="col-xs-2 text-left " >
                            <label class="radio-inline">
                                <input type="radio" name="type" value="3" {% if id is not empty %}disabled{% endif %} {% if type is defined and type === '3' %} checked {% endif %} />是&#12288;
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="type" value="0" {% if id is not empty %}disabled{% endif %} {% if type is not defined or type !== '3' %} checked {% endif %} />否&#12288;
                            </label>
                        </div>
                        {% if id is empty %}
                        <div class="col-xs-3"><p class="help-block"><i class="glyphicon glyphicon-info-sign"></i> 一旦保存不可修改, 只是菜单系统自动生成 </p></div>
                        {% endif %}
                    </div>
                   
                    {% if type is not defined or type !== '3' %}
                    <div class="form-group text-right only-menu">
                        <label class="col-xs-2 control-label">模块</label>
                        <div class="col-xs-2 text-left">
                            <p class="form-control-static">
                                <a href="#" id="moduleName" >{% if module is not empty %}{{ module[ 'src' ] | e }}{% endif %}</a>
                                <a href="#" id="moduleEdit" class="glyphicon glyphicon-pencil {% if module is not empty %} hidden {% endif %}"></a>
                                <input class="module-input typeahead" type="text" id="moduleInput" name="module" placeholder="请输入所属模块" 
                                       value='{% if module is not empty %}{{ module[ 'src'] | escape_attr }}{% endif %}'/>
                                <input type="hidden" id="moduleId" name="moduleId" value="{% if module is not empty %}{{ module[ 'id'] | escape_attr }}{% endif %}">
                            </p>
                        </div>
                    </div>
                    
                    <div class="form-group text-right only-menu">
                        <label class="col-xs-2 control-label">控制器</label>
                        <div class="col-xs-2 text-left">
                            <p class="form-control-static">
                                <a href="#" id="controllerName">
                                    {% if controller is not empty %}{{ controller[ 'src'] | e }}{% endif %}
                                </a>
                                <a href="#" id="controllerEdit" class="glyphicon glyphicon-pencil {% if controller is not empty %} hidden {% endif %}"></a>
                                <input class="controller-input typeahead" type="text" id="controllerInput"  name="controller" placeholder="请输入控制器" 
                                       value='{% if controller is not empty %}{{ controller[ 'src'] | escape_attr }}{% endif %}'/>
                                <input type="hidden" id="controllerId" name="controllerId" value="{% if controller is not empty %}{{ controller[ 'id'] | escape_attr }}{% endif %}">
                            </p>
                        </div>
                        <div class="col-xs-3 text-left">
                            <span class="help-block"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;必须是小写字母</span>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right only-menu">
                        <label class="col-xs-2 control-label">操作</label>
                        <div class="col-xs-2">
                            <input class="form-control" type="text" name="src" placeholder="请输入操作名" value='{% if src is not empty %}{{ src | escape_attr }}{% endif %}'/>
                            <span class="glyphicon form-control-feedback"></span>
                        </div>
                        <div class="col-xs-3 text-left">
                            <span class="help-block"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;首字符不能为“_”,且只能为英文字母</span>
                        </div>
                    </div>
                    {% endif %}    
                    <div class="form-group form-submit">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="save">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel">取消</button>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{% if id is not empty %}{{ id | escape_attr }}{% endif %}" />
                    <input type="hidden" name="pid" value="{% if pid is not empty %}{{ pid | escape_attr }}{% endif %}" />
                </form>
            </div>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="/bootstrap/toastr/toastr.min.js"></script>
        <script src="/bootstrap/typeahead/twitter.typeahead.js"></script>
        <script src="/bootstrap/jqueryConfirm/2.5.0/jquery-confirm.js"></script>
        <script>
        $( function(){
            /*-------------模块，控制器的初始化--------------*/
            var cinput = $( '#controllerInput' ), minput= $( '#moduleInput' ), cedit = $( '#controllerEdit' ), medit = $( '#moduleEdit' ),
                cname = $( '#controllerName' ), mname = $( '#moduleName' ), cid = $( '#controllerId' ), mid = $( '#moduleId');
            var moption = {
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('src'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '/admin/privilege/getModules'
            };
            var modules = new Bloodhound( moption );
            var msource =   {
                name: 'modules',
                display: 'src',
                source: modules
            };
            minput.typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, msource);
           
            //模块
            var moduleId = mid.val(), curl = '/admin/privilege/getControllers/mid/';
            var option = {
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('src'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: curl + moduleId
            };
            var controllers = new Bloodhound( option );
            var source = {
                name: 'controllers',
                display: 'src',
                source: controllers
            };
            cinput.typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },source
            );
             //重启controller
            function resetController( )
            {
                localStorage.clear();
                option.prefetch = curl + mid.val();
                source.source  = new Bloodhound( option );
                cinput.typeahead( 'destroy' );
                cinput.typeahead( null,source );
            }
            //重启module
            function resetModule( )
            {
                localStorage.clear();
                msource.source  = new Bloodhound( moption );
                minput.typeahead( 'destroy' );
                minput.typeahead( null,msource );
            }
            //根据相应的module 获得相应的controller
            $( '#controllerName, #controllerEdit' ).click( function(){
                var moduleId = mid.val();
                if( ! moduleId )
                {
                    toastr.error( '请先选择模块' );
                }
                else
                {
                   resetController();
                   $( this ).hide();
                   var name = cinput.val();
                   cinput.show().val( '' ).focus().val( name ); //此处让光标移到最后
                }
            });
            $( '#moduleName, #moduleEdit' ).click( function(){
               $( this ).hide();
               var name = minput.val();
               minput.show().val( '').focus().val( name ); //移动光标到最后
            });           
           
            /*-------------controller 事件-------------*/
            //选择匹配的属性
            cinput.on(  'typeahead:selected', function( e, obj ) {
                cinput.hide();
                cname.text( obj.src ).show();
                cid.val( obj.id );
            });

          
            //开始匹配  此事件为最后一个事件
            cinput.on(  'typeahead:change', function( e, obj ) {
                var src = $.trim( cinput.typeahead( 'val' ));
                var id = $.trim( cid.val() ), moduleName = minput.val(), moduleId = mid.val();
                if( id ) //已经选择
                {
                    return true;
                }
                if( ! src  ) // 未选择 且为空
                {
                     cinput.hide();
                     cname.hide();
                     cedit.show().removeClass( 'hidden');
                     return true;
                }
                
                $.getJSON( '/admin/privilege/isController', { src: src, mid: moduleId }, function( ret ){
                    if( !ret.status ) //合法控制器
                    {
                        cname.text( src ).show();
                        cid.val( ret.id );
                        cinput.hide();
                    } 
                    else //非法控制器 判断是否添加控制器
                    {
                        var reg = /[^a-z_]/;
                        if( reg.test( src ))
                        {
                            toastr.error( '请填写小写字母');
                            return false;
                        }
                        var coption = {};
                        coption.title = '是否在 '+ moduleName +' 下添加控制器：' + src + '？';
                        coption.confirm = function(){
                            var data = $.extend( csrf, { src: src, moduleId: moduleId });
                            $.post( '/admin/privilege/saveController', data, function( ret ){
                                if( !ret.status )
                                {
                                    cname.text( src ).show();
                                    cid.val( ret.id );
                                    cinput.hide();
                                    toastr.success( ret.msg );
                                    resetController();
                                }
                                else
                                {
                                    toastr.error( ret.msg );
                                }
                                setCSRF( ret );
                            }, 'json');
                        };
                        $.confirm( coption );
                    }
                });
            });
             //开始匹配
            var iscRender = false;
            cinput.on(  'typeahead:render', function( e, obj ) {
                if(  iscRender )
                {
                    cid.val( '' );
                }
                iscRender = true;
            });

             //结束了匹配,
            var lastcName = $.trim( cname.text() ); //原始的名称
            var lastcId = cid.val();//原始id
            cinput.on( 'typeahead:close', function( e, obj ){
                if( lastcName === cinput.typeahead( 'val')) //和以前的一样
                {
                    cname.show(); 
                    cid.val( lastcId );
                    cinput.hide();
                    if( ! lastcName )
                    {
                        cedit.show().removeClass( 'hidden');
                    }
                }
            });

            /*-----------module 事件-----------*/    
             //选择匹配的属性
            minput.on(  'typeahead:selected', function( e, obj ) {
                minput.hide();
                mname.text( obj.src ).show();
                mid.val( obj.id );
                
                //模块变化，那就控制器变为编辑状态
                cname.text( '' ).hide();
                cinput.val( '' ).hide();
                cedit.show().removeClass( 'hidden' );
            });

            //开始匹配  此事件为最后一个事件
            minput.on(  'typeahead:change', function( e, obj ) {
                var src = $.trim( minput.typeahead( 'val' ));
                var id = $.trim( mid.val() );
                if( id ) { //已经选择好了
                    return true;
                }
                
                if( ! src  ) // 未选择，且为空
                {
                     minput.hide();
                     mname.hide();
                     medit.show().removeClass( 'hidden');
                     return false;
                }
                
                //判断是否存在
                $.getJSON( '/admin/privilege/isModule', { src: src }, function( ret ){
                    if( !ret.status )
                    {
                        mname.text( src ).show();
                        mid.val( ret.id );
                        minput.hide();
                    }
                    else if( !id && src ) //不是合法模块，提示是否添加新的模块
                    {
                        var coption = {};
                        coption.title = '是否添加模块：' + src + '？';
                        coption.confirm = function(){
                                var data = $.extend( csrf, { src: src });
                                $.post( '/admin/privilege/saveModule', data, function( ret ){
                                    if( !ret.status )
                                    {
                                         mname.text( src ).show();
                                         mid.val( ret.id );
                                         minput.hide();
                                         toastr.success( ret.msg );
                                         resetModule();
                                    }
                                    else
                                    {
                                        toastr.error( ret.msg );
                                    }
                                    setCSRF( ret );
                                }, 'json');
                            };
                        $.confirm( coption );
                    }
                });
            });

             //开始匹配
            var ismRender = false;
             minput.on(  'typeahead:render', function( e, obj ) {
                if(  ismRender )
                {
                    mid.val( '' );
                }
                ismRender = true;
            });

             //结束了匹配,
            var lastmName = $.trim( mname.text() ); //原始的名称
            var lastmId = mid.val();//原始id
            minput.on( 'typeahead:close', function( e, obj ){
                if( lastmName === minput.typeahead( 'val')) //和以前的一样,就恢复以前的
                {
                    mname.show(); 
                    mid.val( lastmId );
                    minput.hide();
                    if( !lastmName )
                    {
                        medit.show().removeClass( 'hidden');
                    }
                }
            });
            
            /*-----------------保存数据-------------------------*/
            var csrf = { key : '{{ security.getTokenKey() }}', token :  '{{ security.getToken() }}'};
            //校验数据是否正确
            $( ':text' ).blur( function(){
               var value = $.trim( $( this ).val());
               var status = true;
               if( value )
               {
                   var name = $( this ).attr( 'name' ); //排序
                   if( name === 'sort')
                   {
                        if( isNaN( value ))
                        {
                            status = false;
                        }
                   }
                   else if( name === 'src') //操作
                   {
                        var isChar = /[^a-zA-Z_]/, isUnder = isUnder = /^_/;
                        if( isChar.test( value ) || isUnder .test( value ))
                        {
                            status = false;
                        }
                   }
               }
               
               if( value && status )
               {
                   $( this ).parents( '.form-group' ).addClass( 'has-success' ).removeClass( 'has-error' );
                   $( this ).siblings( 'span' ).addClass( 'glyphicon-ok' ).removeClass( 'glyphicon-remove' );
               }
               else
               {
                   $( this ).parents( '.form-group' ).removeClass( 'has-success' ).addClass( 'has-error' );
                   $( this ).siblings( 'span' ).removeClass( 'glyphicon-ok' ).addClass( 'glyphicon-remove' );
               }
            });
            //保存
            $( '#save' ).click( function(){
                var src = $.trim( $( 'input[name=src]' ).val());
                var isChar = /[^a-zA-Z_]/, isUnder = isUnder = /^_/;
                if( isChar.test( src ) || isUnder .test( src ))
                {
                    toastr.error( '请不要加_，且必须是字母' );
                    return false;
                }
                return false;
                var sort = $.trim( $( 'input[name=sort]' ).val() );
                if( isNaN( sort ))
                {
                    toastr.error( '请输入数字' );
                    return false;
                }
                var data = $( '#form' ).serialize();
                data += '&' + 'key=' + csrf.key + '&token=' + csrf.token;

                var type = $( 'input[name=type]:checked' ).val();
                if( type === '3' ) //如果只是菜单, 因为disable, data里面不包含type
                {
                    data += '&type=3';
                }
  
                $.post( '/admin/privilege/save', data, function( ret ){
                    if( ! ret.status )
                    {
                       location = '/admin/privilege/index';
                    }
                    else
                    {
                       toastr.error( ret.msg );
                    }
                    setCSRF( ret );
                }, 'json');
            } ).error( function(){
                toastr.error( '网络不通' );
            });
            
            $( '#cancel' ).click( function(){
               location = '/admin/privilege/index'; 
            });
            
            function setCSRF( data ) 
            {
               csrf.key = data.key;
               csrf.token = data.token;
            }
            
            //切换是否只是菜单
            $( 'input[ name=type ]' ).change( function(){
                var value = $( this ).val();
                if( value === '3')
                {
                    $( '.only-menu' ).hide();
                }
                else
                {
                    $( '.only-menu' ).show();
                }
            });
            
        });
        </script>
    </body>
</html>