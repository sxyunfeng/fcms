<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
         <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
         <link rel="stylesheet" href="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.css">
    </head>
    <style>
        button {
            margin-right:50px;
            width:70px;
        }
        .col-xs-2 {
            padding-right:0;
        }
    </style>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation" class=""><a href="{{ url( 'admin/members/index' ) }}">会员</a></li>
            <li role="presentation" class="active"><a href="#memberRead">会员详情</a></li>
        
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="memberRead" style="padding-top:20px;">
                {% if member is defined and member is not empty %}
                <form class="form-horizontal" id="memberInfo">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">账号</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="loginname" name="login_name" placeholder="请输入账号" value='{{ member[ 'login_name' ] | escape_attr }}'  />
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">姓名</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="name" name="username" placeholder="请输入姓名" value='{{ member[ 'username' ] | escape_attr }}'/>
                        </div>
                    </div>
                    <div class="form-group  has-feedback text-right">
                        <label class="col-xs-2 control-label">邮箱</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="email" id="email" name="email" placeholder="请输入邮箱" value="{{ member[ 'email' ] | escape_attr }}"/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">手机</label>
                        <div class="col-xs-2">
                            <input class="form-control" type="text" id="loginname" name="mobile_phone" placeholder="请输入手机号" value='{{ member[ 'mobile_phone' ] | escape_attr }}'  />
                        </div>
                    </div>
                     <div class="form-group  has-feedback text-right">
                        <label class="col-xs-2 control-label">积分</label>
                        <div class="col-xs-2">
                            <input class="form-control" type="email" id="rest_points" name="email" placeholder="请输积分" value="{{ member[ 'rest_points' ] | escape_attr }}"/>
                        </div>
                    </div>
                     <div class="form-group  has-feedback text-right">
                        <label class="col-xs-2 control-label">性别</label>
                        <div class="col-xs-2 text-left">
                            <label class="radio-inline">
                                <input  type="radio"  name="man"  value="0" {% if member[ 'gender' ] == 0 %} checked {% endif %}/>
                                男
                            </label>
                            <label class="radio-inline">
                                <input  type="radio"  name="man"  value="1" {% if member[ 'gender' ] == 1 %} checked {% endif %}/>
                                女
                            </label>
                        </div>
                    </div>
                     <div class="form-group  has-feedback text-right">
                        <label class="col-xs-2 control-label">出生日期</label>
                        <div class="col-xs-2">
                            <input class="form-control form_datetime" type="text" value="{{ member[ 'birthdate'] | escape_attr }}"  />
                        </div>
                    </div>
                    {% if provinces is defined %}
                    <div class="form-group has-feedback text-right" >
                        <label class="col-xs-2 control-label">出生地</label>
                           <div class="col-xs-2">
                            <select class="form-control" id="provinces" >
                                {% for item in provinces %}
                                <option value="{{ item[ 'id' ] }}" {% if item[ 'id' ] == member[ 'province'] %} selected {% endif %}>{{ item[ 'name' ] | escape_attr }}</option>
                                {% endfor %}
                            </select>
                        </div>
                         <div class="col-xs-2">
                            <select class="form-control" id="citys" >
                                {% for item in citys %}
                                <option value="{{ item[ 'id' ] }}" {% if item[ 'id' ] == member[ 'city'] %} selected {% endif %}>{{ item[ 'name' ] | escape_attr }}</option>
                                {% endfor %}
                            </select>
                        </div>
                         <div class="col-xs-2" id="">
                            <select class="form-control" name="address" value="" id="countrys" >
                                {% for item in countrys %}
                                <option value="{{ item[ 'id' ] }}" {% if item[ 'id' ] == member[ 'district'] %} selected {% endif %}>{{ item[ 'name' ] | escape_attr }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    {% endif %}
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-xs-3 text-center">
                            <button type="button" class="btn btn-default btn-sm" id="cancel" onclick="location='/admin/members/index';" >返回</button>
                        </div>
                    </div>
                    <input type="hidden" name="memberId"  value="{{ member['id'] | e }}" />
                </form>
                {% else %}
                <div class="col-xs-12 text-center text-danger">没有数据</div>
                {% endif %}
            </div>
            
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.js"></script>
        <script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
        <script>
                $(function () {
                    $('.form_datetime').datetimepicker({
                        language: 'zh-CN',
                        autoclose: 1,
                        todayBtn: 1,
                        pickerPosition: "bottom-left",
                        minuteStep: 5,
                        format: 'yyyy-mm-dd',
                        minView: 'month'　　　　//日期时间选择器所能够提供的最精确的时间选择视图。
                    });
        });
        </script>
    </body>
</html>