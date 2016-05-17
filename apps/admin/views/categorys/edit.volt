<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/admin/category.css">
        <link rel="stylesheet" href="/css/admin/font-awesome.css">
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class=""><a href="{{ url( 'admin/categorys/index' ) }}">分类</a></li>
            <li role="presentation"class=""><a href="{{ url( 'admin/categorys/add' ) }}" >添加分类</a></li>
            <li role="presentation" class="active"><a href="#categorysEdit">编辑分类</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="categorysEdit" style="padding-top:20px;">
                {% if category is defined and category is not empty %}
                <form class="form-horizontal">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">姓名</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="cateName" name="cateName" placeholder="请输入分类" value='{{ category[ 'name' ]}}'/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">上级分类</label>
                        <div class="col-xs-3">
                            <select class="form-control" id="parentId" name="parentId" value="">
                                <option value="0" class="text-center">无上级分类</option>
                                {% if allCats is not empty %}
                                {% for first in allCats %}
                                <option  value="{{ first[ 'id' ]}}" 
                                    {% if category[ 'pid' ] == first[ 'id' ] %}selected{% endif %}>{{ first[ 'name' ] }}</option>
                                {% if first[ 'sub' ] is defined %}
                                    {% for second in first[ 'sub' ] %}
                                        <option value="{{ second[ 'id' ]}}" style="padding-left:20px;" 
                                            {% if category[ 'pid' ] == second[ 'id' ] %}selected{% endif %}>--{{ second[ 'name' ] }}</option>
                                         {% if second[ 'sub' ] is defined %}
                                            {% for third in second[ 'sub' ] %}
                                            <option value="{{ third[ 'id' ]}}" style="padding-left:40px;" 
                                                {% if category[ 'pid' ] is third[ 'id' ] %}selected{% endif %}>---{{ third[ 'name' ] }}</option>
                                            {% endfor %}
                                        {% endif %}
                                    {% endfor %}
                                {% endif %}
                                {% endfor %}
                                {% endif %}
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-special">
                        <label class="col-xs-2 text-right">规格</label>
                        <div class="col-xs-10 ">
                            {% if specials is defined and specials is not empty %}
                            {% for item in specials %}
                            <span class="label label-default">{{ item[ 'name' ] | e }}<input type="hidden" name='specs[]' value="{{ item[ 'id' ] | escape_attr }}"></span>
                            {% endfor %}
                            {% endif %}
                            <button class="btn btn-success btn-xs" id="addSpecial"><i class="glyphicon glyphicon-plus"></i></button>
                        </div>
                    </div>
                    <div class="form-group form-special">
                        <label class="col-xs-2 text-right">属性</label>
                        <div class="col-xs-10 ">
                            {% if attrs is defined and attrs is not empty %}
                            {% for item in attrs %}
                            <span class="label label-default">{{ item[ 'name' ] | e }}
                                <input type="hidden" name="attrs[]" value="{{ item[ 'id'] | escape_attr }}"></span>
                            {% endfor %}
                            {% endif %}
                            <button class="btn btn-success btn-xs" id="addAttr"><i class="glyphicon glyphicon-plus"></i></button>
                        </div>
                    </div>
                    <div class="form-group form-special">
                        <label class="col-xs-2 text-right">规格参数</label>
                        <div class="col-xs-10 text-left ">
                            {% if kinds is defined and kinds is not empty %}
                            {% for item in kinds %}
                            <dl class="dl-horizontal">
                                <dt><span class="label label-default">{{ item[ 'title'] | e }} </span></dt>
                                <dd>
                                    {% for vo in item[ 'attrs' ] %}
                                    <span class="label label-default">{{ vo[ 'name' ] | e }}<input type="hidden" name="ksels[]" value="{{ vo[ 'id' ] | escape_attr }}"></span>
                                    {% endfor %}
                                </dd>
                            </dl>
                            {% endfor %}
                            {% endif %}
                            <button class="btn btn-success btn-xs" id="addKind"><i class="glyphicon glyphicon-plus"></i></button>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-xs-offset-2 col-xs-4">
                            <button type="button" class="btn btn-success btn-sm" id="categoryUpdate" style="margin-right: 50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" style="width:70px;" >取消</button>
                        </div>
                        <div class="loading col-xs-2" style="display:none;">
                            <i class="fa fa-spinner fa-pulse fa-2x"></i>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{ category['id'] }}" />
                </form>
                {% else %}
                <div class="col-xs-12 text-center text-danger">没有数据</div>
                {% endif %}
            </div>
        </div>
        <div class="modal modal-attr" style="">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="input-group input-group-sm col-xs-offset-3 col-xs-6">
                            <input class="form-control" id="searchAttr" type="text" placeholder="请输入属性名">
                            <span class="input-group-btn">
                                <button class="btn btn-success" id="searchAttrBtn">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body" >
                        {% if attrDic is defined %}
                        {% for item in attrDic %}
                        <span class="label label-default">{{ item[ 'name' ]}}<input type="hidden" value="{{ item[ 'id' ] }}"></span>
                        {% endfor %}
                        {% endif %}
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
                        <button class="btn btn-primary btn-sm" id="saveAttr">确定</button>
                    </div>
                </div>
            </div>
        </div>
         <div class="modal modal-kind" style="">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="input-group input-group-sm col-xs-offset-3 col-xs-6">
                            <input class="form-control" id="searchKind" type="text" placeholder="请输入属性分类名">
                            <span class="input-group-btn">
                                <button class="btn btn-success" id="searchKindBtn">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body" >
                        {% if attrKind is defined and attrKind is not empty %}
                        {% for item in attrKind %}
                        <dl class="dl-horizontal">
                            <dt><span class="label label-default">{{ item['title'] }}<input type="hidden" value="{{ item['id'] }}"></span></dt>
                            <dd>
                            {% for vo in item[ 'attr' ] %}
                                <span class="label label-default">{{ vo[ 'name' ]}}<input type="hidden" value="{{ vo[ 'id' ] }}"></span>
                            {% endfor %}
                            </dd>
                        </dl>
                        {% endfor %}
                        {% endif %}
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
                        <button class="btn btn-primary btn-sm" id="saveKind">确定</button>
                    </div>
                 
                </div>
            </div>
        </div>
        <div class="alert alert-danger col-xs-2 text-center" style="margin-left:40%;display:none;">
            <i class="glyphicon glyphicon-warning-sign pull-left"></i>
            <span>网络错误</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src='/js/jquery/plugins/jquery.nicescroll.min.js'></script>
        <script src="/js/admin/category.js"></script>
        <script>
    $( function(){
       
        /*-----------更新数据-----------*/
        $( '#categoryUpdate' ).click( function(){
            var name = $( '#cateName' ).val( );
            if( ! name )
            {
                error( $( '#cateName' ).parents( '.form-group' ) );
            }

            if( ! $( ':checked' ).length )
            {
                errorMsg( '请选择用户组' );
                return false;
            }

            if( ! $( 'form span' ).hasClass( 'glyphicon-remove') ) //数据正确可以提交表单了
            {
                var data = $( 'form' ).serialize();
                var key = '&<?php echo $this->security->getTokenKey();?>=<?php echo $this->security->getToken();?>';
                data += key;
                $( '.loading' ).show();
                $.post( '/admin/categorys/update', data, function( ret ){
                    $( '.loading' ).hide();
                    if( ! ret.status )
                    {
                        location = '/admin/categorys/index';
                    }
                    else
                    {
                        errorMsg( ret.msg );
                    }

                }, 'json').error( function(){
                    errorMsg( '网络不通' );
                });
            }

            return false;
        });

    });
 
        </script>
    </body>
</html>