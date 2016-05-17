 $( function(){
        /*---------------打开目录-----------------*/
        $( '#imagesWrap' ).delegate( '.opendir', 'dblclick',  function(){
            var id = this.dataset.id;
            $( '.loading' ).show();
            location = '/admin/images/select/pid/' + id ;
            return false;
        } );
        
        /*---------------点击导航 打开目录-----------------*/
        $( '.folders-nav' ).delegate( '.folder-nav', 'click', function(){
            var id = this.dataset.id;
            $( '.loading' ).show();
            location = '/admin/images/select/pid/' + id;
            return;
        });
        /*--------------选中图片-------------*/  
        $( '#imagesWrap' ).delegate( 'img', 'click', function(){
            var parent = $( this ).parent();
            parent.toggleClass( 'selected' );
            parent.siblings( '.title' ).toggleClass( 'text-success' );
           
        });
 });   
    
function error( msg )
{
    $( '.alert span' ).text( msg );
    $( '.alert' ).show().fadeOut( 3000 );
}

