<!doctype html>
<html>
    <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
    <style>
        body {
             font-family: "Arial","微软雅黑",sans-serif;
        }
        
    </style>
    <body class="wrap">
        <div class="row text-center">
            <div class="col-xs-4 ">
                 <div class="panel panel-danger">
                     <div class="panel-heading"><i class="glyphicon  glyphicon-warning-sign"></i>{{ data['type'] }}</div>
                     <div class="panel-body text-center">
                         <div class="col-xs-6">
                             {{ data[ 'msg' ] }}
                         </div>
                        
                     </div>
                    </div>
            </div>
        </div>
    </body>
</html>