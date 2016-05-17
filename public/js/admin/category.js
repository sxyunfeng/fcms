$( function(){
    $( '.modal-body' ).niceScroll();
    /*--------------------搜索属性------------------------*/
    $( '#searchAttr' ).keyup( function(){
        searchAttr();
    });
    $( '#searchAttrClick' ).click( function(){
       searchAttr(); 
    });
    $( '#searchKind' ).keyup( function(){

        searchKind();
    });
    $( '#searchKindClick' ).click( function(){
       searchKind(); 
    });
    //保存属性
    $( '#saveAttr').click( function(){
        var target = $( '.modal-attr' ).data( 'target' );
        if( !target ) { return false; }
        $( '.modal-body span' ).each( function(){
            if( $( this ).hasClass( 'label-success' ) )
            {
                var clone = $( this ).clone();
                $( clone ).removeClass( 'label-success' ).addClass( 'label-default' );
                if( $( target ).attr( 'id' ) === 'addAttr' )
                {
                    $( clone ).find( 'input' ).attr( 'name', 'attrs[]' );
                }
                else if( $( target ).attr( 'id' ) === 'addSpecial' )
                {
                    $( clone ).find( 'input' ).attr( 'name', 'specs[]' );
                }
                $( target ).before( clone );
            }
        });
        $( '.modal-attr' ).modal( 'toggle' );
    });
     //保存规格参数
    $( '#saveKind').click( function(){
        $( '.modal-body dl' ).each( function(){
            if( $( this ).find( '.label' ).hasClass( 'label-success' ) )
            {
                var clone = $( this ).clone();
                $( clone ).find( '.label-default' ).remove();
                $( clone ).find( '.label' ).removeClass( 'label-success' ).addClass( 'label-default' );
                $( clone ).find( 'input' ).attr( 'name', 'ksels[]' );
                $( '#addKind' ).before( clone );
            }
        });
        $( '.modal-kind' ).modal( 'toggle' );
    });
    /*------------------选择属性---------------------*/
    $( '.modal-body' ).delegate( 'span', 'click', function(){
       $( this ).toggleClass( 'label-success' ).toggleClass( 'label-default'); 
       var p = $( this ).parent();
       if( p.is( 'dt' ))
       {
            if( $( this ).hasClass( 'label-success'))
            {
                p.siblings( ).find( '.label-default' ).removeClass( 'label-default' ).addClass( 'label-success' );
            }
            else
            {
                p.siblings( ).find( '.label-success' ).removeClass( 'label-success' ).addClass( 'label-default' );
            }
       }
       else if( p.is( 'dd'))
       {
            if( $( this ).hasClass( 'label-success'))
            {
                p.siblings( 'dt' ).find( '.label-default' ).removeClass( 'label-default' ).addClass( 'label-success' );
            }
            if(  ! p.has( 'span.label-success' ))
            {
                 p.siblings( 'dt' ).find( '.label-success' ).removeClass( 'label-success' ).addClass( 'label-default' );
            }
       }
    });

    $( '.form-special').delegate( 'span', 'mouseover',  function(){
       $( this ).append( '<i style="margin-left:2px;" class="glyphicon glyphicon-remove"></i>' );
       $( this ).toggleClass( 'label-default' ).toggleClass( 'label-info' );
    });
    $( '.form-special' ).delegate( 'span', 'mouseout', function(){
       $( this ).find( 'i' ).remove(); 
       $( this ).toggleClass( 'label-default' ).toggleClass( 'label-info' );
    });
    $( '.form-special' ).delegate( 'span', 'click', function(){
        var p = $( this ).parent();
        if( p.is( 'dt' ))
        {
            p.parent().remove();
        }

        $( this ).remove(); 
    });
    /*----------------添加属性--------------------*/
    $( '#addSpecial' ).click( function(){
       $( '.modal-attr' ).modal( 'show' ); 
       $( '.modal-attr' ).find( '.label-success' ).removeClass( 'label-success' ).addClass( 'label-default' );
       $( '.modal-attr' ).data( 'target', this );
       return false;
    });
    $( '#addAttr' ).click( function(){
       $( '.modal-attr' ).modal( 'show' ); 
       $( '.modal-attr' ).find( '.label-success' ).removeClass( 'label-success' ).addClass( 'label-default' );
       $( '.modal-attr' ).data( 'target', this );
       return false;
    });
    $( '#addKind' ).click( function(){
        $( '.modal-kind' ).modal( 'show' ); 
        $( '.modal-kind' ).find( '.label-success' ).removeClass( 'label-success' ).addClass( 'label-default' );
       return false;
    });
    /*-------------表单数据验证---------------*/
      $( '#cateName' ).blur( function(){
        var name = $( this ).val();
        var oldName = "{{ category[ 'name' ] | e }}";
        var objParent = $( this ).parents( '.form-group' );
        if( name  )
        {
            if( name !== oldName )
            {
                $.post( '/admin/categorys/checkname', { 'name' : name }, function( ret ){
                   if( ret.status )
                   {
                       error( objParent );
                       errorMsg( ret.msg );
                   }
                   else
                   {
                       success( objParent );
                   }
               }, 'json' );
            }
            else
            {
                success( objParent );
            }
        }
        else
        {
           error( objParent );
        }
    });
    
    /* ----------取消---------------*/
    $( '#cancel' ).click( function(){
         location = '/admin/categorys/index';
         return false;
    });
});
    function success( obj )
    {
        obj.find( 'span' ).remove();
        obj.addClass( 'has-success').removeClass('has-error');
        obj.find('.form-control').after( '<span class="glyphicon glyphicon-ok form-control-feedback"></span>' );
    }
    function error( obj )
    {
        obj.find( 'span' ).remove();
        obj.addClass( 'has-error').removeClass('has-success');
        obj.find('.form-control').after( '<span class="glyphicon glyphicon-remove form-control-feedback"></span>' );
    }
    function errorMsg( msg )
    {
        $( '.alert span' ).text( msg );
        $( '.alert' ).show().fadeOut( 3000 );
    }
    var isEnable = true;
    function searchAttr()
    {
        var attr = $( '#searchAttr' ).val();
        if( ! isEnable ){ return false;}
        isEnable = false;
        $.get( '/admin/categorys/searchAttr',{ 'attr' : attr }, function( ret ){
            isEnable = true;    
            if( ! ret.status )
            {
                if(  ret.data.length )
                {
                    $( '.modal-body' ).html( '' );
                    for( var i in ret.data )
                    {
                        var obj = ret.data[ i ];
                        var str = '<span class="label label-default" style="display:inline-block;">' + obj.name + 
                                '<input type="hidden" value="' + obj.id + '"></span>&nbsp;';
                        $( '.modal-body' ).append( str );
                    }
                }

            }
        }, 'json');
    }
    function searchKind()
    {
        var attr = $( '#searchKind' ).val();
        if( ! isEnable ){ return false;}
        isEnable = false;
        $.get( '/admin/categorys/searchKind',{ 'attr' : attr }, function( ret ){
            isEnable = true;    
            if( ! ret.status )
            {
                if(  ret.data.length )
                {
                    $( '.modal-body' ).html( '' );
                    for( var i in ret.data )
                    {
                        var obj = ret.data[ i ];
                        var str = '<dl class="dl-horizontal">'+
                         '<dt><span class="label label-default">' + obj.title  + '</span></dt><dd>'; 
                        var attr = obj.attr;
                        for( var j in attr )
                        {
                            var item = attr[ j ];
                            str += '<span class="label label-default">'+ item.name + '<input type="hidden" value="' + item.id +'"></span>';
                        }
                        str += '</dd></dl>';
                    }
                    $( '.modal-body' ).append( str );
                }

            }
        }, 'json');
    }