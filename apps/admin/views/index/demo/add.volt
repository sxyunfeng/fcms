<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
    </head>
    <body class="wrap">
    
       <form class="form-horizontal" style="margin-top:30px">
           <div class="form-group has-feedback">
               <label class="col-xs-2 control-label">姓名</label>
               <div class="col-xs-3">
                   <input class="form-control" type="text" id="name" name="name" placeholder="请输入姓名"/>
               </div>
           </div>
            <div class="form-group has-feedback">
               <label class="col-xs-2 control-label">昵称</label>
               <div class="col-xs-3">
                   <input class="form-control" type="text" id="nickname" name="nickname" placeholder="请输入昵称"/>
               </div>
           </div>
           <div class="form-group has-feedback">
               <label class="col-xs-2 control-label">账号</label>
               <div class="col-xs-3">
                   <input class="form-control" type="text" id="loginname" name="loginname" placeholder="请输入登录账号" />
               </div>
           </div>
           <div class="form-group has-feedback">
               <label class="col-xs-2 control-label">密码</label>
               <div class="col-xs-3">
                   <input class="form-control" type="password" id="password" name="password" placeholder="请输入密码" />
               </div>
           </div>
            <div class="form-group has-feedback">
               <label class="col-xs-2 control-label">确认密码</label>
               <div class="col-xs-3">
                   <input class="form-control" type="password" id="repassword" name="repassword" placeholder="请再次输入密码" />
               </div>
           </div>
           <div class="form-group  has-feedback">
               <label class="col-xs-2 control-label">邮箱</label>
               <div class="col-xs-3">
                   <input class="form-control" type="email" id="email" name="email" placeholder="请输入邮箱" />
               </div>
           </div>

           <div class="form-group">
               <label class="col-xs-2 control-label"> 所属用户组</label>
               <div class="col-xs-8">
                   <div><label class="radio-inline"><input type="radio" name="groupId" value="1"/>管理员</label></div>
                   <div><label class="radio-inline"><input type="radio" name="groupId" value="2"/>技术部</label></div>
                   <div><label class="radio-inline"><input type="radio" name="groupId" value="3"/>人事部</label></div>
               </div>
           </div>
           <div class="form-group" style="margin-top: 30px;">
               <div class="col-sm-offset-2 col-sm-10">
                   <button type="button" class="btn btn-success btn-sm" id="userInsert" style="margin-right: 30px;width:100px;">保存</button>
                   <button type="button" class="btn btn-default btn-sm" id="cancel" style="width:100px;">取消</button>
               </div>
           </div>
       </form>
                
       <script src="/js/jquery/jquery-1.11.1.min.js"></script>
       <script src="/public/bootstrap/3.3.0/js/bootstrap.min.js"></script>
       <script>
          /*  function success( obj )
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
               $( '.alert span' ).text( msg );
               $( '.alert' ).show().fadeOut( 3000 );
           } */
           
           $( '#userInsert, #cancel' ).click( function(){
        	   location.href = '/admin/index/demo';
           } );
       </script>
    </body>
</html>