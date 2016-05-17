<! doctype html >
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/admin/font-awesome.min.css" >
        <link rel="stylesheet" href="/css/admin/images.css">
    </head>
    <body class="wrap">
        <div class="row navs" >
            <div class="col-xs-8">
                <ol class="breadcrumb folders-nav" style="">     
                    {% if nav is defined %}
                         <li class="folder-nav" data-id="0"><a href="#">图片空间</a></li> 
                        {% for item in nav %}
                            <li class="folder-nav" data-id="{{ item[ 'id'] }}"><a href="#">{{ item[ 'original'] | e }}</a></li> 
                        {% endfor %}
                    {% else %}
                        <li class="folder-nav active" data-id="0"><a href="#">图片空间</a></li> 
                    {% endif %}
                  
                </ol>
            </div>
            <div class="col-xs-4 text-right">
                <ul class="nav nav-pills pull-right">
                    <li role="presentation" class="" id="uploadImage"><a href="#"><i class="fa fa-upload"></i>上传图片</a></li>
                    <li role="presentation" id="newFolder"><a href="#"><i class="fa fa-plus"></i>新建文件夹</a> </li>
                    <li role="presentation" id="deleteMore"><a href="#"><i class="fa fa-trash-o"></i>删除</a></li>
                  </ul>
             </div>
        </div>
        <div class="row imagesWrap" id="imagesWrap">
            {% if page is defined %}
                {% for item in page.items %}
                    {% if item[ 'type' ] is defined and item[ 'type' ] != '.' and item[ 'url' ]  %}
                    <div class="text-center image-item clear" style="">
                        <div class="thumbnail change-image" data-id="{{ item[ '_id' ] | escape_attr }}" >
                            <img  style="" src="{{ item[ 'url' ] | escape_attr }}" title="点击右键可以重命名，删除" alt="...">
                        </div>
                        <p class="title">{{ item[ 'original'] | e }}</p>
                    </div>  
                    {% elseif item[ 'type' ] is defined %}
                    <div class="text-center folder-item clear" style="">
                        <div class="thumbnail opendir"  data-id="{{ item[ '_id' ] | escape_attr }}">
                            <i class="fa fa-folder folder "></i>
                        </div>
                        <p class="title" >{{ item[ 'original'] | e }}</p>
                    </div>  
                    {% endif %}
                {% endfor %}
            {% else %}
            <div class="col-xs-12 text-center"> 当前目录没有图片 </div>
            {% endif %}
        </div>

        {{ partial( "common/error" )}}
        <!-- 右键菜单 -->
        <div class="popupMenu" >
            <a id="folderRename"><i class="fa fa-pencil"></i>重命名</a>
            <a id="folderRemove"><i class="fa fa-trash-o " style="color:red;font-size:14px;"></i> 删除 </a> 
        </div>
        <!------新建目录  重命名目录----->
        <div class="modal fade" id="folderModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" >
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                    <div class="modal-body">
                        <input class="form-control" placeholder="请输入文件夹名">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" id="folderSave">保存</button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
                    </div>
              </div>
            </div>
        </div>
        <div class="form-group"  >
           <div id="errorBlock" class="help-block"></div>
       </div>
      
        <!--------分页------->
        {% if page is defined  and page.total_pages > 1%}
        <div class="footer-pagination">
            <ul class="pagination">
                <li>
                    <a href="/admin/images/index/pid/{{ page.pid }}/page/{{ page.before }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                {% if  page.before != 1 %}
                    <li><a href="/admin/images/index/pid/{{ page.pid }}/page/1">1</a></li>
                {% endif %}
                {% if  page.before != page.current %}
                    <li><a href="/admin/images/index/pid/{{ page.pid }}/page/{{ page.before }}">{{ page.before }}</a></li>
                {% endif %}
                    <li class="active"><a href="/admin/images/index/pid/{{ page.pid }}/page/{{ page.current }}">{{ page.current }}</a></li>
                {% if page.next != page.current %}
                    <li><a href="/admin/images/index/pid/{{ page.pid }}/page/{{ page.next  }}">{{ page.next  }}</a></li>
                {% endif %}
                {% if page.total_pages > page.next  + 1  %}
                    <li><a>...</a></li>
                {% endif %}
                {% if page.total_pages != page.next  %}
                    <li><a href="/admin/images/index/pid/{{ page.pid }}/page/{{ page.total_pages }}">{{ page.total_pages }}</a></li>
                {% endif %}
                <li>
                    <a href="/admin/images/index/pid/{{ page.pid }}/page/{{ page.next }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </div>
        {% endif %}
        <!--------loading------->
         <div class="col-xs-12 text-center loading"  style="margin-top:-20px; display:none;"> 
            <i class="fa fa-pulse fa-spinner  fa-2x"> </i>
        </div>
        <!----------放大图片-------->
        <div class="enlarge"> <img src="/upload/image/shop/0/goods/Jellyfish.jpg"> </div>
        
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>   
        <script src="/js/admin/images.js"> </script>

    </body>
</html>