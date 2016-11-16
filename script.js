( function( $ ) {

    if ( "undefined" === typeof Boxzilla ) {
        return;
    }

    Boxzilla.on( "box.show", function( box ) {

        if ( "undefined" === typeof box.config.class ) {
            return;
        }

        for ( var c in box.config.class ) {
            $( box.element ).addClass( 'boxzilla-' + c + '-' + box.config.class[c] );
        }

    } );

} ) ( jQuery || {} );
