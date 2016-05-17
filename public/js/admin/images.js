 $( function(){
       $( '#uploadImage' ).click( function(){
            var id = $( '.folder-nav:last' ).attr( 'data-id' ); //最后一个目录，就是当前目录
            location = '/admin/images/upload?id=' + id;
        });
     
        /*---------------双击打开目录-----------------*/
        $( '#imagesWrap' ).delegate( '.opendir', 'dblclick',  function(){
            var id = this.dataset.id;
            $( '.loading' ).show();
            location = '/admin/images/index/pid/' + id ;
            return false;
        } );
        
        //点击导航 打开目录
        $( '.folders-nav' ).delegate( '.folder-nav', 'click', function(){
            var id = this.dataset.id;
            $( '.loading' ).show();
            location = '/admin/images/index?pid=' + id;
            return;
        } );
        
        /*------------------单击选中图片------------------*/
//        $( '#imagesWrap' ).delegate( 'img', 'click',function( event ){
//            var src  = $( this ).attr( 'src' );
//            if( $( '.enlarge' ).is( ':visible' ) && src === $( '.enlarge img' ).attr( 'src' ) )
//            {
//                $( '.enlarge' ).hide();
//                return;
//            }
//            var left = ( event.pageX + 50 ) + 'px'; 
//            var top = ( event.pageY - 50 ) + 'px';
//            
//            $( '.enlarge' ).css( 'left', left );
//            $( '.enlarge' ).css( 'top', top );
//            $( '.enlarge' ).find( 'img' ).attr( 'src', src );
//            $( '.enlarge' ).show();
//        });
        $( '.enlarge' ).delegate( 'img', 'click',function( event ){
            $( '.enlarge' ).hide();
        });
        $( '#imagesWrap' ).delegate( '.thumbnail', 'click', function(){
            $( this ).toggleClass( 'selected' );
            $( this ).siblings( '.title' ).toggleClass( 'text-success' );
        });
       
        //点击删除多个图片和文件夹
        $( '#deleteMore' ).click( function(){
            var arrId = new Array();
            $(  '#imagesWrap .thumbnail.selected' ).each( function(){
                arrId.push( $( this ).attr( 'data-id' ));
            });
            $.post( '/admin/images/deleteMore', {'id':arrId }, function( ret ){
                if( ! ret.status )
                {
                    location.reload();
                }
                else
                {
                    error( ret.msg );
                }
            });
        });
  
        
        /*-------------右键点击， 删除或者重命名----------------*/
        $( '#imagesWrap' ).delegate( '.thumbnail', 'mousedown',function( event ){
            if(  event.button === 2 ) 
            {
                //去掉浏览器默认的右键
                $( this ).bind( 'contextmenu', function(e){ return false; });

                var left = ( event.pageX + 0 ) + 'px'; 
                var top = ( event.pageY - 0 ) + 'px';

                $( '.popupMenu' ).css( 'left', left );
                $( '.popupMenu' ).css( 'top', top );
                $( '.popupMenu' ).show();

                //传递要删除 或者重命名的图片, 文件夹 ,
                $( '#imagesWrap' ).data( 'folder',  this  );
            }
        } );
        
        /*-----------------------新建目录-----------------------*/
        $( '#newFolder' ).click( function(){
            $( '#folderModal' ).find( 'input' ).attr( 'placeholder', '请输入文件夹名' );
            $( '#folderModal' ).modal( 'show' );
            $( '.modal-backdrop' ).removeClass( 'in' ); //去掉阴影
        });
        
        $( 'body').click( function(){
            $( '.popupMenu' ).hide();

        });
        //新建目录,重命名目录 保存
        $( '#folderSave' ).click( function(){
            var folderName = $( '#folderModal' ).find( 'input' ).val();
            if( ! folderName )
            {
                alert( '请输入文件夹名' );
                return false;
            }
            $( '#folderModal' ).modal( 'hide' );
            $( '.loading' ).show();
            var folder = $( '#imagesWrap' ).data( 'folder' );
            if( ! folder ) //新建
            {
                var id = $( '.folder-nav:last' ).attr( 'data-id' ); //当前的目录的id
                $.post( '/admin/images/newFolder', { 'folderName' : folderName, 'pid' : id }, function( ret ){
                    if( ! ret.status )
                    {
                          location.reload();
                    }
                    else
                    {
                        error( ret.msg );
                    }

                }, 'json' );
            }
            else //重命名
            {
                var id = $( folder ).attr( 'data-id' );
                $.post( '/admin/images/rename', { 'folderName' : folderName, 'id' : id }, function( ret ){
                    if( ! ret.status )
                    {
                          location.reload();
                    }
                    else
                    {
                        error( ret.msg );
                    }

                }, 'json' );
            }
            $( '#imagesWrap' ).data( 'folder', '' );
            $( '#folderModal' ).find( 'input' ).val( '' );
        });
        //删除目录
        $( '#folderRemove' ).click( function(){
            var folder = $( '#imagesWrap' ).data( 'folder' );
            if( folder )
            {
                var id = $( folder ).attr( 'data-id' );
                if( confirm( '确定要删除吗?' ))
                {
                    $.post( '/admin/images/delete', { 'id': id }, function( ret ){
                        if( ! ret.status )
                        {
                            $( folder ).parent().remove();//删除自己
                        }
                        else
                        {
                            error( ret.msg );
                        }
                    }, 'json');
                }
            }
            $( '#imagesWrap' ).data( 'folder', '' );
        });
        //重命名目录
        $( '#folderRename' ).click( function(){
            var folder = $( '#imagesWrap' ).data( 'folder' );
            if( $( folder ).hasClass( 'opendir' ) )
            {
                 $( '#folderModal' ).find( 'input' ).attr( 'placeholder', '请输入新的文件夹名' ); 
            }
            else
            {
                 $( '#folderModal' ).find( 'input' ).attr( 'placeholder', '请输入新的图片名' ); 
            }

            $( '#folderModal' ).modal( 'show' );
            $( '.modal-backdrop' ).removeClass( 'in' ); //去掉阴影
        });
    } );
    
    /*------------------图片上传--------------------*/
    
    function error( msg )
    {
        $( '.alert span' ).text( msg );
        $( '.alert' ).show().fadeOut( 3000 );
    }

